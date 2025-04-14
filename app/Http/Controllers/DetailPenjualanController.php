<?php

namespace App\Http\Controllers;

use App\DetailPenjualan;
use App\Penjualan;
use App\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;

class DetailPenjualanController extends Controller
{
    public function index()
    {
        $details = DetailPenjualan::with('produk', 'penjualan.pelanggan')
            ->get()
            ->groupBy('penjualan_id');
        
        return view('detail_penjualans.index', compact('details'));
    }
    public function create()
    {
        $penjualans = Penjualan::with('pelanggan')->get(); // Pastikan relasi pelanggan dimuat
        $produks = Produk::all();
        
        return view('detail_penjualans.create', compact('penjualans', 'produks'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required|array',
            'produk_id.*' => 'integer|exists:produks,produk_id',
            'jumlah_produk' => 'required|array',
            'jumlah_produk.*' => 'integer|min:1|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($request->produk_id as $key => $produk_id) {
                $jumlah = $request->jumlah_produk[$key];
                $produk = Produk::findOrFail($produk_id);
                
                if ($produk->stok < $jumlah) {
                    throw new \Exception("Stok tidak cukup untuk produk: $produk->nama");
                }
                
                DetailPenjualan::create([
                    'penjualan_id' => $request->penjualan_id,
                    'produk_id' => $produk_id,
                    'jumlah_produk' => $jumlah,
                    'subtotal' => $produk->harga * $jumlah,
                ]);
                
                $produk->decrement('stok', $jumlah);
                $total += $produk->harga * $jumlah;
            }
            
            Penjualan::where('penjualan_id', $request->penjualan_id)->increment('total_harga', $total);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('penjualan.index')->with('success', 'Detail penjualan berhasil ditambahkan.');
    }

    public function show($penjualan_id)
    {
        $penjualan = Penjualan::with('pelanggan', 'detailPenjualan.produk')->findOrFail($penjualan_id);
        return view('penjualan.show', compact('penjualan'));
    }

    public function update(Request $request, $penjualan_id)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required|array',
            'produk_id.*' => 'integer|exists:produks,produk_id',
            'jumlah_produk' => 'required|array',
            'jumlah_produk.*' => 'integer|min:1|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $penjualan = Penjualan::findOrFail($penjualan_id);
            $totalBaru = 0;
            
            foreach ($penjualan->detailPenjualan as $detail) {
                $detail->produk->increment('stok', $detail->jumlah_produk);
                $detail->delete();
            }
            
            foreach ($request->produk_id as $key => $produk_id) {
                $jumlah = $request->jumlah_produk[$key];
                $produk = Produk::findOrFail($produk_id);
                
                if ($produk->stok < $jumlah) {
                    throw new \Exception("Stok tidak cukup untuk produk: $produk->nama");
                }
                
                DetailPenjualan::create([
                    'penjualan_id' => $penjualan_id,
                    'produk_id' => $produk_id,
                    'jumlah_produk' => $jumlah,
                    'subtotal' => $produk->harga * $jumlah,
                ]);
                
                $produk->decrement('stok', $jumlah);
                $totalBaru += $produk->harga * $jumlah;
            }
            
            $penjualan->update(['total_harga' => $totalBaru]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('penjualan.index')->with('success', 'Detail penjualan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $detail = DetailPenjualan::findOrFail($id);
            
            $produk = Produk::findOrFail($detail->produk_id);
            $produk->stok += $detail->JumlahProduk;
            $produk->save();

            $detail->delete();

            return redirect()->route('detail_penjualans.index')->with('success', 'Detail penjualan berhasil dihapus.');
        });
    }

    public function getTotalDetailPenjualan()
    {
        try {
            if (!Schema::hasTable('detail_penjualans')) {
                return response()->json(['error' => 'Tabel detail_penjualans tidak ditemukan'], 404);
            }

            $totalDetailPenjualan = DB::table('detail_penjualans')->count();
            return response()->json(['totalDetailPenjualan' => $totalDetailPenjualan], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
