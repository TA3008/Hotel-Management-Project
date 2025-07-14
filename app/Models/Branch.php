<?php

namespace App\Models;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'name',
        'address',
        'phone',
        'email',
        'description',
    ];

    /** @return BelongsTo<\App\Models\Hotel, self> */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->hotels;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->hotels()->whereKey($tenant)->exists();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

}
