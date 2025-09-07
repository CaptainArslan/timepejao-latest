<?php

namespace App\Filament\Resources\CurrentLocations\Pages;

use App\Filament\Resources\CurrentLocations\CurrentLocationsResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCurrentLocations extends ViewRecord
{
    protected static string $resource = CurrentLocationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
