<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Filament\Resources\Transaksis\TransaksiResource;
use App\Models\Transaksi;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaksi extends CreateRecord
{
    protected static string $resource = TransaksiResource::class;

    //hapus data dari 'details' utama seelum insert ke tabel transaksi
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1. Logika Pembuatan Nomor Invoice
        $today = now()->format('dmy');
        $countToday = Transaksi::whereDate('created_at', today())->count();
        $sequence = $countToday + 1;
    
        // Simpan ke array $data
        $data['invoice'] = "INV-{$today}{$sequence}";

        // $details = $data['details'] ?? [];
        unset($data['details']);    
        return $data;
    } 

    //setelah transaksi tersimpan, baru simpan detail-transksi
    protected function afterCreate(): void {
        $details = $this->data['details'] ??[];
        foreach ($details as $detail){
            $this->record->details()->create([
                'produk' => $detail['produk'],
                'quantity' => $detail['quantity'],
                'harga' => $detail['harga'],
            ]);
        }
    }
}
