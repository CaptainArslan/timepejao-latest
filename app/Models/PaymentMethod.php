<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PaymentMethod extends Model
{
    protected $fillable = [
        'payment_methodable_id',
        'payment_methodable_type',
        'type',
        'provider',
        'provider_payment_method_id',
        'token',
        'brand',
        'last_four',
        'exp_month',
        'exp_year',
        'bank_name',
        'account_holder_name',
        'account_holder_type',
        'is_default',
        'is_verified',
        'status',
        'meta',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_verified' => 'boolean',
        'exp_month' => 'integer',
        'exp_year' => 'integer',
        'meta' => 'array',
    ];

    protected $hidden = [
        'token',
        'provider_payment_method_id',
    ];

    // =============================== Relationships ===============================
    public function paymentMethodable(): MorphTo
    {
        return $this->morphTo();
    }
    // =============================== End of Relationships ===============================

    // =============================== Accessors & Mutators ===============================
    protected function maskedNumber(): Attribute
    {
        return Attribute::get(function () {
            if ($this->type === 'card' && $this->last_four) {
                return '**** **** **** '.$this->last_four;
            }

            if ($this->type === 'bank_transfer' && $this->last_four) {
                return '****'.$this->last_four;
            }

            return '****';
        });
    }

    protected function displayName(): Attribute
    {
        return Attribute::get(function () {
            if ($this->type === 'card') {
                $brand = ucfirst($this->brand ?? 'Card');

                return $brand.' ending in '.$this->last_four;
            }

            if ($this->type === 'bank_transfer') {
                $bank = $this->bank_name ?? 'Bank Account';

                return $bank.' ending in '.$this->last_four;
            }

            return ucfirst($this->type ?? 'Payment Method');
        });
    }

    protected function isExpired(): Attribute
    {
        return Attribute::get(function () {
            if ($this->type !== 'card' || ! $this->exp_month || ! $this->exp_year) {
                return false;
            }

            $expiryDate = Carbon::createFromDate($this->exp_year, $this->exp_month, 1)->endOfMonth();

            return $expiryDate->isPast();
        });
    }

    protected function isActive(): Attribute
    {
        return Attribute::get(fn () => $this->status === 'active' && ! $this->is_expired);
    }
    // =============================== End of Accessors & Mutators ===============================

    // =============================== Query Scopes ===============================
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByProvider($query, string $provider)
    {
        return $query->where('provider', $provider);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->where('type', '!=', 'card')
                ->orWhere(function ($cardQuery) {
                    $cardQuery->where('type', 'card')
                        ->where(function ($expQuery) {
                            $expQuery->whereNull('exp_year')
                                ->orWhereNull('exp_month')
                                ->orWhereRaw('STR_TO_DATE(CONCAT(exp_year, "-", exp_month, "-01"), "%Y-%m-%d") > CURDATE()');
                        });
                });
        });
    }
    // =============================== End of Query Scopes ===============================

    // =============================== Business Logic Methods ===============================

    public function setAsDefault(): bool
    {
        static::where('payment_methodable_id', $this->payment_methodable_id)
            ->where('payment_methodable_type', $this->payment_methodable_type)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        return $this->update(['is_default' => true]);
    }

    public function markAsVerified(): bool
    {
        return $this->update(['is_verified' => true]);
    }

    public function deactivate(): bool
    {
        return $this->update(['status' => 'inactive']);
    }

    public function markAsExpired(): bool
    {
        return $this->update(['status' => 'expired']);
    }
    // =============================== End of Business Logic Methods ===============================
}
