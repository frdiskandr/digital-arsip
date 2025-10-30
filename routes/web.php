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
