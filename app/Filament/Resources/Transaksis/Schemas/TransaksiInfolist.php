<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TransaksiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('invoie'),
                TextEntry::make('customer_id')
                    ->numeric(),
                TextEntry::make('cabang_id')
                    ->numeric(),
                TextEntry::make('total')
                    ->numeric(),
                TextEntry::make('deadline')
                    ->date(),
                IconEntry::make('spesial_treatment')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
