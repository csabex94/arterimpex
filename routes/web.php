<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/oauth/google/redirect', [AuthController::class, 'redirect']);
Route::get('/oauth/google/callback', [AuthController::class, 'callback']);

Route::livewire('/login', 'pages::login');

Route::middleware('auth')->group(function() {
    Route::livewire('/', 'pages::home');
});