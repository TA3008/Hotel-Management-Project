<?php

namespace App\Filament\Resources\Admin\RoleResource\Pages;

use App\Filament\Resources\Admin\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    // Gán role theo tenant_id
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['tenant_id'] = tenant('id') ?? auth()->user()?->tenant_id;

        return $data;
    }
}
