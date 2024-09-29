<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
use App\Http\Controllers\SocialAuthController;

Route::get('/auth/github', [SocialAuthController::class, 'redirectToGithub'])->name('github.login');
Route::get('/auth/github/callback', [SocialAuthController::class, 'handleGithubCallback']);

Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
