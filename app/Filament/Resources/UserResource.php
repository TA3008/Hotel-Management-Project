<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Người dùng';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required(),

            TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),

            TextInput::make('password')
                ->password()
                ->required(fn (string $context) => $context === 'create') // chỉ bắt buộc khi tạo
                ->dehydrated(fn ($state) => filled($state)) // chỉ lưu nếu có nhập
                ->dehydrateStateUsing(fn ($state) => bcrypt($state)) // mã hóa
                ->label('Mật khẩu'),

            Select::make('roles')
                ->label('Nhóm quyền')
                ->relationship('roles', 'name') // lấy từ quan hệ roles() trong model User
                ->multiple() // nếu muốn chọn nhiều role
                ->preload() // load sẵn roles
                ->visible(fn () => auth()->user()->can('update_role')) // chỉ hiển thị nếu có quyền assign roles,
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tên người dùng')
                    ->searchable()
                    ->sortable()
                    ->limit(20),
                
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('email_verified_at')
                    ->label('Đã xác minh email')
                    ->boolean(),

                TextColumn::make('roles.name')
                    ->label('Vai trò')
                    ->badge()               
                    ->limitList(3)           // giới hạn 3 badge, kéo ra để xem hết
                    ->expandableLimitedList()// cho phép bấm “+n” để bung
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('email_verified_at')
                    ->label('Xác minh email')
                    ->trueLabel('Đã xác minh')
                    ->falseLabel('Chưa xác minh'),
                    
                SelectFilter::make('roles')
                    ->relationship('roles', 'name') 
                    ->label('Vai trò')
                    ->multiple() 
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
