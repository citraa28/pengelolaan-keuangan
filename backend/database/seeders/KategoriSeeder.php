<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::create(['nama_kategori' => 'Gaji']);
        Kategori::create(['nama_kategori' => 'Investasi']);
        Kategori::create(['nama_kategori' => 'Makanan']);
        Kategori::create(['nama_kategori' => 'Transportasi']);
        Kategori::create(['nama_kategori' => 'Hiburan']);
    }
}