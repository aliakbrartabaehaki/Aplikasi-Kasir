<?php

namespace App\Http\Controllers;

use App\Penjualan;
use App\DetailPenjualan;
use App\Pelanggan;
use App\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Tambahkan ini
use Illuminate\Support\Facades\DB; // Pastikan juga ini ada
use Carbon\Carbon; // Jika menggunakan Carbon


class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with(['pelanggan', 'produk'])->orderBy('tanggal_penjualan', 'desc')->get();
        return view('penjualans.index', compact('penjualans'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('penjualans.create', compact('pelanggans', 'produks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pelanggan_id' => 'nullable|exists:pelanggans,pelanggan_id',
            'produk_id' => 'required|array|min:1',
            'produk_id.*' => 'exists:produks,produk_id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'jumlah_bayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:cash,transfer,credit_card,e_wallet',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $totalBayar = 0;
            $produkTerpilih = [];

            foreach ($request->produk_id as $key => $produk_id) {
                $produk = Produk::findOrFail($produk_id);
                $jumlah = $request->jumlah[$key];

                if ($produk->stok < $jumlah) {
                    return redirect()->back()->with('error', "Stok produk {$produk->nama_produk} tidak mencukupi")->withInput();
                }

                $produk->stok -= $jumlah;
                $produk->save();

                $subtotal = $produk->harga * $jumlah;
                $totalBayar += $subtotal;

                $produkTerpilih[] = [
                    'produk_id' => $produk->produk_id,
                    'nama_produk' => $produk->nama_produk,
                    'jumlah' => $jumlah,
                    'harga' => $produk->harga,
                    'subtotal' => $subtotal,
                ];
            }

            if ($request->jumlah_bayar < $totalBayar) {
                return redirect()->back()->with('error', "Jumlah bayar tidak mencukupi. Total harus Rp " . number_format($totalBayar, 0, ',', '.'))->withInput();
            }

            $penjualan = Penjualan::create([
                'pelanggan_id' => $request->pelanggan_id,
                'produk_id' => json_encode($produkTerpilih),
                'kode_pembayaran' => $this->generateKodePembayaran(),
                'tanggal_penjualan' => Carbon::now(),
                'total_bayar' => $totalBayar,
                'jumlah_bayar' => $request->jumlah_bayar,
                'kembalian' => $request->jumlah_bayar - $totalBayar,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => ($request->jumlah_bayar >= $totalBayar) ? 'paid' : 'pending',
            ]);

            DB::commit();
            return redirect()->route('penjualans.index')->with('success', 'Transaksi berhasil');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
    

    public function edit($id)
    {
        $penjualan = Penjualan::find($id);
        if (!$penjualan) {
            return redirect()->route('penjualans.index')->with('error', 'Transaksi tidak ditemukan');
        }

        $pelanggans = Pelanggan::all();
        $produks = Produk::all();

        return view('penjualans.edit', compact('penjualan', 'pelanggans', 'produks'));
    }

    public function update(Request $request, $id)
{
    $penjualan = Penjualan::find($id);
    if (!$penjualan) {
        return redirect()->route('penjualans.index')->with('error', 'Transaksi tidak ditemukan');
    }

    $validator = Validator::make($request->all(), [
        'pelanggan_id' => 'nullable|exists:pelanggans,pelanggan_id',
        'produk_id' => 'required|array|min:1',
        'produk_id.*' => 'exists:produks,id',
        'jumlah' => 'required|array|min:1',
        'jumlah.*' => 'required|integer|min:1',
        'jumlah_bayar' => 'required|numeric|min:0',
        'metode_pembayaran' => 'required|in:cash,transfer,credit_card,e_wallet',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    DB::beginTransaction();
    try {
        // Kembalikan stok produk lama
        $produkLama = json_decode($penjualan->produk_id, true);
        if ($produkLama) {
            foreach ($produkLama as $item) {
                $produk = Produk::find($item['produk_id']);
                if ($produk) {
                    $produk->stok += $item['jumlah'];
                    $produk->save();
                }
            }
        }

        $totalBayar = 0;
        $produkTerpilih = [];

        foreach ($request->produk_id as $key => $produk_id) {
            $produk = Produk::findOrFail($produk_id);
            $jumlah = $request->jumlah[$key];

            if ($produk->stok < $jumlah) {
                return redirect()->back()->with('error', "Stok produk {$produk->nama_produk} tidak mencukupi")->withInput();
            }

            // Kurangi stok produk
            $produk->stok -= $jumlah;
            $produk->save();

            // Hitung total bayar
            $subtotal = $produk->harga * $jumlah;
            $totalBayar += $subtotal;

            // Simpan produk dalam array
            $produkTerpilih[] = [
                'produk_id' => $produk->produk_id,
                'nama_produk' => $produk->nama_produk,
                'jumlah' => $jumlah,
                'harga' => $produk->harga,
                'subtotal' => $subtotal,
            ];
        }

        if ($request->jumlah_bayar < $totalBayar) {
            return redirect()->back()->with('error', "Jumlah bayar tidak mencukupi. Total harus Rp " . number_format($totalBayar, 0, ',', '.'))->withInput();
        }

        // Update transaksi ke tabel penjualans
        $penjualan->pelanggan_id = $request->pelanggan_id;
        $penjualan->produk_id = json_encode($produkTerpilih); // Simpan sebagai JSON
        $penjualan->tanggal_penjualan = Carbon::now();
        $penjualan->total_bayar = $totalBayar;
        $penjualan->jumlah_bayar = $request->jumlah_bayar;
        $penjualan->kembalian = $request->jumlah_bayar - $totalBayar;
        $penjualan->metode_pembayaran = $request->metode_pembayaran;
        $penjualan->status = ($request->jumlah_bayar >= $totalBayar) ? 'paid' : 'pending';
        $penjualan->save();

        DB::commit();
        return redirect()->route('penjualans.index')->with('success', 'Transaksi berhasil diperbarui');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
    }
}

    public function generateKodePembayaran()
    {
        return 'PAY-' . strtoupper(uniqid());
    }

    public function destroy($id)
{
    $penjualan = Penjualan::find($id);
    if (!$penjualan) {
        return redirect()->route('penjualans.index')->with('error', 'Transaksi tidak ditemukan');
    }

    DB::beginTransaction();
    try {
        // Kembalikan stok produk sebelum menghapus transaksi
        $produkLama = json_decode($penjualan->produk_id, true);
        if ($produkLama) {
            foreach ($produkLama as $item) {
                $produk = Produk::find($item['produk_id']);
                if ($produk) {
                    $produk->stok += $item['jumlah'];
                    $produk->save();
                }
            }
        }

        // Hapus transaksi
        $penjualan->delete();

        DB::commit();
        return redirect()->route('penjualans.index')->with('success', 'Transaksi berhasil dihapus');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

public function show($id)
{
    $penjualan = Penjualan::with('pelanggan')->find($id);
    if (!$penjualan) {
        return redirect()->route('penjualans.index')->with('error', 'Transaksi tidak ditemukan');
    }

    // Decode data produk yang disimpan dalam format JSON
    $produkList = json_decode($penjualan->produk_id, true);

    return view('penjualans.show', compact('penjualan', 'produkList'));
}

public function laporan(Request $request)
{
    date_default_timezone_set('Asia/Jakarta'); // Pastikan zona waktu sesuai

    $periode = $request->get('periode', 'semua'); // Default "semua"

    // Ambil data penjualan sesuai periode
    $query = Penjualan::query();

    // Ambil tanggal hari ini
    $today = Carbon::now()->toDateString(); 

    if ($periode == 'hari') {
        $query->whereDate('tanggal_penjualan', $today);
    } elseif ($periode == 'minggu') {
        $query->whereBetween('tanggal_penjualan', [
            Carbon::now()->startOfWeek()->toDateString(), 
            Carbon::now()->endOfWeek()->toDateString()
        ])->whereDate('tanggal_penjualan', '!=', $today); // Hapus data hari ini
    } elseif ($periode == 'bulan') {
        $query->whereMonth('tanggal_penjualan', Carbon::now()->month)
              ->whereYear('tanggal_penjualan', Carbon::now()->year)
              ->whereDate('tanggal_penjualan', '!=', $today); // Hapus data hari ini
    } elseif ($periode == 'tahun') {
        $query->whereYear('tanggal_penjualan', Carbon::now()->year)
              ->whereDate('tanggal_penjualan', '!=', $today); // Hapus data hari ini
    }

    $penjualans = $query->orderBy('tanggal_penjualan', 'desc')->get();

    // Pastikan tidak menampilkan data kosong
    if ($penjualans->isEmpty()) {
        $penjualans = collect([
            (object) [
                'kode_pembayaran' => '-',
                'tanggal_penjualan' => '-',
                'pelanggan' => (object) ['nama_pelanggan' => '-'],
                'produk_id' => '[]',
                'total_bayar' => 0,
                'metode_pembayaran' => '-',
                'status' => '-',
            ]
        ]);
    }

    // Hitung statistik
    $totalPenjualan = $penjualans->where('kode_pembayaran', '!=', '-')->sum('total_bayar');
    $transaksiSukses = $penjualans->where('status', 'paid')->count();
    $transaksiGagal = $penjualans->where('status', 'unpaid')->count();

    return view('laporans.index', compact('penjualans', 'totalPenjualan', 'transaksiSukses', 'transaksiGagal'));
}

}

