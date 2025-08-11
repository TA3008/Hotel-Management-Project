<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookingStaffAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = DB::table('bookings')->pluck('id')->toArray();
        $staff = DB::table('users')->pluck('id')->toArray();
        $teams = Team::first() ?? Team::factory()->create();
        $team_id = $teams->id;

        if (empty($bookings) || empty($staff) || empty($teams)) {
            $this->command->warn('⚠ Không có dữ liệu trong bookings, users hoặc teams để seed.');
            return;
        }

        $tasks = ['checkin_assist', 'cleaning', 'special_request'];

        for ($i = 0; $i < 20; $i++) {
            DB::table('booking_staff_assignments')->insert([
                'booking_id' => $bookings[array_rand($bookings)],
                'staff_id'   => $staff[array_rand($staff)],
                'task'       => $tasks[array_rand($tasks)],
                'team_id'    => $team_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
