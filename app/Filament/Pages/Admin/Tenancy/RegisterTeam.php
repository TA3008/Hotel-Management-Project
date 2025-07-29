<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Team;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
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

            FileUpload::make('image')
                ->label('Ảnh đại diện')
                ->disk('s3')
                ->image()
                ->getUploadedFileNameForStorageUsing(fn ($file, $record) =>
                        FileNameHelper::aliasImageName($file, $record) 
                        ?? 'default.png')
                ->directory('teams/images'),
        ]);
    }

    protected function handleRegistration(array $data): Team
    {
        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';

        $team = Team::create($data);

        $team->users()->attach(auth()->user());

        return $team;
    }

    protected function afterTenantRegistered(): void
    {
        $this->notify('success', 'Đăng ký thành công! Vui lòng đợi quản trị viên xác thực tài khoản.');
    }

} 