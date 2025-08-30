<?php

use App\Http\Controllers\Admin\ImpersonationController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureImpersonating;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', EnsureAdmin::class])->group(function () {
    Route::get('/admin/impersonate', [ImpersonationController::class, 'create'])->name('admin.impersonate.create');
    Route::post('/admin/impersonate', [ImpersonationController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('admin.impersonate.store');
});

Route::middleware(['auth', EnsureImpersonating::class])
    ->post('/impersonate/stop', [ImpersonationController::class, 'destroy'])
    ->name('impersonate.stop');

require __DIR__.'/auth.php';
require __DIR__.'/profile.php';
