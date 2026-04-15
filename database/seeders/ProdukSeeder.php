<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::insert([
            ['nama' => 'Deep Clean', 'harga' => '40000', 'kategori_id' => '1', 'deadline' => '2', 'spesial_treatment' => '0'],
            ['nama' => 'Repaint Sepatu', 'harga' => '120000', 'kategori_id' => '1', 'deadline' => '5', 'spesial_treatment' => '1'],
            ['nama' => 'Parfum Besar', 'harga' => '25000', 'kategori_id' => '2', 'deadline' => '0', 'spesial_treatment' => '0'],
            ['nama' => 'Promo Kemerdekaan', 'harga' => '100000', 'kategori_id' => '3', 'deadline' => '3', 'spesial_treatment' => '0'],
        ]);
    }
}
