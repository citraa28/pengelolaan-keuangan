<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::where('user_id', auth()->id())->get();
        return response()->json($kategori);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:255',
            'jenis' => 'required|in:pemasukan,pengeluaran',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kategori = Kategori::create(array_merge($request->all(), ['user_id' => auth()->id()]));

        return response()->json($kategori, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        if ($kategori->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($kategori);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        if ($kategori->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($kategori->pemasukan()->exists() || $kategori->pengeluaran()->exists()) {
            return response()->json(['message' => 'Kategori sedang digunakan dan tidak dapat diubah.'], 422);
        }

        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:255',
            'jenis' => 'required|in:pemasukan,pengeluaran',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kategori->update($request->all());

        return response()->json($kategori);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        if ($kategori->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($kategori->pemasukan()->exists() || $kategori->pengeluaran()->exists()) {
            return response()->json(['message' => 'Kategori sedang digunakan dan tidak dapat dihapus.'], 422);
        }

        $kategori->delete();

        return response()->json(null, 204);
    }
}
