<?php

namespace App\Filament\Resources\Drivers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DriversTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('organization.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('full_name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('gender'),
                TextColumn::make('driver_license_number')
                    ->searchable(),
                TextColumn::make('license_class')
                    ->searchable(),
                TextColumn::make('license_issue_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('license_expiry_date')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('emergency_contact_name')
                    ->searchable(),
                TextColumn::make('emergency_contact_phone')
                    ->searchable(),
                TextColumn::make('emergency_contact_relationship')
                    ->searchable(),
                ImageColumn::make('profile_image'),
                ImageColumn::make('license_front_image'),
                ImageColumn::make('license_back_image'),
                ImageColumn::make('id_card_front_image'),
                ImageColumn::make('id_card_back_image'),
                ImageColumn::make('passport_image'),
                TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_trips')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_distance')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('accidents_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('violations_count')
                    ->numeric()
                    ->sortable(),
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
