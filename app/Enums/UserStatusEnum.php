<?php

namespace App\Enums;

enum UserStatusEnum: string
{
    case Active = 'active';
    case Pending = 'pending';
    case Inactive = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Hoạt động',
            self::Pending => 'Chờ duyệt',
            self::Inactive => 'Vô hiệu hóa',
        };
    }

    public static function options(): array
    {
        return [
            self::Active->value => self::Active->label(),
            self::Pending->value => self::Pending->label(),
            self::Inactive->value => self::Inactive->label(),
        ];
    }
}
