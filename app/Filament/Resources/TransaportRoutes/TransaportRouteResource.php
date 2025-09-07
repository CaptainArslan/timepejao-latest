<?php

namespace App\Filament\Resources\TransaportRoutes;

use App\Filament\Resources\TransaportRoutes\Pages\CreateTransaportRoute;
use App\Filament\Resources\TransaportRoutes\Pages\EditTransaportRoute;
use App\Filament\Resources\TransaportRoutes\Pages\ListTransaportRoutes;
use App\Filament\Resources\TransaportRoutes\Schemas\TransaportRouteForm;
use App\Filament\Resources\TransaportRoutes\Tables\TransaportRoutesTable;
use App\Models\TransaportRoute;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaportRouteResource extends Resource
{
    protected static ?string $model = TransaportRoute::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Route';

    public static function form(Schema $schema): Schema
    {
        return TransaportRouteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransaportRoutesTable::configure($table);
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
            'index' => ListTransaportRoutes::route('/'),
            'create' => CreateTransaportRoute::route('/create'),
            'edit' => EditTransaportRoute::route('/{record}/edit'),
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
