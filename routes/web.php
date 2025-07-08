<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return [
        'user_id' => auth()->id(),
        'tenant_id_from_user' => auth()->user()?->tenant_id,
        'tenant() helper' => tenant()?->id,
    ];
});
