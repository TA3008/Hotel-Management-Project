<?php

namespace App\Filament\Resources;

use tenant;
use Filament\Forms;
use Filament\Tables;
use App\Models\Hotel;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HotelResource\Pages;

class HotelResource extends Resource
{
    protected static ?string $model = Hotel::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Quản lý khách sạn';
    protected static ?string $navigationLabel = 'Khách sạn';
    protected static ?int $navigationSort = 2;
    
    public static function getBreadcrumb(): string
    {
        return 'Khách sạn';
    }

    public static function getNavigationLabel(): string
    {
        return 'Khách sạn';
    }

    public static function getModelLabel(): string
    {
        return 'Khách sạn';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
        ->where('id', tenant()->id);
    }

    public static function form(Form $form): Form
    {
        //dd(tenant());
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->label('Tên khách sạn')
                ->unique(Hotel::class, 'name', ignoreRecord: true),

            TextInput::make('email')
                ->email()
                ->required()
                ->label('Email')
                ->unique(Hotel::class, 'email', ignoreRecord: true),

            TextInput::make('phone')
                ->label('Số điện thoại')
                ->required()
                ->unique(Hotel::class, 'phone', ignoreRecord: true),

            TextInput::make('address')
                ->label('Địa chỉ')
                ->nullable(),

            RichEditor::make('description')
                ->label('Mô tả')
                ->disableToolbarButtons(['attachFiles'])
                ->columnSpanFull(),

            FileUpload::make('logo')
                ->label('Logo')
                ->image()
                ->directory('hotels/logos'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tên khách sạn')->searchable()->sortable(),
                TextColumn::make('phone')->label('SĐT'),
                TextColumn::make('email')->label('Email'),
                ImageColumn::make('logo')->label('Logo')->circular(),
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
            'index' => Pages\ListHotels::route('/'),
            'create' => Pages\CreateHotel::route('/create'),
            'edit' => Pages\EditHotel::route('/{record}/edit'),
        ];
    }
}
