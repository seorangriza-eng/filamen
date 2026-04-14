<?php

namespace App\Filament\Resources\TransaksiPembayarans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TransaksiPembayaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('transaksi.invoie')
                    ->label('Nomer Invoice')
                    ->disabled(),
                TextInput::make('user.nama')
                    ->label('Kasir')
                    ->disabled(),
                TextInput::make('customer.nama')
                    ->label('Nama Pelanggan')
                    ->disabled(),
                TextInput::make('jumlah_bayar')
                    ->label('Nominal')
                    ->prefix('IDR')
                    ->required(),
                Select::make('Metode Bayar')
                    ->options([
                        "qris" => "Qris",
                        "transfer" => "Transfer",
                        "tunai" => "Tunai"
                    ])->required(),
                TextInput::make('Status Lunas')
            ]);
    }
}
