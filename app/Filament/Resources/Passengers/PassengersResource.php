<?php

namespace App\Filament\Resources\Passengers;

use App\Filament\Resources\Passengers\Pages\CreatePassengers;
use App\Filament\Resources\Passengers\Pages\EditPassengers;
use App\Filament\Resources\Passengers\Pages\ListPassengers;
use App\Filament\Resources\Passengers\Schemas\PassengersForm;
use App\Filament\Resources\Passengers\Tables\PassengersTable;
use App\Models\Passengers;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PassengersResource extends Resource
{
    protected static ?string $model = Passengers::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Passengers';

    public static function form(Schema $schema): Schema
    {
        return PassengersForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PassengersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPassengers::route('/'),
            'create' => CreatePassengers::route('/create'),
            'edit' => EditPassengers::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
