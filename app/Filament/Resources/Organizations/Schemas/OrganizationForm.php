<?php

namespace App\Filament\Resources\Organizations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('alias')
                    ->default(null),
                TextInput::make('branch_code')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('tagline')
                    ->default(null),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->default(null),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                TextInput::make('website')
                    ->default(null),
                Select::make('organization_type_id')
                    ->relationship('organizationType', 'name')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('logo_url')
                    ->default(null),
            ]);
    }
}
