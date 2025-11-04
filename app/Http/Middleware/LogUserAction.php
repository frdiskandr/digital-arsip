<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\AuditLog;
use Illuminate\Support\Arr;

class LogUserAction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only log mutating HTTP methods
        if (!in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return $response;
        }

        // Only log create/update/delete actions
        $action = $this->describeAction($request);
        if (!in_array($action, ['create', 'update', 'delete'])) {
            return $response;
        }

        // Only log actions performed on Filament resources (admin panel)
        $routeName = $request->route()?->getName();
        $filamentPath = config('filament.path', 'admin');

        $isFilamentResourceRoute = false;
        if ($routeName && Str::startsWith($routeName, 'filament.resources.')) {
            $isFilamentResourceRoute = true;
        }

        if (!$isFilamentResourceRoute) {
            // fallback: check URL path like /admin/resources/{resource}/...
            $path = $request->path();
            if (!Str::startsWith($path, trim($filamentPath, '/') . '/resources/')) {
                return $response;
            }
            $isFilamentResourceRoute = true;
        }

        try {
            $user = $request->user();

            // We intentionally keep logs minimal for resources: no full payload
            $input = null;

            // Try to detect model_type and model_id from route parameters
            $modelType = null;
            $modelId = null;
            $routeParams = $request->route()?->parameters() ?? [];

            foreach ($routeParams as $key => $param) {
                if (is_object($param) && method_exists($param, 'getKey')) {
                    $modelType = get_class($param);
                    $modelId = (string) $param->getKey();
                    break;
                }

                if (Str::endsWith($key, '_id')) {
                    $modelType = Str::studly(Str::beforeLast($key, '_id'));
                    $modelId = (string) $param;
                    break;
                }

                if ($key === 'id' || $key === 'record') {
                    $modelId = (string) $param;
                }
            }

            // Try to infer resource name from route name if possible
            $resourceName = null;
            if ($routeName && Str::startsWith($routeName, 'filament.resources.')) {
                $parts = explode('.', $routeName);
                // filament.resources.{resource}.{page}
                $resourceName = $parts[2] ?? null;
            } else {
                // try path based resource: /admin/resources/{resource}/...
                $segments = explode('/', trim($request->path(), '/'));
                $resIndex = array_search('resources', $segments);
                if ($resIndex !== false && isset($segments[$resIndex + 1])) {
                    $resourceName = $segments[$resIndex + 1];
                }
            }

            AuditLog::create([
                'user_id' => $user?->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'action' => $action,
                'route' => $routeName ?? $request->path(),
                'method' => $request->method(),
                'model_type' => $resourceName ?? $modelType,
                'model_id' => $modelId,
                'changes' => null,
            ]);
        } catch (\Throwable $e) {
            // Don't break the request if logging fails; optionally we could log this to storage
            //
        }

        return $response;
    }

    protected function describeAction(Request $request): string
    {
        $method = $request->method();

        return match ($method) {
            'POST' => 'create',
            'PUT', 'PATCH' => 'update',
            'DELETE' => 'delete',
            default => Str::lower($method),
        };
    }
}
