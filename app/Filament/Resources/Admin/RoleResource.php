<?php

namespace App\Filament\Resources\Admin;

use Filament\Forms;
use App\Models\Role;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Spatie\Permission\Models\Permission;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\Admin\RoleResource\Pages;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Phân quyền';
    protected static ?string $navigationGroup = 'Quản trị hệ thống';
    protected static ?int $navigationSort = 2;

    protected static ?string $tenantOwnershipRelationshipName = 'team';

    public static function form(Form $form): Form
    {
        $groupedPermissions = Permission::all()
            ->groupBy(function ($permission) {
                // Nhóm theo tiền tố (ví dụ: "room", "booking", "user")
                return ucfirst(explode('_', $permission->name)[count(explode('_', $permission->name)) - 1]);
            });

        $permissionFields = [];

        foreach ($groupedPermissions as $group => $permissions) {
            $permissionFields[] = Fieldset::make($group)
                ->schema([
                    CheckboxList::make('permissions')
                        ->label(false)
                        ->relationship('permissions', 'name')
                        ->options($permissions->pluck('name', 'id')->toArray())
                        ->columns(4)
                        ->bulkToggleable(true),
                ]);
        }

        return $form->schema(array_merge([
            TextInput::make('name')->label('Tên vai trò')->required(),
        ], $permissionFields));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('permissions.name')
                    ->label('Quyền')
                    ->badge()
                    ->limitList(5)
                    ->expandableLimitedList(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
