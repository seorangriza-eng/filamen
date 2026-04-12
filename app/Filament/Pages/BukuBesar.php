<?php

namespace App\Filament\Pages;

use App\Models\Jurnal;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use BackedEnum;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;

class BukuBesar extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationLabel = "Buku Besar";
    protected static string|BackedEnum|null $navigationIcon = Heroicon::BookOpen; 
    protected string $view = 'filament.pages.buku-besar';

    protected function getTableQuery(): Builder|Relation|null
    {
        return Jurnal::query()
            ->whereDate('created_at', today());
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('keterangan')->label('Keterangan'),
            TextColumn::make('nominal')->numeric(),
            TextColumn::make('trx_date')->label('Tanggal Transaksi')
        ];
    }

}
