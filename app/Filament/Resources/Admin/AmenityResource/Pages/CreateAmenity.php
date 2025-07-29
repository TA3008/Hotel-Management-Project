<?php

namespace App\Filament\Resources\Admin\AmenityResource\Pages;

use App\Filament\Resources\Admin\AmenityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAmenity extends CreateRecord
{
    protected static string $resource = AmenityResource::class;

    public function getBreadcrumb(): string
    {
        return 'Tạo mới tiện ích';
    }

    public function getTitle(): string
    {
        return 'Tạo mới tiện ích: ';
    }
}
