<?php

namespace App\Filament\Resources\Admin;

use App\Models\Amenity;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use App\Filament\Resources\Admin\AmenityResource\Pages;

class AmenityResource extends Resource
{
    protected static ?string $model = Amenity::class;
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Quản lý khách sạn';
    protected static ?string $navigationLabel = 'Tiện ích';
    protected static ?int $navigationSort = 4;

    protected static ?string $tenantOwnershipRelationshipName = 'team';

    public static function getBreadcrumb(): string
    {
        return 'Tiện ích';
    }

    public static function getNavigationLabel(): string
    {
        return 'Tiện ích';
    }

    public static function getModelLabel(): string
    {
        return 'Tiện ích';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->label('Tên tiện ích')->required(),
            TextInput::make('icon')->label('Icon')->placeholder('heroicon-o-wifi hoặc fa fa-car')->nullable(),
            TextInput::make('description')->label('Mô tả')->nullable()->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tên')->searchable(),
                TextColumn::make('icon')->label('Icon'),
                TextColumn::make('created_at')->label('Ngày tạo')->dateTime('d/m/Y H:i'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAmenities::route('/'),
            'create' => Pages\CreateAmenity::route('/create'),
            'edit' => Pages\EditAmenity::route('/{record}/edit'),
        ];
    }
}
