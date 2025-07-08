<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class RoomType extends Model
{
    use BelongsToTenant;
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'bed_count',
        'tenant_id',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
