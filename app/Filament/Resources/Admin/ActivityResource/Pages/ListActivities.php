<?php

namespace App\Filament\Resources\Admin\ActivityResource\Pages;

use App\Filament\Resources\Admin\ActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListActivities extends ListRecords
{
    protected static string $resource = ActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
