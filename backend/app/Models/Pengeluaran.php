<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'jumlah',
        'keterangan',
        'tanggal',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
