<?php

namespace App\Filament\Resources\Admin;

use Filament\Forms;
use Filament\Tables;
use App\Models\Voucher;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Select;
use App\Enums\VoucherStatusEnum;
use Filament\Resources\Resource;
use Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Admin\VoucherResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Admin\VoucherResource\RelationManagers;

class VoucherResource extends Resource
{
    protected static ?string $model = Voucher::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Quản lý khách sạn';
    protected static ?int $navigationSort = 5;

    protected static ?string $tenantOwnershipRelationshipName = 'team';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Mã voucher')
                    ->required()
                    ->unique()
                    ->maxLength(50),
                Select::make('type')
                    ->label('Loại giảm giá')
                    ->enum(VoucherTypeEnum::class)
                    ->options(VoucherTypeEnum::class)
                    ->default(VoucherTypeEnum::Fixed)
                    ->required(),
                TextInput::make('amount')
                    ->label('Giá trị giảm')
                    ->numeric()
                    ->required()
                    ->maxLength(10),
                TextInput::make('min_order_value')
                    ->label('Giá trị đơn tối thiểu để áp dụng')
                    ->numeric()
                    ->nullable()
                    ->maxLength(10),
                TextInput::make('max_uses')
                    ->label('Tổng số lượt sử dụng')
                    ->numeric()
                    ->nullable()
                    ->maxLength(10),
                DateTimePicker::make('starts_at')
                    ->label('Ngày bắt đầu')
                    ->nullable(),
                DateTimePicker::make('expires_at')
                    ->label('Ngày kết thúc')
                    ->nullable(),
                Select::make('status')
                    ->label('Trạng thái')
                    ->enum(VoucherStatusEnum::class)
                    ->options(VoucherStatusEnum::class)
                    ->default(VoucherStatusEnum::Active)
                    ->required(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Mã voucher')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Loại')
                    ->formatStateUsing(function ($state) {
                        if ($state instanceof \App\Enums\VoucherTypeEnum) {
                            return $state->label();
                        }

                        return \App\Enums\VoucherTypeEnum::tryFrom($state)?->label() ?? $state;
                    })
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('Giá trị giảm')
                    ->money('VND', true),

                TextColumn::make('min_order_value')
                    ->label('Đơn tối thiểu')
                    ->money('VND', true),

                TextColumn::make('max_uses')
                    ->label('Lượt dùng tối đa'),

                TextColumn::make('used_count')
                    ->label('Đã dùng'),

                TextColumn::make('starts_at')
                    ->label('Bắt đầu')
                    ->dateTime('d/m/Y H:i'),

                TextColumn::make('expires_at')
                    ->label('Kết thúc')
                    ->dateTime('d/m/Y H:i'),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn (VoucherStatusEnum $state) => $state->label())
                    ->badge()
                    ->color(fn (VoucherStatusEnum $state) => match ($state) {
                        VoucherStatusEnum::Active => 'success',
                        VoucherStatusEnum::Inactive => 'danger',
                        VoucherStatusEnum::Expired => 'warning',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options(VoucherStatusEnum::class),
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
            'index' => Pages\ListVouchers::route('/'),
            'create' => Pages\CreateVoucher::route('/create'),
            'edit' => Pages\EditVoucher::route('/{record}/edit'),
        ];
    }
}
