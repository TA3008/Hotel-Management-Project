<?php

namespace App\Models;

use App\Models\Team;
use Filament\Facades\Filament;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Amenity extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'icon',
        'description',
        'team_id',
    ];

    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logOnly(['name', 'icon', 'description'])
                ->logOnlyDirty()
                ->useLogName('amenity')
                ->setDescriptionForEvent(fn(string $eventName) => "Amenity {$eventName}");
    }

    /** @return BelongsTo<\App\Models\Team, self> */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

}
