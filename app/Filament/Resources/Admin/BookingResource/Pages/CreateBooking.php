<?php

namespace App\Filament\Resources\Admin\BookingResource\Pages;

use App\Filament\Resources\Admin\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;
}
