<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Filament\Resources\Transaksis\TransaksiResource;
use App\Models\Transaksi;
use App\Models\Transaksi_detail;
use App\Models\Transaksi_pembayaran;
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
        $sequence = $countToday + 2;
    
        // Simpan ke array $data
        $data['invoice'] = "INV-{$today}{$sequence}";

        // $details = $data['details'] ?? [];
        unset($data['details']);    
        return $data;
    } 

        // setelah transaksi tersimpan, baru simpan detail-transksi
    protected function afterCreate(): void {
        $details = $this->data['details'] ??[];
        foreach ($details as $detail){
            $this->record->details()->create([
                'produk' => $detail['produk'],
                'quantity' => $detail['quantity'],
                'harga' => $detail['harga'],
            ]);
        }

        $data_bayar = $this->form->getState();
        //transaksi_id, user_id, jumlah_bayar, is_lunas, metode

        // $metode = $data_bayar['metode_bayar'];

        $entry = [
            'user_id' => $data_bayar['user_id'],
            'jumlah_bayar' => $data_bayar['total'],
            'is_lunas' => $data_bayar['is_lunas'],
            'metode' => $data_bayar['metode_bayar']
        ];

        Transaksi_pembayaran::create(array_merge($entry, ['transaksi_id' => $this->record->id]));
    }
}
