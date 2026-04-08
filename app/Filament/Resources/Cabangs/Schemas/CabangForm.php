<?php

namespace App\Filament\Resources\Cabangs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CabangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('alamat')
                    ->required(),
            ]);
    }
}
