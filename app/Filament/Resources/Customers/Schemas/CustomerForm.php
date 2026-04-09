<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('nomer_wa')
                    ->required(),
                TextInput::make('rating')
                    ->default(3)
                    ->hidden()
                    ->dehydrated(),
                Select::make('cabang_id')
                    ->relationship('cabang', 'nama')
                    ->required(),
            ]);
    }
}
