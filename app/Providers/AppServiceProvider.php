<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;
use Livewire\Livewire;
use Illuminate\Support\Str;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Provide compatibility aliases for packages that expect older Filament class locations.
        // Some third-party packages reference Get/Set under Filament\Schemas; newer Filament
        // exposes them under Filament\Forms. Create class aliases so both work.
        if (! class_exists('Filament\\Schemas\\Components\\Utilities\\Get') && class_exists(\Filament\Forms\Get::class)) {
            class_alias(\Filament\Forms\Get::class, 'Filament\\Schemas\\Components\\Utilities\\Get');
        }

        if (! class_exists('Filament\\Schemas\\Components\\Utilities\\Set') && class_exists(\Filament\Forms\Set::class)) {
            class_alias(\Filament\Forms\Set::class, 'Filament\\Schemas\\Components\\Utilities\\Set');
        }

        Schema::defaultStringLength(191);
        FilamentView::registerRenderHook(
            'panels::head.end',
            fn(): HtmlString => new HtmlString('<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
            '),
        );

        // Auto-register Livewire components located under App\Http\Livewire so that
        // client-side component names (dotted/kebab) are resolvable during XHRs.
        $livewireDir = app_path('Http/Livewire');
        if (is_dir($livewireDir)) {
            $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($livewireDir));
            foreach ($rii as $file) {
                if (! $file->isFile() || $file->getExtension() !== 'php') continue;

                // Build FQCN from file path, e.g. App\Http\Livewire\Sub\MyComponent
                $relative = str_replace($livewireDir . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $class = 'App\\Http\\Livewire\\' . str_replace([DIRECTORY_SEPARATOR, '.php'], ['\\', ''], $relative);

                if (! class_exists($class)) continue;

                // Generate a dotted kebab name matching Livewire's conventions
                $segments = explode('\\', trim($class, '\\'));
                $kebab = array_map(fn($s) => Str::kebab($s), $segments);
                $name = implode('.', $kebab);

                Livewire::component($name, $class);
            }
        }
    }
}
