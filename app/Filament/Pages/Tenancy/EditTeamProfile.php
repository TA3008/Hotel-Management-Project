<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Team;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Pages\Tenancy\EditTenantProfile;

class EditTeamProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Team Profile';
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->label('Tên khách sạn')
                ->unique(Team::class, 'name', ignoreRecord: true),

            TextInput::make('email')
                ->email()
                ->required()
                ->label('Email')
                ->unique(Team::class, 'email', ignoreRecord: true),

            TextInput::make('phone')
                ->label('Số điện thoại')
                ->required()
                ->unique(Team::class, 'phone', ignoreRecord: true),

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
                ->directory('teams/logos'),
        ]);
    }
}