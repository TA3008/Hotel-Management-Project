<?php

namespace App\Filament\Resources\Admin;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Enums\BookingStaffTaskEnum;
use Filament\Forms\Components\Select;
use App\Models\BookingStaffAssignment;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\Admin\BookingStaffAssignmentResource\Pages;

class BookingStaffAssignmentResource extends Resource
{
    protected static ?string $model = BookingStaffAssignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Quản lý đặt phòng';
    protected static ?string $navigationLabel = 'Phân công nhân viên';
    protected static ?string $pluralModelLabel = 'Phân công nhân viên';
    protected static ?string $modelLabel = 'Phân công nhân viên';

    protected static ?string $tenantOwnershipRelationshipName = 'team';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('staff_id')
                    ->label('Nhân viên')
                    ->relationship('staff', 'name') // Quan hệ staff() -> User::class
                    ->required(),

                Select::make('booking_id')
                    ->label('Đặt phòng')
                    ->options(
                        \App\Models\Booking::query()
                            ->where('status', \App\Enums\BookingStatusEnum::Confirmed)
                            ->get()
                            ->mapWithKeys(function ($booking) {
                                return [
                                    $booking->id => sprintf(
                                        '%s | %s | %s | %s | %s - %s',
                                        $booking->customer->name ?? 'N/A',          // Khách hàng
                                        $booking->room->code ?? 'N/A',              // Phòng
                                        $booking->branch->name ?? 'N/A',            // Chi nhánh
                                        $booking->hotel->name ?? 'N/A',             // Khách sạn
                                        $booking->check_in?->format('d/m/Y'),       // Ngày nhận
                                        $booking->check_out?->format('d/m/Y'),      // Ngày trả
                                    )
                                ];
                            })
                    )
                    ->searchable()
                    ->required(),
                Select::make('task')
                    ->label('Công việc')
                    ->options(
                        collect(BookingStaffTaskEnum::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])
                    )
                    ->required(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_id')
                    ->label('Mã Booking')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('staff.name') // Lấy tên nhân viên từ quan hệ
                    ->label('Nhân viên')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('task')
                    ->label('Công việc')
                    ->formatStateUsing(fn ($state) => $state instanceof BookingStaffTaskEnum ? $state->label() : BookingStaffTaskEnum::from($state)->label())
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListBookingStaffAssignments::route('/'),
            'create' => Pages\CreateBookingStaffAssignment::route('/create'),
            'edit' => Pages\EditBookingStaffAssignment::route('/{record}/edit'),
        ];
    }
}
