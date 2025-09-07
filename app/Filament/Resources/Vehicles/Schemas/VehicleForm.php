<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('vehicle_type_id')
                    ->relationship('vehicleType', 'name')
                    ->required(),
                Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required(),
                TextInput::make('registration_number')
                    ->required(),
                TextInput::make('vin')
                    ->required(),
                TextInput::make('chassis_number')
                    ->required(),
                TextInput::make('license_plate')
                    ->required(),
                TextInput::make('make')
                    ->default(null),
                TextInput::make('model')
                    ->default(null),
                TextInput::make('year')
                    ->default(null),
                TextInput::make('color')
                    ->default(null),
                TextInput::make('seating_capacity')
                    ->numeric()
                    ->default(null),
                TextInput::make('standing_capacity')
                    ->numeric()
                    ->default(0),
                TextInput::make('max_capacity')
                    ->numeric()
                    ->default(null),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('image_url')
                    ->image(),
                FileUpload::make('front_image')
                    ->image(),
                FileUpload::make('back_image')
                    ->image(),
                Textarea::make('additional_images')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
