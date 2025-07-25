<?php

use App\Jobs\SendBirthdayEmailsJob;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-mail-config', function () {
    return [
        'host' => config('mail.mailers.smtp.host'),
        'port' => config('mail.mailers.smtp.port'),
        'username' => config('mail.mailers.smtp.username'),
        'from_address' => config('mail.from.address'),
        'from_name' => config('mail.from.name'),
    ];
});

