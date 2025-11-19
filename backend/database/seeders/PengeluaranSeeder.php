<?php

namespace Database\Seeders;

use App\Models\Pengeluaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengeluaran::create([
            'user_id' => 1,
            'kategori_id' => 3,
            'jumlah' => 1500000,
            'keterangan' => 'Belanja bulanan',
            'tanggal' => now(),
        ]);

        Pengeluaran::create([
            'user_id' => 1,
            'kategori_id' => 4,
            'jumlah' => 500000,
            'keterangan' => 'Bensin mobil',
            'tanggal' => now(),
        ]);

        Pengeluaran::create([
            'user_id' => 1,
            'kategori_id' => 5,
            'jumlah' => 300000,
            'keterangan' => 'Nonton bioskop',
            'tanggal' => now(),
        ]);
    }
}
