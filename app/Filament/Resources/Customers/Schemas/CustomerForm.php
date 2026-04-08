<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\Models\Cabang;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Customer')
                ->schema([
                    TextInput::make('nama')->label('Nama Customer')->required(),
                    TextInput::make('nomer_wa')->label('Nomer Whatsapp')->required(),
                ]),

                Section::make('Solecampus Detail')
                ->schema([
                    TextInput::make('rating')->nullable(),
                    Select::make('cabang_id')
                    ->options(Cabang::all()->pluck('nama', 'id'))
                        ->label('Cabang')->searchable()->required()
                ])
            ])->columns(2);
    }
}
