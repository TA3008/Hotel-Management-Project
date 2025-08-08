<?php

namespace App\Enums;

enum BookingStaffTaskEnum: string
{
    case CheckinAssist = 'checkin_assist';
    case Cleaning = 'cleaning';
    case SpecialRequest = 'special_request';

    public function label(): string
    {
        return match ($this) {
            self::CheckinAssist => 'Hỗ trợ Check-in',
            self::Cleaning => 'Dọn phòng',
            self::SpecialRequest => 'Yêu cầu đặc biệt',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn($case) => ['label' => $case->label(), 'value' => $case->value],
            self::cases()
        );
    }
}
