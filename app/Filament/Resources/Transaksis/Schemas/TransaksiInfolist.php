<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class TransaksiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Customer")
                    ->schema([
                        TextEntry::make('invoie')
                            ->label('Nomer Invoice')
                            ->inlineLabel(),
                        TextEntry::make('customer.nama')
                            ->label('Nama Customer')
                        ->inlineLabel(),
                        TextEntry::make('cabang.nama')
                            ->label('Cabang')
                            ->inlineLabel(),
                        TextEntry::make('total')
                            ->label('Total Pembelanjaan')
                            ->money('IDR')
                            ->inlineLabel(),
                        TextEntry::make('deadline')
                            ->inlineLabel(),
                        TextEntry::make('progress')
                            ->badge()
                            ->inlineLabel(),
                        IconEntry::make('spesial_treatment')
                            ->boolean()
                            ->inlineLabel(),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])->columns(2), 

                Section::make('Detail Transaksi')
                    ->schema([
                        RepeatableEntry::make('details')
                        ->schema([
                            TextEntry::make('produk')
                                ->label('Produk'),
                            TextEntry::make('harga'),
                            TextEntry::make('quantity')
                        ])->columns(3)
                ])

            ])->columns(1);
    }
}
