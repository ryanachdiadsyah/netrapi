<?php

use App\Http\Controllers\AdifUploaderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventHomepageController;
use Illuminate\Support\Facades\Route;

// Middleware guest
Route::middleware('guest')->group(function () {

    // Delete Soon
    Route::get('login', function () {
        return view('maintetance');
    })->name('login');

    Route::get('register', function () {
        return view('maintetance');
    })->name('register');

    Route::get('/', function () {
        return view('maintetance');
    })->name('welcome');

    Route::get('event', function () {
        return view('maintetance');
    })->name('event');

    Route::get('uploader-adif', [AdifUploaderController::class, 'index'])->name('uploader-adif');
    Route::post('uploader-adif', [AdifUploaderController::class, 'upload'])->name('uploader-adif.handle');

    // Route::get('login', [AuthController::class, 'loginPage'])->name('login');
    // Route::post('login', [AuthController::class, 'handleLogin'])->name('login.handle');
    // Route::get('register', [AuthController::class, 'registerPage'])->name('register');
    // Route::post('register', [AuthController::class, 'handleRegister'])->name('register.handle');

    // Route::get('/', function () {
    //     return view('welcome');
    // })->name('welcome');

    // Route::get('event', [EventHomepageController::class, 'allEvent'])->name('event');
    Route::get('event/{slug}', [EventHomepageController::class, 'eventDetails'])->name('event.details');
    Route::get('/event/{id}/certificate/{callsign}', [EventHomepageController::class, 'certificatePreview'])->name('event.download');
});
// Middleware auth
Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('dashboard', function () {
        return view('app.dashboard');
    })->name('dashboard');

});
