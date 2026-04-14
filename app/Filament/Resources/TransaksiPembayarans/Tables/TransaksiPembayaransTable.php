<?php

namespace App\Filament\Resources\TransaksiPembayarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransaksiPembayaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transaksi.invoie')
                    ->label('Nomer Invoice'),
                TextColumn::make('user.nama')
                    ->label('Kasir'),
                TextColumn::make('customer.nama')
                    ->label('Nama Pelanggan'),
                TextColumn::make('jumlah_bayar')
                    ->label('Nominal')
                    ->numeric(),
                TextColumn::make('metode_bayar')
                    ->label('Metode Pembayaran'),
                IconColumn::make('Status Lunas')
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
