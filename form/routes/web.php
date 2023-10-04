<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/signup', function () {
    return view('signup_form');
});

Route::get('/login', function () {
    return view('login_form');
});
