<?php

namespace App\Filament\Resources\Admin\BookingStaffAssignmentResource\Pages;

use App\Filament\Resources\Admin\BookingStaffAssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookingStaffAssignments extends ListRecords
{
    protected static string $resource = BookingStaffAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
