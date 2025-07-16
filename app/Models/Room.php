<?php

namespace App\Models;

use App\Models\Team;
use App\Enums\RoomStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    
    protected $fillable = [
        'branch_id',
        'room_type_id',
        'room_number',
        'status',
        'note',
        'team_id',
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

    /** @return BelongsTo<\App\Models\Team, self> */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

}
