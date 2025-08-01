<?php

namespace App\Models;

use App\Models\Team;
use App\Enums\VoucherTypeEnum;
use App\Enums\VoucherStatusEnum;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'type',
        'amount',
        'min_order_value',
        'max_uses',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'status' => VoucherStatusEnum::class, 
        'type' => VoucherTypeEnum::class,
    ];

    public function getActivityLogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logOnly(['code', 'type', 'amount', 'min_order_value', 'max_uses', 'used_count', 'starts_at', 'expires_at', 'is_active'])
            ->logOnlyDirty()
            ->useLogName('voucher')
            ->setDescriptionForEvent(fn(string $eventName) => "Voucher {$eventName}");
    }

    public function isValid(): bool
    {
        $now = now();

        return $this->is_active
            && ($this->starts_at === null || $this->starts_at <= $now)
            && ($this->expires_at === null || $this->expires_at >= $now)
            && ($this->max_uses === null || $this->used_count < $this->max_uses);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
