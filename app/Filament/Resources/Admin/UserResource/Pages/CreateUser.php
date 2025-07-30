<?php

namespace App\Filament\Resources\Admin\UserResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use App\Filament\Resources\Admin\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Stancl\Tenancy\Database\Models\Tenant;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
