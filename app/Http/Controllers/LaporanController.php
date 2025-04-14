<?php

namespace App\Http\Controllers;

use App\Penjualan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        $query = Penjualan::with(['produk', 'pelanggan'])->orderBy('tanggal_penjualan', 'desc');
        
        // Apply date filter only if both dates are provided
        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('tanggal_penjualan', [$tanggalAwal, $tanggalAkhir]);
        }
        
        $penjualans = $query->get();
        $totalPenjualan = $penjualans->sum('total_bayar');

        return view('laporans.index', compact('penjualans', 'totalPenjualan'));
    }
}
