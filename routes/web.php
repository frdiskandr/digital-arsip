<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArsipViewController;
use App\Http\Controllers\ArsipDownloadController;

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

// Route for viewing/previewing files
Route::get('/arsip/view/{record}', ArsipViewController::class)
    ->name('arsip.view')
    ->middleware('auth');

// Route for force-downloading files
Route::get('/arsip/download/{record}', ArsipDownloadController::class)
    ->name('arsip.download')
    ->middleware('auth');

// Route for downloading specific historical versions
Route::get('/arsip-version/download/{version}', \App\Http\Controllers\ArsipVersionDownloadController::class)
    ->name('arsip.version.download')
    ->middleware('auth');
