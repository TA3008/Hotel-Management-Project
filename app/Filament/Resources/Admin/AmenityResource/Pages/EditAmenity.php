<?php

namespace App\Filament\Resources\Admin\AmenityResource\Pages;

use App\Filament\Resources\Admin\AmenityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAmenity extends EditRecord
{
    protected static string $resource = AmenityResource::class;

    public function getBreadcrumb(): string
    {
        return 'Chỉnh sửa tiện ích';
    }

    public function getTitle(): string
    {
        return 'Chỉnh sửa tiện ích: ' . $this->record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
