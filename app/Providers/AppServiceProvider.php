<?php

namespace App\Providers;

use App\Models\Role;
use Spatie\Activitylog\Models\Activity;
use App\Models\Permission;
use Filament\Facades\Filament;
use App\Observers\ActivityObserver;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\PermissionRegistrar;
use Stancl\Tenancy\Database\Models\Tenant;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        app(\Spatie\Permission\PermissionRegistrar::class)
            ->setPermissionClass(Permission::class)
            ->setRoleClass(Role::class);

        Activity::creating(function (Activity $activity) {
        // Ngăn vòng lặp nếu vô tình log chính activity
        if ($activity->subject_type === Activity::class) {
            return;
        }

        // Ghi team_id vào CỘT RIÊNG nếu có
        $activity->team_id = optional(Filament::getTenant())->id;

        // Ghi team_id vào properties JSON nếu cần xem chi tiết
        $activity->properties = collect($activity->properties)->merge([
            'team_id' => $activity->team_id,
        ]);
    });
    }
}
