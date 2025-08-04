<?php

namespace App\Enums;

enum CustomerTypeEnum: string
{
    case Regular = 'regular';
    case VIP = 'vip';

    public function label(): string
    {
        return match ($this) {
            self::Regular => 'Khách thường',
            self::VIP => 'Khách VIP',
        };
    }
}
