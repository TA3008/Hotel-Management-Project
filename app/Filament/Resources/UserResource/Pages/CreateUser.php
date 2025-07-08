<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Stancl\Tenancy\Database\Models\Tenant;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (auth()->check()) {
            // Chủ khách sạn đang login → tạo nhân viên
            $data['tenant_id'] = auth()->user()->tenant_id;

        } else {
            // Chủ khách sạn tự đăng ký → tạo tenant mới
            $tenant = new \Stancl\Tenancy\Database\Models\Tenant();
            $tenant->id = \Str::uuid();
            $tenant->data = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];
            $tenant->save();

            $data['tenant_id'] = $tenant->id;
        }

        return $data;
    }

}
