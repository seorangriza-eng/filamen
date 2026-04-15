<?php

namespace Database\Seeders;

use App\Models\Coa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}