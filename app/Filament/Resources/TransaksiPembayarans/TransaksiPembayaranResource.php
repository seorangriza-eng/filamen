<?php

namespace App\Filament\Resources\TransaksiPembayarans;

use App\Filament\Resources\TransaksiPembayarans\Pages\CreateTransaksiPembayaran;
use App\Filament\Resources\TransaksiPembayarans\Pages\EditTransaksiPembayaran;
use App\Filament\Resources\TransaksiPembayarans\Pages\ListTransaksiPembayarans;
use App\Filament\Resources\TransaksiPembayarans\Pages\ViewTransaksiPembayaran;
use App\Filament\Resources\TransaksiPembayarans\Schemas\TransaksiPembayaranForm;
use App\Filament\Resources\TransaksiPembayarans\Schemas\TransaksiPembayaranInfolist;
use App\Filament\Resources\TransaksiPembayarans\Tables\TransaksiPembayaransTable;
use App\Models\Transaksi_pembayaran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TransaksiPembayaranResource extends Resource
{
    protected static ?string $model = Transaksi_pembayaran::class;

    protected static ?string $navigationLabel = "Pembayaran";

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Briefcase;

    protected static string|UnitEnum|null $navigationGroup = "Penjualan";

    protected static ?string $recordTitleAttribute = 'transaksi_id';

    public static function form(Schema $schema): Schema
    {
        return TransaksiPembayaranForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TransaksiPembayaranInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransaksiPembayaransTable::configure($table);
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
            'index' => ListTransaksiPembayarans::route('/'),
            'create' => CreateTransaksiPembayaran::route('/create'),
            'view' => ViewTransaksiPembayaran::route('/{record}'),
            'edit' => EditTransaksiPembayaran::route('/{record}/edit'),
        ];
    }
}
