<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Digunakan untuk raw SQL atau Query Builder

class ChartController extends Controller
{
    // Pastikan user terotentikasi untuk mengakses data ini
    public function __construct()
    {
        // $this->middleware('auth:api'); 
    }

    public function getMonthlySummary(Request $request)
    {
        $year = $request->input('year', date('Y'));
        
        $userId = auth()->id(); 

        try {
            // --- Agregasi Pemasukan ---
            $pemasukanData = Pemasukan::select(
                    DB::raw('MONTH(tanggal) as month'),
                    DB::raw('SUM(jumlah) as total')
                )
                ->whereYear('tanggal', $year)
                ->where('user_id', $userId) // FILTER DENGAN KOLOM YANG DIKONFIRMASI
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // --- Agregasi Pengeluaran ---
            $pengeluaranData = Pengeluaran::select(
                    DB::raw('MONTH(tanggal) as month'),
                    DB::raw('SUM(jumlah) as total')
                )
                ->whereYear('tanggal', $year)
                ->where('user_id', $userId) // FILTER DENGAN KOLOM YANG DIHARAPKAN
                ->groupBy('month')
                ->orderBy('month')
                ->get();

        } catch (QueryException $e) {
            // Tampilkan error yang spesifik di development
            return response()->json(['status' => 'error', 'message' => 'Query Error.'], 500);
        }

        // --- Formatting Data ke Array 12 Bulan ---
        $pemasukanBulanan = array_fill(0, 12, 0);
        foreach ($pemasukanData as $item) {
            $pemasukanBulanan[$item->month - 1] = (float)$item->total; 
        }

        $pengeluaranBulanan = array_fill(0, 12, 0);
        foreach ($pengeluaranData as $item) {
            $pengeluaranBulanan[$item->month - 1] = (float)$item->total;
        }

        // --- Return Data ---
        return response()->json([
            'status' => 'success',
            'data_pemasukan' => $pemasukanBulanan,
            'data_pengeluaran' => $pengeluaranBulanan,
        ]);
    }
}
