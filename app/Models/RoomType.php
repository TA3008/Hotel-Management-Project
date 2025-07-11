<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
