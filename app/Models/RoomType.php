<?php

namespace App\Models;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomType extends Model
{
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'bed_count',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /** @return BelongsTo<\App\Models\Hotel, self> */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

}
