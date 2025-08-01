<?php

namespace App\Models;

use App\Models\Team;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'name',
        'address',
        'phone',
        'email',
        'description',
        'image',
        'team_id',
    ];

    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'address', 'phone', 'email', 'description'])
            ->logOnlyDirty()
            ->useLogName('branch')
            ->setDescriptionForEvent(fn(string $eventName) => "Branch {$eventName}");
    }

    /** @return BelongsTo<\App\Models\Team, self> */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

}
