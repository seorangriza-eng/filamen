<?php

namespace App\Filament\Resources\Jurnals\Schemas;

use App\Models\Coa;
use Dom\Text;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class JurnalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Transaksi Awal')
                ->schema([
                    Select::make('coa_1Id')
                            ->label("Akun Transaksi")
                            ->options(Coa::pluck("nama", 'id'))
                            ->required(),
                    TextInput::make('keterangan')
                        ->required(),  
                    Select::make('cabang_id')
                        ->label('Cabang')
                        ->relationship('cabang', 'nama'),
                    TextInput::make('nominal')
                            ->numeric()
                            ->prefix('IDR')
                            ->required(),   
                    DatePicker::make('trx_date')
                        ->default(today())
                        ->required(),
                    Hidden::make('user_id')
                        ->default(1)
                        ->dehydrated(),
                ])->columns(4)->columnSpanFull(),

                Section::make('COA Lawan')
                    ->schema([                                                  
                        Select::make('coa_2Id')
                            ->label("Keluar Ke / Masuk Dari")
                            ->options(Coa::pluck("nama", 'id'))
                            ->required(),
                        TextInput::make('ref')
                        ->required(),                     
                    ])->columns(3)->columnSpanFull(),

            ]);
    }
}
