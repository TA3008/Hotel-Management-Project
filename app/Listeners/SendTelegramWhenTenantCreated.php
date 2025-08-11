<?php 
namespace App\Listeners;

use App\Services\TelegramService;
use Stancl\Tenancy\Events\TenantCreated;

class SendTelegramWhenTenantCreated
{
    public function handle(TenantCreated $event)
    {
        $tenant = $event->tenant;
        $message = "🏨 Tenant mới được tạo!\n"
                 . "Tên: {$tenant->name}\n";

        TelegramService::sendMessage($message);
    }
}
