<?php

namespace App\Filament\Pages;

use App\Models\Jurnal;
use App\Models\Jurnal_detail;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;

class BukuBesar extends Page implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationLabel = "Buku Besar";
    protected static string|BackedEnum|null $navigationIcon = Heroicon::BookOpen; 
    protected string $view = 'filament.pages.buku-besar';

    public ?array $data = [];

    public function mount() : void 
    {
        $this->form->fill();
    }

    // public function form(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             DatePicker::make('test')
    //             ->default(today())->required()
    //         ]);
    // }

    // protected function getTableQuery(): Builder|Relation|null
    // {
    //     return Jurnal::query()
    //         ->whereDate('created_at', today());

        
    
    // }

    // protected function getTableColumns(): array
    // {
    //     return [
    //         TextColumn::make('keterangan')->label('Keterangan'),
    //         TextColumn::make('nominal')->numeric(),
    //         TextColumn::make('trx_date')->label('Tanggal Transaksi')
    //     ];
    // }

    public function table(Table $table): Table
    {
        return $table
            ->query(Jurnal::query())
            ->columns([
                TextColumn::make('trx_date')->date()->sortable(),
                TextColumn::make('keterangan'),
                TextColumn::make('nominal')->money('IDR'),
            ])
            ->filters([
                Filter::make('tanggal')
                    // Ganti form() menjadi schema()
                    ->schema([
                        DatePicker::make('dari')
                            ->placeholder('Pilih Tanggal Mulai'),
                        DatePicker::make('sampai')
                            ->placeholder('Pilih Tanggal Selesai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari'],
                                fn (Builder $query, $date): Builder => $query->whereDate('trx_date', '>=', $date),
                            )
                            ->when(
                                $data['sampai'],
                                fn (Builder $query, $date): Builder => $query->whereDate('trx_date', '<=', $date),
                            );
                    })
                    // Opsional: Menampilkan indikator filter aktif di atas tabel
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['dari'] ?? null) {
                            $indicators[] = 'Dari: ' . \Carbon\Carbon::parse($data['dari'])->format('d/m/Y');
                        }
                        if ($data['sampai'] ?? null) {
                            $indicators[] = 'Sampai: ' . \Carbon\Carbon::parse($data['sampai'])->format('d/m/Y');
                        }
                        return $indicators;
                    })
            ]);
    }

}
