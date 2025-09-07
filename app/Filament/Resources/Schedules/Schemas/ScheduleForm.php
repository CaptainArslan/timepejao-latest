<?php

namespace App\Filament\Resources\Schedules\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required(),
                Select::make('transport_route_id')
                    ->relationship('transportRoute', 'name')
                    ->required(),
                Select::make('vehicle_id')
                    ->relationship('vehicle', 'id')
                    ->required(),
                Select::make('driver_id')
                    ->relationship('driver', 'id')
                    ->required(),
                Select::make('passenger_id')
                    ->relationship('passenger', 'id')
                    ->required(),
                DatePicker::make('schedule_date')
                    ->required(),
                TimePicker::make('scheduled_departure_time')
                    ->required(),
                TimePicker::make('scheduled_arrival_time'),
                DateTimePicker::make('actual_departure_time'),
                DateTimePicker::make('actual_arrival_time'),
                Select::make('schedule_status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                        'archived' => 'Archived',
                    ])
                    ->default('draft')
                    ->required(),
                Select::make('trip_status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'boarding' => 'Boarding',
                        'departed' => 'Departed',
                        'in_transit' => 'In transit',
                        'arrived' => 'Arrived',
                        'delayed' => 'Delayed',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ])
                    ->default('scheduled')
                    ->required(),
                Toggle::make('is_delayed')
                    ->required(),
                TextInput::make('delay_minutes')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('delay_reason')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('delay_started_at'),
                DateTimePicker::make('delay_resolved_at'),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('metadata')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('passenger_count')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('distance_km')
                    ->numeric()
                    ->default(null),
                TextInput::make('estimated_duration_minutes')
                    ->numeric()
                    ->default(null),
                Toggle::make('is_driver_notified')
                    ->required(),
                Toggle::make('is_passenger_notified')
                    ->required(),
            ]);
    }
}
