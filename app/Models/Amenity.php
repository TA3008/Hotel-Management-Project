<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Amenity extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected $fillable = [
        'name',
        'icon',
        'description',
        'tenant_id',
    ];
}
