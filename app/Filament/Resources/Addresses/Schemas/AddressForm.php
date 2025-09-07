<?php

namespace App\Filament\Resources\Addresses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AddressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('addressable_type')
                    ->required(),
                TextInput::make('addressable_id')
                    ->required()
                    ->numeric(),
                TextInput::make('label')
                    ->default(null),
                TextInput::make('name')
                    ->default(null),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                TextInput::make('address_line1')
                    ->required(),
                TextInput::make('address_line2')
                    ->default(null),
                TextInput::make('city')
                    ->required(),
                TextInput::make('state')
                    ->default(null),
                TextInput::make('postal_code')
                    ->default(null),
                TextInput::make('country')
                    ->required(),
                TextInput::make('latitude')
                    ->numeric()
                    ->default(null),
                TextInput::make('longitude')
                    ->numeric()
                    ->default(null),
                Toggle::make('is_default')
                    ->required(),
            ]);
    }
}
