<?php

use Illuminate\Support\Facades\Route;

Route::get('/soal1', function () {
    return view('welcome');
});

Route::get('/soal2',function(){
    return view('soal2');
});