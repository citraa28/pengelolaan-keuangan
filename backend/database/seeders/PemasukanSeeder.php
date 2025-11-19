<?php

namespace Database\Seeders;

use App\Models\Pemasukan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemasukanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pemasukan::create([
            'user_id' => 1,
            'kategori_id' => 1,
            'jumlah' => 5000000,
            'keterangan' => 'Gaji bulanan',
            'tanggal' => now(),
        ]);

        Pemasukan::create([
            'user_id' => 1,
            'kategori_id' => 2,
            'jumlah' => 1000000,
            'keterangan' => 'Dividen saham',
            'tanggal' => now(),
        ]);
    }
}
