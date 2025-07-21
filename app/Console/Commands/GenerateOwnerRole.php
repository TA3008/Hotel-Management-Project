<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class GenerateOwnerRole extends Command
{
    protected $signature = 'app:generate-owner-role';
    protected $description = 'Tạo role owner với tất cả quyền trên admin panel (guard: filament)';

    public function handle()
    {
        // 1. Tạo role owner với guard_name là 'web'
        $role = Role::firstOrCreate([
            'name' => 'owner',
            'guard_name' => 'web',
            'team_id' => '1',
        ]);

        $this->info('✅ Role "owner" đã được tạo hoặc đã tồn tại.');

        // 2. Lấy toàn bộ permission trong guard 'web'
        $permissions = Permission::where('guard_name', 'web')->get();

        if ($permissions->isEmpty()) {
            $this->warn('⚠️ Không tìm thấy permission nào với guard "web". Hãy chắc chắn đã chạy "php artisan shield:generate".');
        } else {
            // 3. Gán toàn bộ quyền cho role
            $role->syncPermissions($permissions);
            $this->info('✅ Tất cả quyền trong panel admin đã được gán cho role "owner".');
        }

        // 4. Xóa cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->info('🎉 Role "owner" đã sẵn sàng!');
        return 0;
    }
}
