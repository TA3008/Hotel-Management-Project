<?php

namespace App\Models;

use App\Enums\RoomStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    
    protected $fillable = [
        'branch_id',
        'room_type_id',
        'room_number',
        'status',
        'note',
    ];

    protected $casts = [
        'status' => RoomStatusEnum::class, 
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}
