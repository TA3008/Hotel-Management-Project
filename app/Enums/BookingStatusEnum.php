<?php

namespace App\Enums;

enum BookingStatusEnum: string
{
    case Confirmed = 'confirmed';
    case Pending = 'pending';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Confirmed => 'Đã xác nhận',
            self::Pending => 'Chờ xác nhận',
            self::Cancelled => 'Đã hủy',
        };
    }
}
