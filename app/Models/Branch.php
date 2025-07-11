<?php

namespace App\Models;

use App\Models\Hotel;
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

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
