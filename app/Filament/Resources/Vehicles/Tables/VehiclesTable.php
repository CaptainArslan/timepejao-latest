<?php

namespace App\Filament\Resources\Vehicles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VehiclesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicleType.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('organization.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('registration_number')
                    ->searchable(),
                TextColumn::make('vin')
                    ->searchable(),
                TextColumn::make('chassis_number')
                    ->searchable(),
                TextColumn::make('license_plate')
                    ->searchable(),
                TextColumn::make('make')
                    ->searchable(),
                TextColumn::make('model')
                    ->searchable(),
                TextColumn::make('year')
                    ->searchable(),
                TextColumn::make('color')
                    ->searchable(),
                TextColumn::make('seating_capacity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('standing_capacity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max_capacity')
                    ->numeric()
                    ->sortable(),
                ImageColumn::make('image_url'),
                ImageColumn::make('front_image'),
                ImageColumn::make('back_image'),
                IconColumn::make('is_active')
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
