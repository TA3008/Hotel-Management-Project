<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'description',
        'logo',
        'tenant_id',
    ];
    
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    // Quan hệ sau này (nếu có):
    // public function rooms()
    // {
    //     return $this->hasMany(Room::class);
    // }
}
