<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ProgressTransaksi: string implements HasLabel, HasColor
{
    case Diterima = 'diterima';
    case Selesai = 'selesai';
    case Komplit = 'komplit';

    public function getLabel(): string|Htmlable|null
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Diterima => 'danger',
            self::Selesai => 'warning',
            self::Komplit => 'success'
        };
    }
}