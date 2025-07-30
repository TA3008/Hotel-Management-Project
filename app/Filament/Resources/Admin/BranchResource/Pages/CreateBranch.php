<?php

namespace App\Filament\Resources\Admin\BranchResource\Pages;

use App\Filament\Resources\Admin\BranchResource;
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
