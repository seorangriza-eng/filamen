<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::insert([
            ['nama' => 'Fachreza Bima', 'nomer_wa' => '085632654564', 'rating' => '3', 'cabang_id' => 1],
            ['nama' => 'Gunawan Kuru', 'nomer_wa' => '085632653333', 'rating' => '3', 'cabang_id' => 1],
            ['nama' => 'Zaizai Pahlevi', 'nomer_wa' => '08563261111', 'rating' => '3', 'cabang_id' => 2],
            ['nama' => 'Imam Santoso', 'nomer_wa' => '085632650000', 'rating' => '3', 'cabang_id' => 2],
            ['nama' => 'Rafa Arya', 'nomer_wa' => '08563269999', 'rating' => '3', 'cabang_id' => 2],
        ]);
    }
}
