<?php

namespace App\Filament\Resources\Produks\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProdukForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')->label('Nama Produk')->required(),
                TextInput::make('harga')->label('Harga Produk')->required(),
                TextInput::make('deskripsi'),
                Select::make('kategori_id')->label('Kategori')
                    ->relationship('kategori', 'nama')->required(),
                TextInput::make('deadline')->label('Deadline (Hari)')->required(),
                Radio::make('spesial_treatment')->label('Spesial Treatment?')
                    ->options([
                        1 => 'Ya',
                        0 => 'Tidak'
                    ])
                    ->inline()->required()
            ])->columns(3);
    }
}
