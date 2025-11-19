<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua pemasukan milik user yang terotentikasi
        $pemasukan = Pemasukan::where('user_id', auth()->id())->with('kategori')->get();
        return response()->json($pemasukan);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cari atau buat kategori baru
        $kategori = Kategori::firstOrCreate(
            ['nama_kategori' => $request->kategori, 'user_id' => auth()->id()],
            ['jenis' => 'pemasukan']
        );
        $data = $request->only(['jumlah', 'keterangan', 'tanggal']);
        $data['user_id'] = auth()->id();
        $data['kategori_id'] = $kategori->id;

        $pemasukan = Pemasukan::create($data);

        // Kembalikan response dengan data pemasukan yang baru dibuat beserta kategori
        return response()->json($pemasukan->load('kategori'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemasukan $pemasukan)
    {
        // Pastikan user hanya bisa melihat pemasukan miliknya sendiri
        if ($pemasukan->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($pemasukan->load('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemasukan $pemasukan)
    {
        // Pastikan user hanya bisa mengupdate pemasukan miliknya sendiri
        if ($pemasukan->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'kategori' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cari atau buat kategori baru
        $kategori = Kategori::firstOrCreate(
            ['nama_kategori' => $request->kategori, 'user_id' => auth()->id()],
            ['jenis' => 'pemasukan']
        );

        // Siapkan data untuk update
        $data = $request->only(['jumlah', 'keterangan', 'tanggal']);
        $data['kategori_id'] = $kategori->id;

        $pemasukan->update($data);

        // Kembalikan response dengan data pemasukan yang sudah diupdate beserta kategori
        return response()->json($pemasukan->load('kategori'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemasukan $pemasukan)
    {
        // Pastikan user hanya bisa menghapus pemasukan miliknya sendiri
        if ($pemasukan->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $pemasukan->delete();

        return response()->json(null, 204);
    }
}