<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Team;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomType extends Model
{
    
    protected $fillable = [
        'name',
        'amenities_id',
        'description',
        'price',
        'bed_count',
        'image',
        'team_id',
    ];

    public function getActivityLogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logOnly(['name', 'amenities_id', 'description', 'price', 'bed_count'])
            ->logOnlyDirty()
            ->useLogName('room_type')
            ->setDescriptionForEvent(fn(string $eventName) => "Room Type {$eventName}");
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /** @return BelongsTo<\App\Models\Team, self> */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

}
