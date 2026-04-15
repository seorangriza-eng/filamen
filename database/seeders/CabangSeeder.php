<?php

namespace Database\Seeders;

use App\Models\Cabang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cabang::insert([
            ['nama' => 'injoko', 'alamat' => 'kebonsari nomer 3', 'nomer_wa' => '081365626565'],
            ['nama' => 'marvel', 'alamat' => 'marvel mall, lantai 3 no 121', 'nomer_wa' => '08135546423'],
        ]);
    }
}
