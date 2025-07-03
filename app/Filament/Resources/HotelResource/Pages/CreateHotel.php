<?php

namespace App\Filament\Resources\HotelResource\Pages;

use App\Filament\Resources\HotelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHotel extends CreateRecord
{
    protected static string $resource = HotelResource::class;
    
    public function getBreadcrumb(): string
    {
        return 'Tạo mới khách sạn';
    }

    public function getTitle(): string
    {
        return 'Tạo mới khách sạn: ';
    }
}
