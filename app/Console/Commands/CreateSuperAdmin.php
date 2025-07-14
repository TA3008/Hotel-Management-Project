<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class CreateSuperAdmin extends Command
{
    protected $signature = 'app:create-super-admin';
    protected $description = 'Tạo user super_admin với toàn bộ quyền';

    public function handle()
    {
        // Tạo user nếu chưa có
        $user = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('123456'),
                'status' => true,
            ]
        );
        $this->info('✅ User superadmin@gmail.com đã sẵn sàng.');

        // Tạo role nếu chưa có
        $role = Role::firstOrCreate(['name' => 'super_admin']);
        $this->info('✅ Role super_admin đã tồn tại hoặc được tạo.');

        // Gán tất cả permission cho role
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
        $this->info('✅ Gán toàn bộ quyền cho role super_admin.');

        // 👉 Không dùng assignRole vì nó không gán hotel_id
        // 👉 Insert trực tiếp vào bảng trung gian
        DB::table('model_has_roles')->insertOrIgnore([
            'role_id'    => $role->id,
            'model_type' => User::class,
            'model_id'   => $user->id,
            'hotel_id'   => 1, // gán hotel_id cố định
        ]);
        $this->info('✅ Gán role super_admin cho user (có hotel_id = 1).');

        // Xóa cache quyền
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->info('🎉 Super admin đã sẵn sàng để sử dụng!');
        return 0;
    }
}
