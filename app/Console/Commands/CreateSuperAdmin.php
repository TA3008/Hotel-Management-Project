<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class CreateSuperAdmin extends Command
{
    protected $signature = 'app:create-super-admin';
    protected $description = 'Tạo user super_admin và team SuperAdmin với toàn bộ quyền (admin + system)';

    public function handle()
    {
        // 1. Tạo user super_admin
        $user = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('123456'),
                'status' => 'active',
            ]
        );
        $this->info('✅ User superadmin@gmail.com đã sẵn sàng.');

        // 2. Tạo team SuperAdmin
        $team = Team::firstOrCreate([
            'name' => 'SuperAdmin',
        ], [
            'email' => 'superadmin@gmail.com',
            'user_id' => $user->id,
            'status' => 'active',
        ]);
        $this->info('✅ Team "SuperAdmin" đã sẵn sàng.');

        // 3. Gán user vào team_user
        DB::table('team_user')->insertOrIgnore([
            'user_id' => $user->id,
            'team_id' => $team->id,
        ]);
        $this->info('✅ Gán user vào team "SuperAdmin".');

        // 4. Tạo role super_admin
        $role = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'web',
            'team_id' => $team->id,
        ]);
        $this->info('✅ Role super_admin đã tồn tại hoặc được tạo.');

        // 5. Lấy toàn bộ permission (admin + system)
        $permissions = Permission::query()->get();

        if ($permissions->isEmpty()) {
            $this->warn('⚠ Chưa có permission nào. Hãy chạy:');
            $this->warn('   php artisan shield:generate --panel=admin');
            $this->warn('   php artisan shield:generate --panel=system');
            return 1;
        }

        // 6. Đồng bộ team_id cho permission (nếu chưa có)
        Permission::whereNull('team_id')->update(['team_id' => $team->id]);

        // 7. Gán toàn bộ permission cho role
        $role->syncPermissions($permissions);
        $this->info('✅ Gán toàn bộ quyền (admin + system) vào role super_admin.');

        // 8. Gán role cho user
        DB::table('model_has_roles')->insertOrIgnore([
            'role_id' => $role->id,
            'model_type' => User::class,
            'model_id' => $user->id,
            'team_id' => $team->id,
        ]);
        $this->info("✅ Gán role super_admin cho user trong team_id = {$team->id}.");

        // 9. Xóa cache permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->info('🎉 Super Admin đã sẵn sàng để sử dụng cho cả panel admin và system!');
        return 0;
    }
}
