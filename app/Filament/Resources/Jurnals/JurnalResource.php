<?php

namespace App\Filament\Resources\Jurnals;

use App\Filament\Resources\Jurnals\Pages\CreateJurnal;
use App\Filament\Resources\Jurnals\Pages\EditJurnal;
use App\Filament\Resources\Jurnals\Pages\ListJurnals;
use App\Filament\Resources\Jurnals\Pages\ViewJurnal;
use App\Filament\Resources\Jurnals\Schemas\JurnalForm;
use App\Filament\Resources\Jurnals\Schemas\JurnalInfolist;
use App\Filament\Resources\Jurnals\Tables\JurnalsTable;
use App\Models\Jurnal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JurnalResource extends Resource
{
    protected static ?string $model = Jurnal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'keterangan';

    public static function form(Schema $schema): Schema
    {
        return JurnalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return JurnalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JurnalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJurnals::route('/'),
            'create' => CreateJurnal::route('/create'),
            'view' => ViewJurnal::route('/{record}'),
            'edit' => EditJurnal::route('/{record}/edit'),
        ];
    }
}
