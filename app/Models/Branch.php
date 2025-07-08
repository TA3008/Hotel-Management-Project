<?php

namespace App\Models;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected $fillable = [
        'hotel_id',
        'name',
        'address',
        'phone',
        'email',
        'description',
        'tenant_id',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
