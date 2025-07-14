<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Hotel;

class Role extends SpatieRole
{
    protected $fillable = ['name', 'guard_name'];

    // Quan hệ tới permissions
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'role_has_permissions',
            'role_id',
            'permission_id'
        );
    }

    /** @return BelongsTo<\App\Models\Hotel, self> */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

}
