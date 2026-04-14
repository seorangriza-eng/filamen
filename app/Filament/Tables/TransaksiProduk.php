<?php

namespace App\Filament\Tables;

use App\Models\Produk;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TransaksiProduk
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Produk::query())
            ->columns([
                TextColumn::make('nama'),
                TextColumn::make('deadline')
                    ->formatStateUsing(fn(string $state):
                            string => $state . " hari" 
                    ),
                TextColumn::make('harga'),
                
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
