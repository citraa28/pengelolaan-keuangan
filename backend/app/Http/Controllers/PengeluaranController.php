<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengeluaran = Pengeluaran::where('user_id', auth()->id())->with('kategori')->get();
        return response()->json($pengeluaran);
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
            ['jenis' => 'pengeluaran']
        );
        $data = $request->only(['jumlah', 'keterangan', 'tanggal']);
        $data['user_id'] = auth()->id();
        $data['kategori_id'] = $kategori->id;

        $pengeluaran = Pengeluaran::create($data);

        // Kembalikan response dengan data pemasukan yang baru dibuat beserta kategori
        return response()->json($pengeluaran->load('kategori'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengeluaran $pengeluaran)
    {
        if ($pengeluaran->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($pengeluaran->load('kategori'));
    }

    /**
     * Update the specified resource in storage..
     */
    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        if ($pengeluaran->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'kategori' => 'required|string',
            'jumlah' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kategori = Kategori::firstOrCreate(
            ['nama_kategori' => $request->kategori, 'user_id' => auth()->id()],
            ['jenis' => 'pengeluaran']
        );

        $pengeluaran->update(array_merge(
            $request->all(),
            ['kategori_id' => $kategori->id]
        ));

        return response()->json($pengeluaran);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengeluaran $pengeluaran)
    {
        if ($pengeluaran->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $pengeluaran->delete();

        return response()->json(null, 204);
    }
}
