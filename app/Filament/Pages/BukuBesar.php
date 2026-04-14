<?php

namespace App\Filament\Pages;

use App\Models\Coa;
use App\Models\Jurnal;
use App\Models\Jurnal_detail;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class BukuBesar extends Page implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    protected static ?string $navigationLabel = "Buku Besar";
    protected static string|BackedEnum|null $navigationIcon = Heroicon::BookOpen;
    protected static string|UnitEnum|null $navigationGroup = "Keuangan";
    protected string $view = 'filament.pages.buku-besar';

    // public ?array $data = [];

    // public function mount() : void 
    // {
    //     $this->form->fill();
    // }

    // //query awal tabel jurnal dan jurnal_details
    // protected function getTableQuery(): Builder|Relation|null
    // {
    //     return Jurnal::query()
    //         ->withSum('details as total_debit', 'debit')
    //         ->withSum('details as total_kredit', 'kredit')
    //         ->orderby('trx_date');

    // }

    public ?array $filterData = [];
    public ?int $selectedCoaId = null;

    public function updatedSelectedCoaId(): void
    {
        $this->resetTable();
    }

    public function mount(): void
    {
        $this->selectedCoaId = Coa::where('is_active', true)
            ->orderBy('kode')
            ->first()?->id;

        $this->filterData = [
            'selectedCoaId' => $this->selectedCoaId,
        ];
    }

    //Filter untuk COA
    public function form(Schema $schema): Schema
    {
        Return $schema
            ->components([
                Select::make('selectedCoaId')
                    ->label('Akun')
                    ->options(COA::where('is_active', true)
                        ->pluck("nama", "id"))
                    ->live()
                    ->afterstateUpdated(function ($state){
                        $this->selectedCoaId = $state;
                    }),
            ])->statePath('filterData');
    }

    protected function getTableQuery(): Builder|Relation|null
    {
        $coaId = $this->selectedCoaId ?? Coa::where('is_active', true)->first()?->id;

        $layer1 = DB::table('jurnals')
            ->select([
                'jurnals.id',
                'jurnals.trx_date',
                'jurnals.keterangan',
                DB::raw('COALESCE(jd.debit, 0) as total_debit'),
                DB::raw('COALESCE(jd.kredit, 0) as total_kredit'),
            ])
            ->join('jurnal_details as jd', function ($join) use ($coaId) {
                $join->on('jd.jurnal_id', '=', 'jurnals.id')
                    ->where('jd.coa_id', '=', $coaId);
            })
            ->orderBy('jurnals.trx_date')
            ->orderBy('jurnals.id');

        $layer2 = DB::table(DB::raw("({$layer1->toSql()}) as base"))
            ->mergeBindings($layer1)
            ->select([
                'id',
                'trx_date',
                'keterangan',
                'total_debit',
                'total_kredit',
                DB::raw('SUM(total_debit - total_kredit) OVER (ORDER BY trx_date, id ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW) as saldo'),
            ]);

        return Jurnal::query()
            ->from(DB::raw("({$layer2->toSql()}) as jurnal_gl"))
            ->mergeBindings($layer2)
            ->select('*')
            ->reorder('trx_date', 'asc')
            ->orderBy('id');
    }

    //Kolom pada tampilan halaman
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('trx_date')->date(),
            TextColumn::make('keterangan'),
            TextColumn::make('total_debit')
                ->money('IDR'),
            TextColumn::make('total_kredit')
                ->money('IDR'),
            TextColumn::make('saldo')
                ->money('IDR')
        ];
    }

    //Filter
    protected function getTableFilters(): array
    {
        return [
            Filter::make('tanggal')
                ->schema([
                        DatePicker::make('dari')
                            ->placeholder('Pilih Tanggal Mulai')
                            ->default(today()),
                        DatePicker::make('sampai')
                            ->placeholder('Pilih Tanggal Selesai')
                            ->default(today()),
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
                    }),
        ];
    }

    public function updatedTableFilters(): void
    {
        $this->selectedCoaId = $this->tableFilters['coa_id']['value'] ?? null;
        dd($this->tableFilters);
    }

    // public function table(Table $table): Table
    // {
    //     return $table
    //         ->query(Jurnal::query())
    //         ->columns([
    //             TextColumn::make('trx_date')->date()->sortable(),
    //             TextColumn::make('keterangan'),
    //             TextColumn::make('nominal')
    //                 ->formatStateUsing(fn ($record) => 
    //                     $this->details->sum('debit'))
    //                 ->numeric()
    //         ])
    //         ->filters([
    //             Filter::make('tanggal')
    //                 // Ganti form() menjadi schema()
    //                 ->schema([
    //                     DatePicker::make('dari')
    //                         ->placeholder('Pilih Tanggal Mulai'),
    //                     DatePicker::make('sampai')
    //                         ->placeholder('Pilih Tanggal Selesai'),
    //                 ])
    //                 ->query(function (Builder $query, array $data): Builder {
    //                     return $query
    //                         ->when(
    //                             $data['dari'],
    //                             fn (Builder $query, $date): Builder => $query->whereDate('trx_date', '>=', $date),
    //                         )
    //                         ->when(
    //                             $data['sampai'],
    //                             fn (Builder $query, $date): Builder => $query->whereDate('trx_date', '<=', $date),
    //                         );
    //                 })->columnSpanFull()->columns(3)
    //                 // Opsional: Menampilkan indikator filter aktif di atas tabel
    //                 ->indicateUsing(function (array $data): array {
    //                     $indicators = [];
    //                     if ($data['dari'] ?? null) {
    //                         $indicators[] = 'Dari: ' . \Carbon\Carbon::parse($data['dari'])->format('d/m/Y');
    //                     }
    //                     if ($data['sampai'] ?? null) {
    //                         $indicators[] = 'Sampai: ' . \Carbon\Carbon::parse($data['sampai'])->format('d/m/Y');
    //                     }
    //                     return $indicators;
    //                 })
    //         ],layout:FiltersLayout::AboveContent
    //         );
    // }

}
