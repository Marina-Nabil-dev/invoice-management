<?php

namespace App\Enums;

enum InvoiceStatusEnum: string
{
    use EnumHelper;
    case Pending = 'pending';

    case Paid = 'paid';

    case Cancelled = 'cancelled';

    public static function colors($status = null): string|array
    {
        $statuses = [
            self::Pending->value => 'info',
            self::Paid->value => 'success',
            self::Cancelled->value => 'danger',
        ];

        return $status ? $statuses[$status] : $statuses;
    }
}
