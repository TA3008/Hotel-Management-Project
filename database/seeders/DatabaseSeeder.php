<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\TeamSeeder;
use Database\Seeders\BranchSeeder;
use Database\Seeders\AmenitySeeder;
use Database\Seeders\VoucherSeeder;
use Database\Seeders\RoomTypeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BranchSeeder::class,
            AmenitySeeder::class,
            RoomTypeSeeder::class,
            RoomSeeder::class,
            VoucherSeeder::class,
            CustomerSeeder::class,
            BookingSeeder::class,
            BookingDetailSeeder::class,
            PaymentSeeder::class,
        ]);
    }
}
