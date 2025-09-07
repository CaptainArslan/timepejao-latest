<?php

namespace App\Filament\Resources\Drivers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DriverForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required(),
                TextInput::make('full_name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->default(null),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                Select::make('gender')
                    ->options(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'])
                    ->required(),
                TextInput::make('driver_license_number')
                    ->required(),
                TextInput::make('license_class')
                    ->required(),
                DatePicker::make('license_issue_date')
                    ->required(),
                DatePicker::make('license_expiry_date')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('emergency_contact_name')
                    ->default(null),
                TextInput::make('emergency_contact_phone')
                    ->tel()
                    ->default(null),
                TextInput::make('emergency_contact_relationship')
                    ->default(null),
                FileUpload::make('profile_image')
                    ->image(),
                FileUpload::make('license_front_image')
                    ->image(),
                FileUpload::make('license_back_image')
                    ->image(),
                FileUpload::make('id_card_front_image')
                    ->image(),
                FileUpload::make('id_card_back_image')
                    ->image(),
                FileUpload::make('passport_image')
                    ->image(),
                TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_trips')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_distance')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('accidents_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('violations_count')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
