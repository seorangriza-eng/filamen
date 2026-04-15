<?php

namespace Database\Seeders;

use App\Models\Cabang;
use App\Models\Coa;
use App\Models\Customer;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345')
        ]);

        Cabang::insert([
            ['nama' => 'injoko', 'alamat' => 'kebonsari nomer 3', 'nomer_wa' => '081365626565'],
            ['nama' => 'marvel', 'alamat' => 'marvel mall, lantai 3 no 121', 'nomer_wa' => '08135546423'],
        ]);

        Coa::insert([
            ['kode' => '101', 'nama' => 'pendapatan', 'tipe' => 'pendapatan', 'normal_balance' => 'kredit', 'is_active' => '1'],
            ['kode' => '102', 'nama' => 'pendapatan lain', 'tipe' => 'pendapatan', 'normal_balance' => 'kredit', 'is_active' => '1'],
            ['kode' => '201', 'nama' => 'biaya listrik', 'tipe' => 'beban', 'normal_balance' => 'debit', 'is_active' => '1'],
            ['kode' => '202', 'nama' => 'biaya operasional', 'tipe' => 'beban', 'normal_balance' => 'debit', 'is_active' => '1'],
            ['kode' => '203', 'nama' => 'gaji pegawai', 'tipe' => 'beban', 'normal_balance' => 'debit', 'is_active' => '1'],
            ['kode' => '301', 'nama' => 'adjustment masuk', 'tipe' => 'aset', 'normal_balance' => 'debit', 'is_active' => '1'],
            ['kode' => '302', 'nama' => 'adjustment keluar', 'tipe' => 'aset', 'normal_balance' => 'debit', 'is_active' => '1'],
            ['kode' => '401', 'nama' => 'kas injoko', 'tipe' => 'aset', 'normal_balance' => 'debit', 'is_active' => '1'],
        ]);

         Customer::insert([
            ['nama' => 'Fachreza Bima', 'nomer_wa' => '085632654564', 'rating' => '3', 'cabang_id' => 1],
            ['nama' => 'Gunawan Kuru', 'nomer_wa' => '085632653333', 'rating' => '3', 'cabang_id' => 1],
            ['nama' => 'Zaizai Pahlevi', 'nomer_wa' => '08563261111', 'rating' => '3', 'cabang_id' => 2],
            ['nama' => 'Imam Santoso', 'nomer_wa' => '085632650000', 'rating' => '3', 'cabang_id' => 2],
            ['nama' => 'Rafa Arya', 'nomer_wa' => '08563269999', 'rating' => '3', 'cabang_id' => 2],
        ]);

        Kategori::insert([
            ['nama' => 'jasa'],
            ['nama' => 'barang'],
            ['nama' => 'promo']
        ]);

        Produk::insert([
            ['nama' => 'Deep Clean', 'harga' => '40000', 'kategori_id' => '1', 'deadline' => '2', 'spesial_treatment' => '0'],
            ['nama' => 'Repaint Sepatu', 'harga' => '120000', 'kategori_id' => '1', 'deadline' => '5', 'spesial_treatment' => '1'],
            ['nama' => 'Parfum Besar', 'harga' => '25000', 'kategori_id' => '2', 'deadline' => '0', 'spesial_treatment' => '0'],
            ['nama' => 'Promo Kemerdekaan', 'harga' => '100000', 'kategori_id' => '3', 'deadline' => '3', 'spesial_treatment' => '0'],
        ]);
    }
}
