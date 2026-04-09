<?php

namespace App\Filament\Resources\Produks\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProdukInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama'),
                TextEntry::make('harga')
                    ->numeric(),
                TextEntry::make('kategori.id')
                    ->label('Kategori'),
                TextEntry::make('deadline')
                    ->numeric()
                    ->placeholder('-'),
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
