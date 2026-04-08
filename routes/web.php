<?php

use Illuminate\Support\Facades\Route;


Route::livewire('/login', 'pages::login');

Route::middleware('auth')->group(function() {
    Route::livewire('/', 'pages::home');
});