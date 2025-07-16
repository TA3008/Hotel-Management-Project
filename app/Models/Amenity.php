<?php

namespace App\Models;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'description',
        'hotel_id',
    ];

    /** @return BelongsTo<\App\Models\Hotel, self> */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

}
