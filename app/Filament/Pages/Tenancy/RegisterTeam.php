<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Hotel;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Thêm mới khách sạn';
    }

    public function form(Form $form): Form
    {
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

    protected function handleRegistration(array $data): Hotel
    {
        $data['user_id'] = auth()->id();

        $hotel = Hotel::create($data);

        $hotel->users()->attach(auth()->user());

        return $hotel;
    }
} 