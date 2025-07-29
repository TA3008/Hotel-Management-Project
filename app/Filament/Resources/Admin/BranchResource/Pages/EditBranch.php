<?php

namespace App\Filament\Resources\Admin\BranchResource\Pages;

use App\Filament\Resources\Admin\BranchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBranch extends EditRecord
{
    protected static string $resource = BranchResource::class;

    public function getBreadcrumb(): string
    {
        return 'Chỉnh sửa chi nhánh';
    }

    public function getTitle(): string
    {
        return 'Chỉnh sửa chi nhánh: ' . $this->record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
