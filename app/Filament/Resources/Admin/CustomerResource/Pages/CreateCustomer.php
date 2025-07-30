<?php

namespace App\Filament\Resources\Admin\CustomerResource\Pages;

use App\Filament\Resources\Admin\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}
