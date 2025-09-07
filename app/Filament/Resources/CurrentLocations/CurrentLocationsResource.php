<?php

namespace App\Filament\Resources\CurrentLocations;

use App\Filament\Resources\CurrentLocations\Pages\CreateCurrentLocations;
use App\Filament\Resources\CurrentLocations\Pages\EditCurrentLocations;
use App\Filament\Resources\CurrentLocations\Pages\ListCurrentLocations;
use App\Filament\Resources\CurrentLocations\Pages\ViewCurrentLocations;
use App\Filament\Resources\CurrentLocations\Schemas\CurrentLocationsForm;
use App\Filament\Resources\CurrentLocations\Schemas\CurrentLocationsInfolist;
use App\Filament\Resources\CurrentLocations\Tables\CurrentLocationsTable;
use App\Models\CurrentLocations;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CurrentLocationsResource extends Resource
{
    protected static ?string $model = CurrentLocations::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Latest Locations';

    public static function form(Schema $schema): Schema
    {
        return CurrentLocationsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CurrentLocationsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CurrentLocationsTable::configure($table);
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
            'index' => ListCurrentLocations::route('/'),
            'create' => CreateCurrentLocations::route('/create'),
            'view' => ViewCurrentLocations::route('/{record}'),
            'edit' => EditCurrentLocations::route('/{record}/edit'),
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
