<?php

namespace App\Filament\Resources\Admin\BranchResource\Pages;

use App\Filament\Resources\Admin\BranchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBranches extends ListRecords
{
    protected static string $resource = BranchResource::class;

    public function getBreadcrumb(): string
    {
        return 'Danh sách chi nhánh';
    }

    public function getTitle(): string
    {
        return 'Danh sách chi nhánh';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
