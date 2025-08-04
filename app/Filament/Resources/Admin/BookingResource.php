<?php

namespace App\Filament\Resources\Admin;

use Filament\Forms;
use App\Models\Room;
use App\Models\Team;
use App\Models\User;
use Filament\Tables;
use App\Models\Branch;
use App\Models\Booking;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\BookingStatusEnum;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\Admin\BookingResource\Pages\EditBooking;
use App\Filament\Resources\Admin\BookingResource\Pages\ListBookings;
use App\Filament\Resources\Admin\BookingResource\Pages\CreateBooking;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Quản lý đặt phòng';
    protected static ?string $navigationLabel = 'Đặt phòng';
    protected static ?string $modelLabel = 'Đặt phòng';

    protected static ?string $tenantOwnershipRelationshipName = 'team';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->with(['bookingDetails.room']);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('customer_id')
                ->label('Khách hàng')
                ->relationship('customer', 'name')
                ->searchable()
                ->required(),

            Select::make('team_id')
                ->label('Khách sạn')
                ->relationship('team', 'name')
                ->searchable()
                ->required(),

            Select::make('branch_id')
                ->label('Chi nhánh')
                ->relationship('branch', 'name')
                ->searchable()
                ->required(),

            Select::make('room_id')
                ->label('Phòng')
                ->options(function (callable $get) {
                    $branchId = $get('branch_id');

                    if (!$branchId) return [];

                    return Room::where('branch_id', $branchId)->pluck('room_number', 'id');
                })
                ->searchable()
                ->required(),

            DatePicker::make('check_in_date')
                ->label('Ngày nhận phòng')
                ->required(),

            DatePicker::make('check_out_date')
                ->label('Ngày trả phòng')
                ->required(),

            Select::make('status')
                ->label('Trạng thái')
                ->options(
                    collect(BookingStatusEnum::cases())->mapWithKeys(fn ($case) => [
                        $case->value => $case->label(),
                    ])->toArray()
                )
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.name')->label('Khách hàng')->sortable()->searchable(),
                TextColumn::make('booking_detail.0.room.room_number')->label('Phòng')->sortable()->searchable(),
                TextColumn::make('branch.name')->label('Chi nhánh')->sortable()->searchable(),
                TextColumn::make('team.name')->label('Khách sạn')->sortable()->searchable(),

                TextColumn::make('check_in_date')
                    ->label('Ngày nhận')
                    ->date('d/m/Y'),

                TextColumn::make('check_out_date')
                    ->label('Ngày trả')
                    ->date('d/m/Y'),

                BadgeColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn (BookingStatusEnum $state) => $state->label())
                    ->color(fn (BookingStatusEnum $state) => match ($state) {
                        BookingStatusEnum::Pending => 'primary',
                        BookingStatusEnum::Confirmed => 'success',
                        BookingStatusEnum::Cancelled, BookingStatusEnum::Refunded => 'danger',
                        BookingStatusEnum::Refunded => 'gray',
                    }),

            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options(
                        collect(BookingStatusEnum::cases())->mapWithKeys(fn ($case) => [
                            $case->value => $case->label(),
                        ])->toArray()
                    ),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookings::route('/'),
            'create' => CreateBooking::route('/create'),
            'edit' => EditBooking::route('/{record}/edit'),
        ];
    }
}
