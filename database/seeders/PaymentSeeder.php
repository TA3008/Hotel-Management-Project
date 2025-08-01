<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = Booking::all()->pluck('id');

        foreach ($bookings as $bookingId) {
            Payment::create([
                'booking_id' => $bookingId,
                'amount' => rand(500000, 3000000),
                'payment_method' => collect(['vnpay', 'momo', 'cash'])->random(),
                'status' => collect(['pending', 'completed', 'failed'])->random(),
                'response_data' => 'Simulated payment response',
            ]);
        }
    }
}
