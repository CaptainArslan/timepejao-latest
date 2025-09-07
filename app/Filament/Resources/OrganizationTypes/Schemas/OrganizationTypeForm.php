<?php

namespace App\Filament\Resources\OrganizationTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrganizationTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('description')
                    ->default(null),
                TextInput::make('start_class')
                    ->numeric()
                    ->default(null),
                TextInput::make('end_class')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
