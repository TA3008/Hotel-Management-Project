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
    protected $description = 'Tạo user super_admin và team SuperAdmin với toàn bộ quyền';

    public function handle()
    {
        // 1. Tạo user
        $user = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('123456'),
                'status' => 'active',
            ]
        );
        $this->info('✅ User superadmin@gmail.com đã sẵn sàng.');

        // 2. Tạo team "SuperAdmin"
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

        // 4. Tạo role
        $role = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'web', // hoặc guard bạn dùng cho admin panel
            'team_id' => '1',
        ]);
        $this->info('✅ Role super_admin đã tồn tại hoặc được tạo.');

        // 5. Gán toàn bộ quyền cho role
        $permissions = Permission::where('guard_name', 'web')->get();
        $role->syncPermissions($permissions);
        $this->info('✅ Gán toàn bộ quyền vào role super_admin.');

        // 6. Gán role cho user trong team context (model_has_roles)
        DB::table('model_has_roles')->insertOrIgnore([
            'role_id' => $role->id,
            'model_type' => User::class,
            'model_id' => $user->id,
            'team_id' => $team->id,
        ]);
        $this->info("✅ Gán role super_admin cho user trong team_id = {$team->id}.");

        // 7. Xóa cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->info('🎉 Super Admin đã sẵn sàng để sử dụng!');
        return 0;
    }
}
