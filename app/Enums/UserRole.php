<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserRole: string implements HasLabel
{
    case ADMIN = 'admin';
    case ADMIN_SMP = 'admin_smp';
    case ADMIN_SMA = 'admin_sma';
    case USER = 'user';

    public function getLabel(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::ADMIN_SMP => 'Administrator SMP',
            self::ADMIN_SMA => 'Administrator SMA',
            self::USER => 'User',
        };
    }

    public function isAnyAdmin(): bool
    {
        return in_array($this, [
            self::ADMIN,
            self::ADMIN_SMA,
            self::ADMIN_SMP,
        ]);
    }
}
