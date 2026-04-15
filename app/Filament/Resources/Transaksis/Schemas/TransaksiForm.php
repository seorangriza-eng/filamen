<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use App\Enums\ProgressTransaksi;
use App\Filament\Tables\PilihCustomer;
use App\Filament\Tables\TransaksiProduk;
use App\Models\Customer;
use App\Models\Produk;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\ModalTableSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Filters\QueryBuilder;

class TransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // dd(auth()->user()),
                Section::make('Customer')
                    ->schema([
                        Hidden::make('invoice')
                            ->dehydrated(),
                        Hidden::make('user_id')
                            ->default(fn () => auth()->user()?->id
                            ),
                        // Select::make('customer_id')->label('Nama Customer')
                        //     ->relationship('customer', 'nama')
                        //     ->createOptionForm([
                        //         TextInput::make('nama')->required(),
                        //         TextInput::make('nomer_wa')->required(),
                        //         hidden::make('rating')->default(3)->dehydrated(),
                        //         Select::make('cabang_id')
                        //             ->relationship('cabang', 'nama')
                        //             ->required()
                        //     ])
                        //     ->searchable()
                        //     ->required(),
                        ModalTableSelect::make('customer_id')
                            ->relationship('customer', 'nama')
                            ->tableConfiguration(PilihCustomer::class)
                            ->live()
                            ->afterStateUpdated(function($state, Set $set){
                                    $cabangid = Customer::find($state);
                                    if ($cabangid){
                                        $set('cabang_id', $cabangid->cabang_id);
                                    }
                                })
                            ->getOptionLabelFromRecordUsing(fn (Customer $record): 
                                string => "{$record->nama} ({$record->nomer_wa})"),
                        // Select::make('cabang_id')
                        //     ->label('Cabang')
                        //     ->relationship('cabang', 'nama')
                        //     ->required(),
                        Actions::make([
                            Action::make('Tambah Customer')
                                ->label('+ Tambah')
                                ->icon('heroicon-o-user-plus')
                        ]),
                        Hidden::make('cabang_id')->live()->dehydrated(),
                        TextInput::make('deadline')
                            ->numeric()
                            ->readOnly()
                            ->required(),
                        ToggleButtons::make('Progress')
                            ->options(ProgressTransaksi::class)
                            ->inline()->default('diterima'),
                        Checkbox::make('spesial_treatment')
                            ->inline(),
                    ])->columns(3)->columnSpanFull(),                


                //Repeater untuk bagian tambah produk

                Section::make('Detail Produk')
                    ->schema([
                        Repeater::make('details')
                        ->label('Produk')
                        ->schema([
                            // Select::make('produk_id')
                            //     ->label('Produk')
                            //     ->options(Produk::pluck('nama', 'id'))
                            //     ->required()
                            //     ->live()
                            //     ->afterStateUpdated(function($state, Set $set){
                            //         if ($produk = Produk::find($state)){
                            //             $set('produk', $produk->nama);
                            //             $set('harga', $produk->harga);
                            //             }
                            //         }),
                            ModalTableSelect::make('pilih_produk')
                                ->label('Produk / Jasa')
                                ->tableConfiguration(TransaksiProduk::class)
                                ->getOptionLabelUsing(fn ($value) => Produk::find($value)?->nama ?? '-')
                                ->afterStateUpdated(function ($state, Set $set){
                                    $produk = Produk::find($state);
                                    if ($produk){
                                        $set('produk', $produk->nama);
                                        $set('harga', $produk->harga);
                                        if($produk->deadline >= 0){
                                            $set('../../deadline', $produk->deadline);
                                        }
                                        if($produk->spesial_treatment == true){
                                                $set('../../spesial_treatment', $produk->spesial_treatment);
                                        }
                                    }
                                })
                                ->live()
                                ->required(),
                            Hidden::make('produk'),
                            TextInput::make('harga')
                                ->numeric()
                                ->disabled()
                                ->live()
                                ->numeric()
                                ->prefix('IDR'),
                            TextInput::make('quantity')
                                ->numeric()
                                ->required()
                                ->live()
                                ->afterStateUpdated(function($state, Set $set, Get $get){
                                    $harga = $get('harga');
                                    $set('total_belanja', $state * $harga); 
                                    self::HitungTotal($set, $get);
                                }),
                            TextInput::make('total_belanja')
                                ->label('Total')
                                ->numeric()
                                ->prefix('IDR')
                                ->disabled()
                                ->dehydrated()
                        ])->columns(4)
                ])->columnSpanFull(),

                Section::make('Pembayaran')
                    ->schema([
                        TextInput::make('total')
                            ->label('Subtotal Belanja')
                            ->numeric()
                            ->readOnly(),
                        ToggleButtons::make('metode_bayar')
                            ->label('Metode Pembayaran')
                            ->options([
                                "tunai" => "Tunai",
                                "qris" => "Qris",
                                "transfer" => "Transfer",
                                "piutang" => "Piutang",
                            ])
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set){
                                if ($state == 'piutang'){
                                    $lunas = false;
                                } else {
                                    $lunas = true;
                                }
                                $set('is_lunas', $lunas);
                            })
                            ->inline(),
                        Checkbox::make('is_lunas')->default(false)->dehydrated(),
                ])->columnSpanFull()->columns(2)
        ]);
    }

    protected static function hitungTotal(Set $set, Get $get) : void {
        $details = $get('../../details') ?? [];
        $total = collect($details)->sum(fn ($item) =>
            ($item['harga'] ?? 0) * ($item['quantity'] ?? 0)
        );
        $set('../../total', $total);
    }
}
