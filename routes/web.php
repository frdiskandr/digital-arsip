<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Backwards-compatible alias for Filament profile auth route.
// Filament expects a route named `filament.{panelId}.auth.profile` in some places
// (for example when building the user menu). The Panel already registers
// the profile page as a regular page route (filament.{panelId}.profile), so
// provide a small redirect route that has the expected name.
Route::get('admin/auth/profile', function () {
    return redirect()->route('filament.admin.profile');
})->name('filament.admin.profile');


// Temporary debug route to help diagnose auth/session/DB issues on servers (remove after use)
Route::get('/debug-app', function (Illuminate\Http\Request $request) {
    if (!config('app.debug')) {
        abort(404);
    }

    $email = $request->query('email');
    $password = $request->query('password');

    $result = [];

    // Basic app/env info
    $result['app_env'] = config('app.env');
    $result['app_debug'] = config('app.debug');
    $result['app_url'] = config('app.url');
    $result['app_key_present'] = !empty(env('APP_KEY'));

    // Session config
    $result['session_driver'] = config('session.driver');
    $result['session_cookie'] = config('session.cookie');
    $result['session_domain'] = config('session.domain');
    $result['session_secure_cookie'] = config('session.secure_cookie');
    $result['session_table_exists'] = Illuminate\Support\Facades\Schema::hasTable('sessions');

    // Storage & permissions
    $result['storage_writable'] = is_writable(storage_path());
    $result['bootstrap_cache_writable'] = is_writable(base_path('bootstrap/cache'));

    // Request / proxy headers
    $result['request_host'] = $request->getHost();
    $result['request_scheme'] = $request->getScheme();
    $result['x_forwarded_proto'] = $request->headers->get('x-forwarded-proto');
    $result['cookies'] = $request->cookies->all();

    // DB connectivity and counts
    try {
        Illuminate\Support\Facades\DB::connection()->getPdo();
        $result['db_connected'] = true;
        try {
            $result['users_count'] = App\Models\User::count();
        } catch (Throwable $e) {
            $result['users_count_error'] = $e->getMessage();
        }
    } catch (Throwable $e) {
        $result['db_connected'] = false;
        $result['db_error'] = $e->getMessage();
    }

    // If email provided, show user and password check (BE CAREFUL: do not expose in public)
    if ($email) {
        try {
            $user = App\Models\User::where('email', $email)->first();
            $result['user_found'] = $user ? true : false;
            if ($user) {
                $result['user'] = [
                    'id' => $user->id,
                    'email' => $user->email,
                    'password_hash_length' => (int) strlen($user->password),
                ];
                if ($password) {
                    $result['password_match'] = Illuminate\Support\Facades\Hash::check($password, $user->password);
                }
            }
        } catch (Throwable $e) {
            $result['user_error'] = $e->getMessage();
        }
    }

    return response()->json($result);
});



Route::get('/make-admin', function (Illuminate\Http\Request $req) {
    if (!config('app.debug')) {
        abort(404);
    }

    $secret = env('MAKE_ADMIN_KEY'); // set di .env di server
    if (!$secret || $req->query('key') !== $secret) {
        abort(403);
    }

    $email = $req->query('email') ?? 'fariditb159@gmail.com';
    $password = $req->query('password') ?? 'Faridiskandar123';

    $user = \App\Models\User::firstOrCreate(
        ['email' => $email],
        [
            'name' => 'Admin',
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'email_verified_at' => now(),
        ]
    );

    return response()->json([
        'created' => $user->wasRecentlyCreated ?? false,
        'id' => $user->id,
        'email' => $user->email,
    ]);
});
