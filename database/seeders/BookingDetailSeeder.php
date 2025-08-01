<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Team;
use App\Models\BookingDetail;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BookingDetailSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = Booking::all()->pluck('id');
        $rooms = Room::all()->pluck('id');
        $teams = Team::first() ?? Team::factory()->create();
        $faker = Faker::create();

        foreach (range(1, 30) as $i) {
            BookingDetail::create([
                'booking_id' => $bookings->random(),
                'room_id' => $rooms->random(),
                'price' => rand(500000, 2000000),
                'name' => $faker->name(),
                'email' => $faker->email(),
                'phone' => $faker->phoneNumber(),
                'team_id' => $teams->id,
            ]);
        }
    }
}
