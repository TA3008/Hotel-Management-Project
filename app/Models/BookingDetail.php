<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Team;
use App\Models\Booking;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    protected $fillable = [
        'booking_id',
        'room_id',
        'price',
        'name',
        'email',
        'phone',
    ];

    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['booking_id', 'room_id', 'price', 'name', 'email', 'phone'])
            ->logOnlyDirty()
            ->useLogName('booking_detail')
            ->setDescriptionForEvent(fn(string $eventName) => "Booking Detail {$eventName}");
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
