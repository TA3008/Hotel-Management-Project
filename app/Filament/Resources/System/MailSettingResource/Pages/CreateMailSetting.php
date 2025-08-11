<?php

namespace App\Filament\Resources\System\MailSettingResource\Pages;

use App\Filament\Resources\System\MailSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMailSetting extends CreateRecord
{
    protected static string $resource = MailSettingResource::class;

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canCreateAnother(): bool
    {
        return MailSettingResource::getModel()::count() === 0;
    }
}
