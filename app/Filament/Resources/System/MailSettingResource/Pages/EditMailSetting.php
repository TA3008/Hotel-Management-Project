<?php

namespace App\Filament\Resources\System\MailSettingResource\Pages;

use App\Filament\Resources\System\MailSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMailSetting extends EditRecord
{
    protected static string $resource = MailSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
