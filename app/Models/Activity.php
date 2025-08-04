<?php

namespace App\Models;

use App\Models\Team;
use Spatie\Activitylog\Models\Activity as SpatieActivity;

class Activity extends SpatieActivity
{
    protected $table = 'activity_log'; // bảng mặc định của Spatie

    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'event',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'batch_uuid',
        'team_id',
    ];

    /**
     * Quan hệ tới Team (multi-tenant)
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    // /**
    //  * Quan hệ tới User (người thực hiện)
    //  */
    // public function causer()
    // {
    //     return $this->belongsTo(User::class, 'causer_id');
    // }

    // /**
    //  * Quan hệ tới Model bị tác động
    //  */
    // public function subject()
    // {
    //     return $this->morphTo();
    // }
}
