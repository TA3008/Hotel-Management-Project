<?php

namespace App\Filament\Resources\Admin\AdminResource\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Filament\Tables\Columns\TextColumn;

class RecentBookings extends ChartWidget
{
    protected int|string|array $columnSpan = 'full';

    // BẮT BUỘC: Xác định loại biểu đồ
    protected function getType(): string
    {
        return 'line'; // hoặc 'bar', 'pie' tùy ý
    }

    protected function getData(): array
    {
        // Ví dụ đếm số booking theo tháng
        $data = Booking::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Số booking',
                    'data' => array_values($data),
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#3b82f6',
                ],
            ],
            'labels' => array_map(fn($m) => "Tháng $m", array_keys($data)),
        ];
    }
}
