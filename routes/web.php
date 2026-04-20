<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/oauth/google/redirect', [AuthController::class, 'redirect'])->name('oauth.google.redirect');
Route::get('/oauth/google/callback', [AuthController::class, 'callback'])->name('oauth.google.callback');

Route::livewire('/login', 'pages::login')->name('login.page');

Route::middleware('auth')->group(function() {
    Route::livewire('/', 'pages::home')->name('home.page');
    Route::livewire('/departments', 'pages::departments')->name('departments.page');
    Route::livewire('/printers', 'pages::printers')->name('printers.page');
    Route::livewire('/maintainers', 'pages::maintainers')->name('maintainers.page');
    Route::livewire('/scales', 'pages::scales')->name('scales.page');
    Route::livewire('/pdas', 'pages::pdas')->name('pdas.page');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.action');
});
