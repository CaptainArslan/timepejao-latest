<?php

namespace App\Filament\Resources\CurrentLocations\Pages;

use App\Filament\Resources\CurrentLocations\CurrentLocationsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCurrentLocations extends ListRecords
{
    protected static string $resource = CurrentLocationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
