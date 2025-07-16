<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Room;
use Filament\Tables;
use App\Models\Branch;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\RoomStatusEnum;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\DeleteAction;
use App\Filament\Resources\RoomResource\Pages;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;
    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationGroup = 'Quản lý khách sạn';
    protected static ?string $navigationLabel = 'Phòng';
    protected static ?int $navigationSort = 5;

    protected static ?string $tenantOwnershipRelationshipName = 'team';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('branch_id')
                ->label('Chi nhánh')
                ->options(function () {
                    return Branch::with('team')->get()->mapWithKeys(function ($branch) {
                        return [
                            $branch->id => "{$branch->name} - {$branch->team->name}",
                        ];
                    })->toArray();
                })
                ->searchable()
                ->required(),

            Select::make('room_type_id')
                ->label('Loại phòng')
                ->relationship('roomType', 'name')
                ->required(),

            TextInput::make('room_number')
                ->label('Số phòng')
                ->required(),

            Select::make('status')
                ->label('Trạng thái')
                ->options(RoomStatusEnum::options())
                ->required(),

            Textarea::make('note')->label('Ghi chú')->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('room_number')->label('Số phòng')->sortable()->searchable(),
                TextColumn::make('branch.team.name')
                    ->label('Khách sạn')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('branch.name')->label('Chi nhánh'),
                TextColumn::make('roomType.name')->label('Loại phòng'),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn (RoomStatusEnum $state) => $state->label())
                    ->badge()
                    ->color(fn (RoomStatusEnum $state) => match ($state) {
                        RoomStatusEnum::Available => 'success',
                        RoomStatusEnum::Booked => 'warning',
                        RoomStatusEnum::Occupied => 'primary',
                        RoomStatusEnum::Cleaning => 'info',
                        RoomStatusEnum::Maintenance => 'danger',
                    }),

                TextColumn::make('created_at')->label('Ngày tạo')->dateTime('d/m/Y H:i'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}

