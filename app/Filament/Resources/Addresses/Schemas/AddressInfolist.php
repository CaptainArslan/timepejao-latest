<?php

namespace App\Filament\Resources\Addresses\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AddressInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('addressable_type'),
                TextEntry::make('addressable_id')
                    ->numeric(),
                TextEntry::make('label'),
                TextEntry::make('name'),
                TextEntry::make('phone'),
                TextEntry::make('address_line1'),
                TextEntry::make('address_line2'),
                TextEntry::make('city'),
                TextEntry::make('state'),
                TextEntry::make('postal_code'),
                TextEntry::make('country'),
                TextEntry::make('latitude')
                    ->numeric(),
                TextEntry::make('longitude')
                    ->numeric(),
                IconEntry::make('is_default')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
