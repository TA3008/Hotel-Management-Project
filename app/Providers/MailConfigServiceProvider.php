<?php

namespace App\Providers;

use App\Models\MailSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Lấy mail setting mới nhất
        $mailSetting = MailSetting::first();

        if ($mailSetting) {
            Config::set('mail.mailers.smtp.host', $mailSetting->host);
            Config::set('mail.mailers.smtp.port', $mailSetting->port);
            Config::set('mail.mailers.smtp.username', $mailSetting->username);
            Config::set('mail.mailers.smtp.password', $mailSetting->password);
            Config::set('mail.from.address', $mailSetting->from_email);
        }
    }
}
