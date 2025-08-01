<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\Team;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all()->pluck('id');
        $branches = Branch::all()->pluck('id');
        $teams = Team::first() ?? Team::factory()->create();

        foreach (range(1, 10) as $i) {
            Booking::create([
                'customer_id' => $customers->random(),
                'branch_id' => $branches->random(),
                'check_in_date' => now()->addDays(rand(1, 5)),
                'check_out_date' => now()->addDays(rand(6, 10)),
                'status' => collect(['pending', 'confirmed', 'cancelled', 'refunded'])->random(),
                'team_id' => $teams->id,
            ]);
        }
    }
}
