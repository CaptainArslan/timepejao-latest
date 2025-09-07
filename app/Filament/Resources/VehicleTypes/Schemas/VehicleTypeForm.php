<?php

namespace App\Filament\Resources\VehicleTypes\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VehicleTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('has_ac')
                    ->required(),
                Toggle::make('has_wifi')
                    ->required(),
                Toggle::make('has_tv')
                    ->required(),
                Toggle::make('has_charging')
                    ->required(),
                Toggle::make('has_wheelchair_access')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
