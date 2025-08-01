<?php

namespace App\Filament\Resources\Admin\AdminResource\Widgets;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Customer;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class BookingStats extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Tổng Booking', Booking::where('team_id', Filament::getTenant()->id)->count())
                ->description('Tất cả đơn đặt phòng')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),

            Card::make('Khách hàng', Customer::where('team_id', Filament::getTenant()->id)->count())
                ->description('Tổng khách hàng đã đăng ký')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Card::make('Phòng', Room::where('team_id', Filament::getTenant()->id)->count())
                ->description('Số lượng phòng hiện có')
                ->descriptionIcon('heroicon-m-home-modern')
                ->color('warning'),
        ];
    }
}
