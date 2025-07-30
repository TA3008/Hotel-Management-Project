<?php

namespace App\Filament\Resources\Admin;

use Filament\Forms;
use Filament\Tables;
use App\Models\RoomType;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Helpers\FileNameHelper;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\Admin\RoomTypeResource\Pages;
use App\Filament\Resources\Admin\RoomTypeResource\Pages\EditRoomType;
use App\Filament\Resources\Admin\RoomTypeResource\Pages\ListRoomTypes;
use App\Filament\Resources\Admin\RoomTypeResource\Pages\CreateRoomType;

class RoomTypeResource extends Resource
{
    protected static ?string $model = RoomType::class;
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = 'Quản lý khách sạn';
    protected static ?string $navigationLabel = 'Loại phòng';
    protected static ?int $navigationSort = 4;

    protected static ?string $tenantOwnershipRelationshipName = 'team';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->label('Tên loại phòng')->required(),
            TextInput::make('price')->label('Giá')->numeric()->required(),
            TextInput::make('bed_count')->label('Số giường')->numeric()->required(),
            FileUpload::make('image')
                ->label('Ảnh đại diện')
                ->disk('s3') 
                ->visibility('public')
                ->directory('room_types/images')
                ->getUploadedFileNameForStorageUsing(fn ($file, $record) =>
                        FileNameHelper::aliasImageName($file, $record) 
                        ?? 'default.png')
                ->image(),
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
                ImageColumn::make('image')
                    ->label('Ảnh đại diện')
                    ->circular()
                    ->size(50)
                    ->getStateUsing(fn ($record) => $record->image 
                        ? Storage::disk('s3')->url($record->image)
                        : null),
                TextColumn::make('description')->label('Mô tả')->limit(50),
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

