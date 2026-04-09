<?php

namespace App\Filament\Resources\Produks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProdukForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('harga')
                    ->required()
                    ->numeric(),
                Select::make('kategori_id')
                    ->relationship('kategori', 'nama')
                    ->required(),
                TextInput::make('deadline')
                    ->numeric(),
                Toggle::make('spesial_treatment')
                    ->required()
            ]);
    }
}
