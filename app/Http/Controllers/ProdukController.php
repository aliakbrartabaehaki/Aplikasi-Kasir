<?php

namespace App\Http\Controllers;

use App\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        
        if ($query) {
            $produks = Produk::where('nama_produk', 'LIKE', "%{$query}%")->get();
        } else {
            $produks = Produk::all();
        }
        
        return view('produks.index', compact('produks', 'query'));
    }

    public function index2(Request $request)
    {
        $query = $request->input('query');
        
        if ($query) {
            $produks2 = Produk::where('nama_produk', 'LIKE', "%{$query}%")->get();
        } else {
            $produks2 = Produk::all();
        }
        
        return view('produks2.index', compact('produks2', 'query'));
    }

    public function create()
    {
        return view('produks.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'harga' => str_replace('.', '', $request->harga),
        ]);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create($data);

        return redirect()->route('produks.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        return view('produks.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update($data);

        return redirect()->route('produks.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('produks.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $produks = Produk::where('nama_produk', 'LIKE', "%{$query}%")->get();
        
        return view('produks.index', compact('produks', 'query'));
    }
}
