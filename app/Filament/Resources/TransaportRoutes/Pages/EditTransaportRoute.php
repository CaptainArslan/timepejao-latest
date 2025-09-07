<?php

namespace App\Filament\Resources\TransaportRoutes\Pages;

use App\Filament\Resources\TransaportRoutes\TransaportRouteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditTransaportRoute extends EditRecord
{
    protected static string $resource = TransaportRouteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
