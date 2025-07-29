<?php

namespace App\Filament\Resources\System\MailSettingResource\Pages;

use App\Filament\Resources\System\MailSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMailSettings extends ListRecords
{
    protected static string $resource = MailSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
