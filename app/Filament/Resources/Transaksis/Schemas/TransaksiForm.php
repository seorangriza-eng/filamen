<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use App\Models\Produk;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class TransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoie')
                    ->label('Nomer Invoice')
                    ->default(fn () => 'INV-'.strtoupper(uniqid()))
                    ->disabled()
                    ->dehydrated(),
                Select::make('customer_id')->label('Nama Customer')
                    ->relationship('customer', 'nama')
                    ->searchable()
                    ->required(),
                Select::make('cabang_id')
                    ->label('Cabang')
                    ->relationship('cabang', 'nama')
                    ->required(),
                TextInput::make('total')
                    ->required()
                    ->numeric(),
                DatePicker::make('deadline')
                    ->required(),
                Toggle::make('spesial_treatment')
                    ->required(),

                //tambah produk
                Section::make('Detail Produk')
                    ->schema([
                        Repeater::make('details')
                        ->label('Produk')
                        ->schema([
                            Select::make('produk_id')
                                ->label('Produk')
                                ->options(Produk::pluck('nama', 'id'))
                                ->required()
                                ->live()
                                ->afterStateUpdated(function($state, Set $set){
                                    $produk = Produk::find($state);
                                    if ($produk){
                                        $set('nama', $produk->nama);
                                        $set('harga', $produk->harga);
                                    }
                                }),
                            TextInput::make('quantity')
                                ->required(),
                            TextInput::make('harga')
                                ->required()
                                ->disabled()
                                ->dehydrated()
                                ->live(debounce:500),
                            TextInput::make('total_belanja')
                            ->required()
                        ])->columns(4)
                ])->columnSpanFull()
        ]);
    }
}
