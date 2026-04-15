<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Filament\Resources\Transaksis\TransaksiResource;
use App\Models\Jurnal;
use App\Models\Jurnal_detail;
use App\Models\Transaksi;
use App\Models\Transaksi_detail;
use App\Models\Transaksi_pembayaran;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateTransaksi extends CreateRecord
{
    protected static string $resource = TransaksiResource::class;

    //menjadikan tersimpan semua di tabel transksi, detail, dan pembayarn
    //jika satu step gagal, maka successorfail
    protected function handleRecordCreation(array $data): Model
    {
       $transaksi = DB::transaction(function () use ($data){
            //simpan transaksi utama
            $transaksi = static::getModel()::create($data);

            if(!$transaksi){
                throw new \Exception('gagal menyimpan tranksaksi utama');
            }

            //simpan ke tabel detail
            $details = $this->data['details'] ?? [];
            foreach ($details as $detail){
                $transaksi->details()->create([
                    'produk' => $detail['produk'],
                    'quantity' => $detail['quantity'],
                    'harga' => $detail['harga']
                ]);
            }

            //simpan ke tabel transaksi_pembayaran
            $bayar = $this->form->getState();
            Transaksi_pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'user_id' => $bayar['user_id'],
                'jumlah_bayar' => $bayar['jumlah_bayar'],
                'is_lunas' => $bayar['is_lunas']
            ]);

            if ($bayar['is_lunas'] == true){
                //simpan ke tabel Jurnal
                $jurnal = Jurnal::create([
                    'keterangan' => $transaksi['invoice'],
                    'nominal' => $bayar['jumlah_bayar'],
                    'trx_date' => today(),
                    'cabang_id' => $transaksi['cabang_id'],
                    'user_id' => $transaksi['user_id'],
                    'ref' => $transaksi['invoice'],
                    'ref_type' => 'penjualan',
                    'ref_id' => $transaksi->id
                ]);

                //simpan ke tabel jurnal detail
                Jurnal_detail::create([
                    'jurnal_id' => $jurnal->id, 'coa_id' => 8, 'debit' => $bayar['jumlah_bayar'], 'kredit' => 0
                ]);
                Jurnal_detail::create([
                    'jurnal_id' => $jurnal->id, 'coa_id' => 1, 'debit' => 0, 'kredit' => $bayar['jumlah_bayar']
                ]);
            }

            return $transaksi;
        });
        return $transaksi;
    }

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



    // // setelah transaksi tersimpan, baru simpan detail-transksi
    // protected function afterCreate(): void {
    //     $details = $this->data['details'] ??[];
    //     foreach ($details as $detail){
    //         $this->record->details()->create([
    //             'produk' => $detail['produk'],
    //             'quantity' => $detail['quantity'],
    //             'harga' => $detail['harga'],
    //         ]);
    //     }

    //     $data_bayar = $this->form->getState();
    //     //transaksi_id, user_id, jumlah_bayar, is_lunas, metode

    //     // $metode = $data_bayar['metode_bayar'];

    //     $entry = [
    //         'user_id' => $data_bayar['user_id'],
    //         'jumlah_bayar' => $data_bayar['total'],
    //         'is_lunas' => $data_bayar['is_lunas'],
    //         'metode' => $data_bayar['metode_bayar']
    //     ];

    //     Transaksi_pembayaran::create(array_merge($entry, ['transaksi_id' => $this->record->id]));
    // }

}
