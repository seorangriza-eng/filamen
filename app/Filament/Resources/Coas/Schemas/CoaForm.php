<?php

namespace App\Filament\Resources\Coas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;


class CoaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode')
                    ->required()
                    ->numeric(),
                TextInput::make('nama')
                    ->required(),
                Select::make('tipe')
                    ->options([
                        'aset' => 'Aset (harta)', 
                        'kewajiban' => 'Kewajiban (hutang)', 
                        'beban' => 'Beban / Biaya',
                        'pendapatan' => 'Pendapatan', 
                        'ekuitas' => 'Ekuitas (Modal)'
                    ])
                    ->live()
                    ->afterStateUpdated(function(Get $get, Set $set, ?string $state){
                        $normalBalance = match($state){
                            'aset', 'beban' => 'debit',
                            'kewajiban', 'pendapatan', 'ekuitas' => 'kredit',
                        };

                        $set('normal_balance', $normalBalance);
                    })
                    ->required(),
                TextInput::make('normal_balance')
                    ->readOnly(),
                Toggle::make('is_active')
                    ->default(true)
                    ->required(),
            ]);
    }
}
