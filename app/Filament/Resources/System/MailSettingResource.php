<?php

namespace App\Filament\Resources\System;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MailSetting;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\System\MailSettingResource\Pages;
use App\Filament\Resources\MailSettingResource\RelationManagers;

class MailSettingResource extends Resource
{
    protected static ?string $model = MailSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Cài đặt Email';
    protected static ?string $navigationGroup = 'Quản trị hệ thống';
    protected static ?int $navigationSort = 4;

    public static function getBreadcrumb(): string
    {
        return 'Quản lý cài đặt email';
    }

    public static function getNavigationLabel(): string
    {
        return 'Cài đặt email';
    }

    public static function getModelLabel(): string
    {
        return 'Cài đặt email';
    }

    public static function getNavigationUrl(): string
    {
        $record = static::getModel()::first();

        return $record
            ? static::getUrl('edit', ['record' => $record->getKey()])
            : static::getUrl('create');
    }

    public static function canViewAny(): bool
{
    return true;
}


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('host')
                    ->label('Máy chủ SMTP')
                    ->required(),
                TextInput::make('port')
                    ->label('Cổng SMTP')
                    ->required()
                    ->numeric(),
                TextInput::make('username')
                    ->label('Tên đăng nhập')
                    ->required(),
                TextInput::make('password')
                    ->label('Mật khẩu')
                    ->password()
                    ->required(),
                TextInput::make('from_email')
                    ->label('Email gửi đi')
                    ->email()
                    ->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('host')->label('Máy chủ SMTP'),
                TextColumn::make('port')->label('Cổng SMTP'),
                TextColumn::make('username')->label('Tài khoản'),
                TextColumn::make('from_email')->label('Email gửi đi'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListMailSettings::route('/'),
            'create' => Pages\CreateMailSetting::route('/create'),
            'edit' => Pages\EditMailSetting::route('/{record}/edit'),
        ];
    }
}
