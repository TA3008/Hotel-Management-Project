<?php

namespace App\Filament\Resources\Admin;

use App\Models\Activity;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\Admin\ActivityResource\Pages\ListActivities;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'System';
    protected static ?string $pluralLabel = 'Activity Logs';
    protected static ?string $label = 'Activity Log';

    protected static bool $shouldRegisterNavigation = true;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('log_name')
                    ->label('Log Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->wrap()
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('event')
                    ->label('Event')
                    ->badge(),

                TextColumn::make('causer.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('subject_type')
                    ->label('Model')
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivities::route('/'),
        ];
    }
}
