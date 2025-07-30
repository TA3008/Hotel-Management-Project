<?php

use App\Jobs\SendBirthdayEmailsJob;
use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use App\Providers\MailConfigServiceProvider;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Middleware\InitializeTenancyFromUser;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'super_admin' => SuperAdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        // Chạy job gửi mail sinh nhật vào 0h mỗi ngày
        $schedule->job(new SendBirthdayEmailsJob)->dailyAt('00:00');
    })
    ->withProviders([
        MailConfigServiceProvider::class,
    ])
    ->create();
