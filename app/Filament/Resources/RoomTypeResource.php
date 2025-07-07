<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\RoomType;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\DeleteAction;
use App\Filament\Resources\RoomTypeResource\Pages;

class RoomTypeResource extends Resource
{
    protected static ?string $model = RoomType::class;
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = 'Quản lý khách sạn';
    protected static ?string $navigationLabel = 'Loại phòng';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->label('Tên loại phòng')->required(),
            TextInput::make('price')->label('Giá')->numeric()->required(),
            TextInput::make('bed_count')->label('Số giường')->numeric()->required(),
            RichEditor::make('description')
                ->label('Mô tả')
                ->disableToolbarButtons(['attachFiles'])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tên loại phòng')->searchable()->sortable(),
                TextColumn::make('price')->label('Giá')->money('VND'),
                TextColumn::make('bed_count')->label('Số giường'),
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
            'index' => Pages\ListRoomTypes::route('/'),
            'create' => Pages\CreateRoomType::route('/create'),
            'edit' => Pages\EditRoomType::route('/{record}/edit'),
        ];
    }
}

