<?php

namespace App\Filament\Resources\Transaksis\Tables;

use App\Enums\ProgressTransaksi;
use App\Models\Transaksi;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use function Laravel\Prompts\progress;

class TransaksisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice')
                    ->label('Nomer Invoice')
                    ->searchable(),
                TextColumn::make('customer.nama')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cabang.nama')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('progress')
                    ->badge()
                    ->sortable(),
                TextColumn::make('deadline')
                    ->sortable(),
                IconColumn::make('spesial_treatment')
                    ->boolean(),
                TextColumn::make('total')
                    ->numeric(),
                IconColumn::make('is_lunas')
                    ->label('Lunas?')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('progress')
                    ->schema([
                        ToggleButtons::make('progress')
                            ->options(ProgressTransaksi::class)
                            ->inline()->default('diterima')
                    ])
                    ->action(function(array $data, Transaksi $record){
                        $record->update([
                            'progress' => $data['progress']
                        ]);
                    }),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
