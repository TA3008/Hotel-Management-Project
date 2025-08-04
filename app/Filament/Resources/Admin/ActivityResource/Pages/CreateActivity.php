<?php

namespace App\Filament\Resources\Admin\ActivityResource\Pages;

use App\Filament\Resources\Admin\ActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateActivity extends CreateRecord
{
    protected static string $resource = ActivityResource::class;
}
