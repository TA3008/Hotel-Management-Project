<?php

namespace App\Models;

use App\Models\Team;
use App\Models\User;
use App\Models\Booking;
use App\Enums\BookingStaffTaskEnum;
use Illuminate\Database\Eloquent\Model;

class BookingStaffAssignment extends Model
{
    protected $fillable = [
        'booking_id',
        'staff_id',
        'task',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    protected $casts = [
        'task' => BookingStaffTaskEnum::class,
    ];
}
