<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $teams = Team::first() ?? Team::factory()->create();

        foreach (range(1, 20) as $i) {
            Customer::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'), // default password
                'phone' => $faker->phoneNumber(),
                'date_of_birth' => $faker->dateTimeBetween('-60 years', '-18 years'),
                'address' => $faker->address(),
                'identity_number' => $faker->numerify('##########'), // 10 số
                'customer_type' => collect(['regular', 'vip'])->random(),
                'team_id' => $teams->id,
            ]);
        }
    }
}
