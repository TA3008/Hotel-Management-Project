<?php

namespace App\Filament\Resources\Admin\BookingStaffAssignmentResource\Pages;

use App\Filament\Resources\Admin\BookingStaffAssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListBookingStaffAssignments extends ListRecords
{
    protected static string $resource = BookingStaffAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        // Nếu không phải super-admin thì chỉ hiển thị nhiệm vụ của chính họ
        if (!auth()->user()->hasRole('super_admin')) {
            $query->where('staff_id', auth()->id());
        }

        return $query;
    }
}
