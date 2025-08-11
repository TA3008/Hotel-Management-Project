<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy hoặc tạo team mặc định
        $team = Team::first() ?? Team::factory()->create();
        $teamId = $team->id;

        // Danh sách role và quyền
        $roles = [
            'booking-staff' => Permission::where('name', 'like', '%booking%')->pluck('name')->toArray(),
            'cleaner'       => Permission::where('name', 'like', '%room%')->pluck('name')->toArray(),
            'security'      => [
                'view_admin:booking',
                'view_any_admin:booking',
            ],
            'receptionist'  => array_merge(
                Permission::where('name', 'like', '%booking%')->pluck('name')->toArray(),
                Permission::where('name', 'like', '%customer%')->pluck('name')->toArray()
            ),
            'manager'       => Permission::all()->pluck('name')->toArray(), // full quyền
        ];

        // Tạo role và gán quyền
        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(
                [
                    'name'       => $roleName,
                    'guard_name' => 'web',
                    'team_id'    => $teamId
                ]
            );

            if (!empty($permissions)) {
                $perms = Permission::whereIn('name', $permissions)->get();
                $role->syncPermissions($perms);
            }
        }

        // Danh sách user mẫu
        $usersData = [
            ['name' => 'Booking Staff 1', 'email' => 'staff1@example.com', 'role' => 'booking-staff'],
            ['name' => 'Booking Staff 2', 'email' => 'staff2@example.com', 'role' => 'booking-staff'],
            ['name' => 'Cleaner 1',       'email' => 'cleaner1@example.com', 'role' => 'cleaner'],
            ['name' => 'Cleaner 2',       'email' => 'cleaner2@example.com', 'role' => 'cleaner'],
            ['name' => 'Security 1',      'email' => 'security1@example.com', 'role' => 'security'],
            ['name' => 'Security 2',      'email' => 'security2@example.com', 'role' => 'security'],
            ['name' => 'Receptionist 1',  'email' => 'reception1@example.com', 'role' => 'receptionist'],
            ['name' => 'Receptionist 2',  'email' => 'reception2@example.com', 'role' => 'receptionist'],
            ['name' => 'Manager 1',       'email' => 'manager1@example.com', 'role' => 'manager'],
            ['name' => 'Manager 2',       'email' => 'manager2@example.com', 'role' => 'manager'],
        ];

        // Set context team_id cho Spatie Permission
        app(PermissionRegistrar::class)->setPermissionsTeamId($teamId);

        // Tạo user và gán role
        foreach ($usersData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make('123456'),
                ]
            );

            $user->assignRole($data['role']);
        }
    }
}
