<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/soal1');
});

Route::get('/soal1', function () {
    return view('welcome');
});

Route::get('/soal2', function () {
    return view('soal2');
});
