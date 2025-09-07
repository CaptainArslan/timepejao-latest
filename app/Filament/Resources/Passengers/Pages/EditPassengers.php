<?php

namespace App\Filament\Resources\Passengers\Pages;

use App\Filament\Resources\Passengers\PassengersResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPassengers extends EditRecord
{
    protected static string $resource = PassengersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
