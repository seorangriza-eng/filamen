<?php

namespace App\Enums;

enum ProgressTransaksi: string
{
    case Diterima = 'diterima';
    case Selesai = 'selesai';
    case Komplit = 'komplit';
}