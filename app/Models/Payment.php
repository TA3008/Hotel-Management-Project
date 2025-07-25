<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'booking_id',
        'amount',
        'payment_method',
        'status',
        'response_data',
    ];

    protected $casts = [
        'response_data' => 'array',
        'status' => PaymentStatusEnum::class, 
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
