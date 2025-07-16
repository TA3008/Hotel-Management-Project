<?php

namespace App\Models;

use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
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
        'team_id',
    ];

    /** @return BelongsTo<\App\Models\Team, self> */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->teams;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->teams()->whereKey($tenant)->exists();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

}
