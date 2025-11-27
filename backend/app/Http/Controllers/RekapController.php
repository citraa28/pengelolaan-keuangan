<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapController extends Controller
{
    public function __construct()
    {
    }

    public function download(Request $request)
    {
        try {
            if (!app()->getProvider(\Barryvdh\DomPDF\ServiceProvider::class)) {
                app()->register(\Barryvdh\DomPDF\ServiceProvider::class);
            }

            $user = Auth::user();

            // Validate request
            $request->validate([
                'jenis' => 'nullable|string|in:pemasukan,pengeluaran',
                'tanggalAwal' => 'nullable|date',
                'tanggalAkhir' => 'nullable|date|after_or_equal:tanggalAwal',
            ]);

            $jenis = $request->query('jenis');
            $tanggalAwal = $request->query('tanggalAwal');
            $tanggalAkhir = $request->query('tanggalAkhir');

            $pemasukanQuery = Pemasukan::where('user_id', $user->id)->with('kategori');
            $pengeluaranQuery = Pengeluaran::where('user_id', $user->id)->with('kategori');

            if ($tanggalAwal) {
                $pemasukanQuery->where('tanggal', '>=', $tanggalAwal);
                $pengeluaranQuery->where('tanggal', '>=', $tanggalAwal);
            }

            if ($tanggalAkhir) {
                $pemasukanQuery->where('tanggal', '<=', $tanggalAkhir);
                $pengeluaranQuery->where('tanggal', '<=', $tanggalAkhir);
            }

            $data = collect([]);

            if (!$jenis || $jenis === 'pemasukan') {
                $pemasukans = $pemasukanQuery->get()->map(function ($item) {
                    $item->jenis = 'pemasukan';
                    return $item;
                });
                $data = $data->merge($pemasukans);
            }

            if (!$jenis || $jenis === 'pengeluaran') {
                $pengeluarans = $pengeluaranQuery->get()->map(function ($item) {
                    $item->jenis = 'pengeluaran';
                    return $item;
                });
                $data = $data->merge($pengeluarans);
            }

            // Sort data by date
            $data = $data->sortBy('tanggal');

            $pdfData = [
                'data' => $data,
                'tanggalAwal' => $tanggalAwal,
                'tanggalAkhir' => $tanggalAkhir,
                'jenis' => $jenis,
            ];
            
            $pdf = Pdf::loadView('rekap_pdf', $pdfData);

            $fileName = 'rekap_keuangan_' . now()->format('Y-m-d') . '.pdf';
            return $pdf->download($fileName);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('PDF Generation Failed: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json([
                'error' => 'Gagal membuat PDF.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
