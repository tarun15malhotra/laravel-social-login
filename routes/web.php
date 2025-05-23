<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\SocialAuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/auth/redirect/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/callback/google', [SocialAuthController::class, 'handleGoogleCallback']);


Route::get('/auth/facebook/redirect', [SocialAuthController::class, 'redirectToFacebook']);
Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

Route::get('/auth/github/redirect', [SocialAuthController::class, 'redirectToGithub']);
Route::get('/auth/github/callback', [SocialAuthController::class, 'handleGithubCallback']);

Route::get('auth/linkedin/redirect', [SocialAuthController::class, 'redirectToLinkedin']);
Route::get('auth/linkedin/callback', [SocialAuthController::class, 'handleLinkedinCallback']);

Route::get('/auth/bitbucket/redirect', [SocialAuthController::class, 'redirectToBitbucket']);
Route::get('/auth/bitbucket/callback', [SocialAuthController::class, 'handleBitbucketCallback']);




