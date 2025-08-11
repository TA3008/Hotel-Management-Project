<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Database\Models\Tenant;

class TelegramServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Lắng nghe sự kiện khi tạo tenant mới
        Tenant::created(function ($tenant) {
            $this->sendTelegramMessage("🔔 Tenant mới được tạo: {$tenant->name}");
        });
    }

    protected function sendTelegramMessage(string $message): void
    {
        $token = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (!$token || !$chatId) {
            return;
        }

        Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text'    => $message
        ]);
    }
}
