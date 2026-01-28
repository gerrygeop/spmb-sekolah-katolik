<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RegistrationStatus: string implements HasLabel, HasColor
{
    case VERIFIKASI = 'verifikasi';
    case PERBAIKAN = 'perlu perbaikan';
    case PEMBAYARAN_TERTUNDA = 'pembayaran tertunda';
    case PEMBAYARAN_TERVERIFIKASI = 'pembayaran terverifikasi';
    case TERVERIFIKASI = 'terverifikasi';
    case DITERIMA = 'diterima';
    case DITOLAK = 'ditolak';

    public function getLabel(): string
    {
        return match ($this) {
            self::VERIFIKASI => 'Sedang Diverifikasi',
            self::PERBAIKAN => 'Perlu Perbaikan',
            self::PEMBAYARAN_TERTUNDA => 'Menunggu Pembayaran',
            self::PEMBAYARAN_TERVERIFIKASI => 'Pembayaran Terverifikasi',
            self::TERVERIFIKASI => 'Terverifikasi',
            self::DITERIMA => 'Diterima',
            self::DITOLAK => 'Ditolak',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::VERIFIKASI => 'warning',
            self::PERBAIKAN => 'danger',
            self::PEMBAYARAN_TERTUNDA => 'warning',
            self::PEMBAYARAN_TERVERIFIKASI => 'success',
            self::TERVERIFIKASI => 'info',
            self::DITERIMA => 'success',
            self::DITOLAK => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::VERIFIKASI => 'heroicon-o-clock',
            self::PERBAIKAN => 'heroicon-o-exclamation-triangle',
            self::PEMBAYARAN_TERTUNDA => 'heroicon-o-currency-dollar',
            self::PEMBAYARAN_TERVERIFIKASI => 'heroicon-o-check-circle',
            self::TERVERIFIKASI => 'heroicon-o-check-circle',
            self::DITERIMA => 'heroicon-o-check-badge',
            self::DITOLAK => 'heroicon-o-x-circle',
        };
    }

    public function statusColor(): string
    {
        return match ($this) {
            self::VERIFIKASI => 'bg-blue-100 text-blue-800 border-blue-300',
            self::PERBAIKAN => 'bg-orange-100 text-orange-800 border-orange-300',
            self::PEMBAYARAN_TERTUNDA => 'bg-yellow-100 text-yellow-800 border-yellow-300',
            self::PEMBAYARAN_TERVERIFIKASI => 'bg-green-100 text-green-800 border-green-300',
            self::TERVERIFIKASI => 'bg-indigo-100 text-indigo-800 border-indigo-300',
            self::DITERIMA => 'bg-green-100 text-green-800 border-green-300',
            self::DITOLAK => 'bg-red-100 text-red-800 border-red-300',
        };
    }

    public function statusIcon(): string
    {
        return match ($this) {
            self::VERIFIKASI => '📝',
            self::PERBAIKAN => '⚠️',
            self::PEMBAYARAN_TERTUNDA => '💳',
            self::PEMBAYARAN_TERVERIFIKASI => '✅',
            self::TERVERIFIKASI => '🔍',
            self::DITERIMA => '🎉',
            self::DITOLAK => '❌',
        };
    }
}
