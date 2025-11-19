<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';

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
