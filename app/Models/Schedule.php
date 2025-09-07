<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'transport_route_id',
        'vehicle_id',
        'driver_id',
        'passenger_id',
        'schedule_date',
        'scheduled_departure_time',
        'scheduled_arrival_time',
        'actual_departure_time',
        'actual_arrival_time',
        'schedule_status',
        'trip_status',
        'is_delayed',
        'delay_minutes',
        'delay_reason',
        'delay_started_at',
        'delay_resolved_at',
        'notes',
        'metadata',
        'passenger_count',
        'distance_km',
        'estimated_duration_minutes',
        'is_driver_notified',
        'is_passenger_notified',
    ];

    protected $casts = [
        'schedule_date' => 'date',
        'scheduled_departure_time' => 'datetime:H:i',
        'scheduled_arrival_time' => 'datetime:H:i',
        'actual_departure_time' => 'datetime',
        'actual_arrival_time' => 'datetime',
        'is_delayed' => 'boolean',
        'delay_minutes' => 'integer',
        'delay_started_at' => 'datetime',
        'delay_resolved_at' => 'datetime',
        'metadata' => 'array',
        'passenger_count' => 'integer',
        'distance_km' => 'decimal:2',
        'estimated_duration_minutes' => 'integer',
        'is_driver_notified' => 'boolean',
        'is_passenger_notified' => 'boolean',
    ];

    // =============================== Relationships ===============================
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function transportRoute(): BelongsTo
    {
        return $this->belongsTo(TransportRoute::class, 'transport_route_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function passenger(): BelongsTo
    {
        return $this->belongsTo(Passenger::class);
    }

    // =============================== End of Relationships ===============================

    // =============================== Accessors & Mutators ===============================
    public function getTotalDurationMinutesAttribute(): ?int
    {
        if ($this->actual_departure_time && $this->actual_arrival_time) {
            return $this->actual_departure_time->diffInMinutes($this->actual_arrival_time);
        }

        return $this->estimated_duration_minutes;
    }

    public function getDelayStatusAttribute(): array
    {
        return [
            'is_delayed' => $this->is_delayed,
            'delay_minutes' => $this->delay_minutes,
            'delay_reason' => $this->delay_reason,
            'delay_started_at' => $this->delay_started_at,
            'delay_resolved_at' => $this->delay_resolved_at,
        ];
    }

    public function isPublished(): bool
    {
        return $this->schedule_status === 'published';
    }

    public function isInProgress(): bool
    {
        return in_array($this->trip_status, ['boarding', 'departed', 'in_transit']);
    }

    public function isCompleted(): bool
    {
        return $this->trip_status === 'completed' || $this->schedule_status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->trip_status === 'cancelled' || $this->schedule_status === 'cancelled';
    }

    public function getCurrentDelayMinutes(): int
    {
        if (! $this->is_delayed) {
            return 0;
        }

        if ($this->delay_resolved_at) {
            return $this->delay_minutes;
        }

        // Calculate current delay if still ongoing
        if ($this->delay_started_at) {
            $currentDelay = now()->diffInMinutes($this->delay_started_at);

            return max($currentDelay, $this->delay_minutes);
        }

        return $this->delay_minutes;
    }

    public function isAllNotified(): bool
    {
        return $this->is_driver_notified && $this->is_passenger_notified;
    }

    public function isNotNotified(): bool
    {
        return ! $this->is_driver_notified && ! $this->is_passenger_notified;
    }

    public function isDriverOnlyNotified(): bool
    {
        return $this->is_driver_notified && ! $this->is_passenger_notified;
    }

    public function isPassengerOnlyNotified(): bool
    {
        return ! $this->is_driver_notified && $this->is_passenger_notified;
    }

    // =============================== End of Accessors & Mutators ===============================

    // =============================== Status Management Methods ===============================

    public function publish(): bool
    {
        if ($this->schedule_status === 'draft') {
            $this->update(['schedule_status' => 'published']);

            return true;
        }

        return false;
    }

    public function cancel(?string $reason = null): bool
    {
        if (! in_array($this->schedule_status, ['cancelled', 'completed'])) {
            $this->update([
                'schedule_status' => 'cancelled',
                'trip_status' => 'cancelled',
                'notes' => $reason ? ($this->notes."\nCancellation reason: ".$reason) : $this->notes,
            ]);

            return true;
        }

        return false;
    }

    public function startBoarding(): bool
    {
        if ($this->trip_status === 'scheduled' && $this->schedule_status === 'published') {
            $this->update(['trip_status' => 'boarding']);

            return true;
        }

        return false;
    }

    public function markAsDeparted(): bool
    {
        if ($this->trip_status === 'boarding') {
            $this->update([
                'trip_status' => 'departed',
                'actual_departure_time' => now(),
            ]);

            return true;
        }

        return false;
    }

    public function markAsInTransit(): bool
    {
        if ($this->trip_status === 'departed') {
            $this->update(['trip_status' => 'in_transit']);

            return true;
        }

        return false;
    }

    public function markAsArrived(): bool
    {
        if ($this->trip_status === 'in_transit') {
            $this->update([
                'trip_status' => 'arrived',
                'actual_arrival_time' => now(),
            ]);

            return true;
        }

        return false;
    }

    public function complete(): bool
    {
        if (in_array($this->trip_status, ['arrived', 'in_transit'])) {
            $this->update([
                'trip_status' => 'completed',
                'schedule_status' => 'completed',
                'actual_arrival_time' => $this->actual_arrival_time ?? now(),
            ]);

            return true;
        }

        return false;
    }

    // =============================== End of Status Management Methods ===============================

    // =============================== Delay Management Methods ===============================

    public function startDelay(int $minutes, ?string $reason = null): bool
    {
        if (! $this->is_delayed && in_array($this->trip_status, ['scheduled', 'boarding', 'departed', 'in_transit'])) {
            $this->update([
                'is_delayed' => true,
                'delay_minutes' => $minutes,
                'delay_reason' => $reason,
                'delay_started_at' => now(),
                'trip_status' => 'delayed',
            ]);

            return true;
        }

        return false;
    }

    public function resolveDelay(): bool
    {
        if ($this->is_delayed) {
            $this->update([
                'is_delayed' => false,
                'delay_resolved_at' => now(),
                'trip_status' => 'scheduled',
            ]);

            return true;
        }

        return false;
    }

    public function updateDelay(int $minutes, ?string $reason = null): bool
    {
        if ($this->is_delayed) {
            $this->update([
                'delay_minutes' => $minutes,
                'delay_reason' => $reason ?? $this->delay_reason,
            ]);

            return true;
        }

        return false;
    }

    // =============================== End of Delay Management Methods ===============================

    // =============================== Scopes ===============================

    public function scopePublished($query)
    {
        return $query->where('schedule_status', 'published');
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('schedule_status', ['cancelled', 'completed', 'archived']);
    }

    public function scopeDelayed($query)
    {
        return $query->where('is_delayed', true);
    }

    public function scopeByDate($query, $date)
    {
        return $query->where('schedule_date', $date);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('schedule_date', [$startDate, $endDate]);
    }

    public function scopeByOrganization($query, $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }

    public function scopeByDriver($query, $driverId)
    {
        return $query->where('driver_id', $driverId);
    }

    public function scopeByVehicle($query, $vehicleId)
    {
        return $query->where('vehicle_id', $vehicleId);
    }

    public function scopeByTripStatus($query, $status)
    {
        return $query->where('trip_status', $status);
    }

    public function scopeToday($query)
    {
        return $query->where('schedule_date', today());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('schedule_date', '>=', today())
            ->where('scheduled_departure_time', '>', now()->format('H:i:s'));
    }

    public function scopeDriverNotified($query)
    {
        return $query->where('is_driver_notified', true);
    }

    public function scopePassengerNotified($query)
    {
        return $query->where('is_passenger_notified', true);
    }

    public function scopeAllNotified($query)
    {
        return $query->where('is_driver_notified', true)
            ->where('is_passenger_notified', true);
    }

    public function scopeNotNotified($query)
    {
        return $query->where('is_driver_notified', false)
            ->where('is_passenger_notified', false);
    }

    // =============================== End of Scopes ===============================

    // =============================== End of Model ===============================
}
