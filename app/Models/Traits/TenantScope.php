<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class TenantScope implements Scope
{
    public function applyTenantScope(Builder $builder, Model $model)
    {
        // Kiểm tra nếu đang chạy trong console hoặc không có request
        if (app()->runningInConsole() || !request()->hasSession()) {
            return;
        }

        $user = auth()->user();

        // Nếu là super_admin thì bỏ lọc team
        if ($user && $user->hasRole('super_admin')) {
            return $query;
        }

        // Nếu không thì lọc theo team_id
        return $query->where('team_id', $user?->team_id);
    }
}
