<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users (pastikan tabel users sudah ada)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Relasi ke tabel kategori
            $table->foreignId('kategori_id')->nullable()->constrained('kategori')->onDelete('set null');
            $table->string('keterangan', 255);
            $table->date('tanggal');
            $table->decimal('jumlah', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
