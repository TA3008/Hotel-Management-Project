<?php

namespace App\Filament\Resources\Admin\AdminResource\Widgets;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use Filament\Widgets\ChartWidget;

class BookingRevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Doanh thu theo tháng';

    protected function getData(): array
    {
        $year = now()->year;

        $data = DB::table('booking_details')
            ->join('bookings', 'booking_details.booking_id', '=', 'bookings.id')
            ->selectRaw('EXTRACT(MONTH FROM bookings.created_at) as month, SUM(booking_details.price) as total')
            ->whereRaw('EXTRACT(YEAR FROM bookings.created_at) = ?', [$year])
            // Nếu multi-tenant, filter theo hotel_id
            ->when(auth()->user()->hotel_id ?? null, function ($query, $hotelId) {
                $query->where('bookings.hotel_id', $hotelId);
            })
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Chuẩn bị mảng đủ 12 tháng
        $revenues = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenues[] = $data[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Doanh thu',
                    'data' => $revenues,
                    'backgroundColor' => '#3b82f6',
                ],
            ],
            'labels' => ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
