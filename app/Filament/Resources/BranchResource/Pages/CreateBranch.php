<?php

namespace App\Filament\Resources\BranchResource\Pages;

use App\Filament\Resources\BranchResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBranch extends CreateRecord
{
    protected static string $resource = BranchResource::class;

    public function getBreadcrumb(): string
    {
        return 'Tạo mới chi nhánh';
    }
    
    public function getTitle(): string
    {
        return 'Tạo mới chi nhánh: ';
    }
}
