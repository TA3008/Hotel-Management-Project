<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Branch;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\DeleteAction;
use App\Filament\Resources\BranchResource\Pages;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'Quản lý khách sạn';
    protected static ?string $navigationLabel = 'Chi nhánh';
    protected static ?int $navigationSort = 2;

    protected static ?string $tenantOwnershipRelationshipName = 'hotel';

    public static function getBreadcrumb(): string
    {
        return 'Chi nhánh';
    }

    public static function getNavigationLabel(): string
    {
        return 'Chi nhánh';
    }

    public static function getModelLabel(): string
    {
        return 'Chi nhánh';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('hotel_id')
                ->label('Khách sạn')
                ->relationship('hotel', 'name')
                ->required(),

            TextInput::make('name')->label('Tên chi nhánh')->required(),
            TextInput::make('address')->label('Địa chỉ')->required(),
            TextInput::make('phone')->label('SĐT'),
            TextInput::make('email')->label('Email')->email(),
            RichEditor::make('description')->label('Mô tả')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchPlaceholder('Tìm kiếm tên, SĐT, địa chỉ...')
            ->columns([
                TextColumn::make('hotel.name')->label('Khách sạn')->searchable(),
                TextColumn::make('name')->label('Tên chi nhánh')->searchable()->sortable(),
                TextColumn::make('address')->label('Địa chỉ')->searchable(),
                TextColumn::make('phone')->label('SĐT')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
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
            'index' => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
