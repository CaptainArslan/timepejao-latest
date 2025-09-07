<?php

namespace App\Filament\Resources\Schedules\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ScheduleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('organization.name')
                    ->numeric(),
                TextEntry::make('transportRoute.name')
                    ->numeric(),
                TextEntry::make('vehicle.id')
                    ->numeric(),
                TextEntry::make('driver.id')
                    ->numeric(),
                TextEntry::make('passenger.id')
                    ->numeric(),
                TextEntry::make('schedule_date')
                    ->date(),
                TextEntry::make('scheduled_departure_time')
                    ->time(),
                TextEntry::make('scheduled_arrival_time')
                    ->time(),
                TextEntry::make('actual_departure_time')
                    ->dateTime(),
                TextEntry::make('actual_arrival_time')
                    ->dateTime(),
                TextEntry::make('schedule_status'),
                TextEntry::make('trip_status'),
                IconEntry::make('is_delayed')
                    ->boolean(),
                TextEntry::make('delay_minutes')
                    ->numeric(),
                TextEntry::make('delay_started_at')
                    ->dateTime(),
                TextEntry::make('delay_resolved_at')
                    ->dateTime(),
                TextEntry::make('passenger_count')
                    ->numeric(),
                TextEntry::make('distance_km')
                    ->numeric(),
                TextEntry::make('estimated_duration_minutes')
                    ->numeric(),
                IconEntry::make('is_driver_notified')
                    ->boolean(),
                IconEntry::make('is_passenger_notified')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
