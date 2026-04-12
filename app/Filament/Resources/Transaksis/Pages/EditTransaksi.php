<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Filament\Resources\Transaksis\TransaksiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTransaksi extends EditRecord
{
    protected static string $resource = TransaksiResource::class;

    // Load detail ke dalam Repeater saat halaman edit dibuka
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['details'] = $this->record->details()
            ->get(['produk', 'harga', 'quantity'])
            ->toArray();

        return $data;
    }

    //hapus data dari 'details' utama sebelum insert ke tabel transaksi
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // $details = $data['details'] ?? [];
        unset($data['details']);    
    
        return $data;
    } 

    //setelah transaksi tersimpan, baru simpan detail-transksi
    protected function afterSave(): void {
        $details = $this->data['details'] ?? [];

        $this->record->details()->delete();

        foreach ($details as $detail){
            $this->record->details()->create([
                'produk' => $detail['produk'],
                'quantity' => $detail['quantity'],
                'harga' => $detail['harga'],
            ]);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
