<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SchoolLevel: string implements HasLabel
{
    case SMP = 'smp';
    case SMA = 'sma';

    public function getLabel(): string
    {
        return match ($this) {
            self::SMP => 'Sekolah Menengah Pertama (SMP)',
            self::SMA => 'Sekolah Menengah Atas (SMA)',
        };
    }
}
