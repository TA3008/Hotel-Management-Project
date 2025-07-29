<?php

namespace App\Filament\Resources\Admin;

use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\CustomerTypeEnum;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\Admin\CustomerResource\Pages;
use App\Filament\Resources\Admin\CustomerResource\Pages\EditCustomer;
use App\Filament\Resources\Admin\CustomerResource\Pages\ListCustomers;
use App\Filament\Resources\Admin\CustomerResource\Pages\CreateCustomer;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Quản lý đặt phòng';
    protected static ?string $navigationLabel = 'Khách hàng';
    protected static ?string $modelLabel = 'Khách hàng';

    protected static ?string $tenantOwnershipRelationshipName = 'team';

    public static function form(Form $form): Form
    {
        $isEdit = request()->routeIs('filament.admin.resources.customers.edit');

    return $form->schema([
        TextInput::make('name')
            ->required()
            ->label('Tên khách hàng')
            ->disabled($isEdit),

        TextInput::make('email')
            ->email()
            ->required()
            ->disabled($isEdit),

        TextInput::make('password')
            ->password()
            ->required()
            ->dehydrated(fn ($state) => filled($state)) // chỉ cập nhật nếu có nhập
            ->label('Mật khẩu')
            ->disabled($isEdit),

        TextInput::make('phone')
            ->required()
            ->label('Số điện thoại')
            ->disabled($isEdit),

        TextInput::make('address')
            ->label('Địa chỉ')
            ->disabled($isEdit),

        TextInput::make('identity_number')
            ->label('CMND/CCCD')
            ->disabled($isEdit),

        Select::make('customer_type')
            ->label('Loại khách hàng')
            ->options(collect(CustomerTypeEnum::cases())->mapWithKeys(fn ($case) => [
                $case->value => $case->label(),
            ])->toArray())
            ->required()
            ->disabled($isEdit),
    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tên'),
                TextColumn::make('email'),
                TextColumn::make('phone')->label('Điện thoại'),
                TextColumn::make('address')->label('Địa chỉ'),
                TextColumn::make('customer_type')
                    ->label('Loại')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'regular' => 'gray',
                        'vip' => 'success',
                    })
                    ->formatStateUsing(fn (string $state) => CustomerTypeEnum::from($state)->label()),
            ])
            ->filters([
                SelectFilter::make('customer_type')
                    ->label('Loại khách hàng')
                    ->options(
                        collect(CustomerTypeEnum::cases())->mapWithKeys(fn ($case) => [
                            $case->value => $case->label(),
                        ])->toArray()
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
