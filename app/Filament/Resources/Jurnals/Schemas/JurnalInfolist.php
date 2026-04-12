<?php

namespace App\Filament\Resources\Jurnals\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JurnalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Transaksi Keuangan')
                    ->schema([
                        TextEntry::make('keterangan'),
                        TextEntry::make('nominal')
                            ->money($locale = 'IDR'),
                        TextEntry::make('trx_date')
                            ->date(),
                        TextEntry::make('cabang.nama')
                            ->label('Cabang'),
                        TextEntry::make('ref'),
                        TextEntry::make('user.name')
                            ->label("Kasir"),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-')
                    ])->columnSpanFull()->columns(3),
                
                Section::make('Akun Transaksi')
                    ->schema([
                        RepeatableEntry::make('details')
                            ->schema([
                                TextEntry::make('coa.nama')
                                    ->inlineLabel(),
                                TextEntry::make('debit')
                                    ->money($locale ='IDR')
                                    ->inlineLabel(),
                                TextEntry::make('kredit')
                                    ->money($locale ='IDR')
                                    ->inlineLabel()
                            ])
                    ])->columnSpanFull()
            ]);
    }
}
