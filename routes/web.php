<?php

use App\Jobs\SendBirthdayEmailsJob;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


