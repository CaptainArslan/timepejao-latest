<?php

namespace App\Filament\Resources\TransaportRoutes\Pages;

use App\Filament\Resources\TransaportRoutes\TransaportRouteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTransaportRoutes extends ListRecords
{
    protected static string $resource = TransaportRouteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
