<?php

namespace App\Filament\Resources\Schedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('organization.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('transportRoute.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('vehicle.id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('driver.id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('passenger.id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('schedule_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('scheduled_departure_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('scheduled_arrival_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('actual_departure_time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('actual_arrival_time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('schedule_status'),
                TextColumn::make('trip_status'),
                IconColumn::make('is_delayed')
                    ->boolean(),
                TextColumn::make('delay_minutes')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('delay_started_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('delay_resolved_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('passenger_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('distance_km')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('estimated_duration_minutes')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_driver_notified')
                    ->boolean(),
                IconColumn::make('is_passenger_notified')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
