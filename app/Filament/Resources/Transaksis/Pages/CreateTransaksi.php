<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Filament\Resources\Transaksis\TransaksiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaksi extends CreateRecord
{
    protected static string $resource = TransaksiResource::class;

    //hapus data dari 'details' utama seelum insert ke tabel transaksi
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $details = $data['details'] ?? [];
        unset($data['details']);    
    
        return $data;
    } 

    //setelah transaksi tersimpan, baru simpan detail-transksi
    protected function afterCreate(): void {
        $details = $this->data['details'] ??[];
        foreach ($details as $detail){
            $this->record->details()->create([
                // 'transaksi_id' => '1',
                'produk_id' => $detail['produk_id'],
                'quantity' => $detail['quantity'],
                'harga' => $detail['harga'],
                'total_belanja' => $detail['total_belanja']
            ]);
        }
    }
}
