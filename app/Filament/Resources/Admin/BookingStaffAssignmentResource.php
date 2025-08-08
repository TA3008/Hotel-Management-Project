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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Admin\BookingStaffAssignmentResource\Pages;
use App\Filament\Resources\Admin\BookingStaffAssignmentResource\RelationManagers;

class BookingStaffAssignmentResource extends Resource
{
    protected static ?string $model = BookingStaffAssignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $tenantOwnershipRelationshipName = 'team';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('booking_id')
                    ->label('Booking ID')
                    ->required()
                    ->rules(['exists:bookings,id']),
                TextInput::make('staff_id')
                    ->label('Staff ID')
                    ->required()
                    ->rules(['exists:users,id']),
                Select::make('task')
                    ->label('Task')
                    ->options(BookingStaffTaskEnum::cases())
                    ->required(),
            ])->columns(2)
            ->statePath('booking_staff_assignment');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_id')
                    ->label('Booking ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('staff_id')
                    ->label('Staff ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('task')
                    ->label('Task')
                    ->formatStateUsing(fn ($state) => BookingStaffTaskEnum::from($state)->label())
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Created At')
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
