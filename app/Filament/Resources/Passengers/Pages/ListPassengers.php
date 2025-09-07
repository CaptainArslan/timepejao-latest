<?php

namespace App\Filament\Resources\Passengers\Pages;

use App\Filament\Resources\Passengers\PassengersResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPassengers extends ListRecords
{
    protected static string $resource = PassengersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
