<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produk\StoreRequest;
use App\Http\Requests\Produk\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Jenis;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $this->authorize('viewAny', Produk::class);

        $keyword = $request->input('search');

        if ($keyword) {
            $products = Produk::with('jenis') // Load relasi jenis
                ->when($keyword, function ($query, $keyword) {
                    $query->where('nama', 'like', '%' . $keyword . '%');
                })
                ->orderBy('nama')
                ->paginate(10)
                ->withQueryString();
        } else {
            $products = Produk::with('jenis')->latest()->paginate(10)->withQueryString(); // Load relasi jenis
        }

        return view('produk.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Produk::class);
        $jenis = Jenis::all(); // Ambil semua data jenis untuk dropdown
        return view('produk.create', compact('jenis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Produk::class);
        $dataReq = $request->validated();

        $data['user_id'] = Auth::id();
        $data['jenis_id'] = $request->input('jenis_id'); // Simpan jenis_id
        $data['nama'] = $dataReq['name'];
        $data['harga_beli'] = $dataReq['purchase_price'];
        $data['harga_jual'] = $dataReq['selling_price'];
        $data['stok'] = $dataReq['stock'] ?? true;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        $this->authorize('view', $produk);

        return view('produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $this->authorize('update', $produk);
        $jenis = Jenis::all(); // Ambil semua data jenis untuk pilihan dropdown edit
        return view('produk.edit', compact('produk', 'jenis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Produk $produk)
    {
        $this->authorize('update', $produk);
        $dataReq = $request->validated();

        $data = [
            'user_id'  => Auth::id(),
            'jenis_id' => $request->input('jenis_id'), // Update jenis_id
            'nama'     => $dataReq['name'],
            'harga_beli' => $dataReq['purchase_price'],
            'harga_jual' => $dataReq['selling_price'],
            'stok'     => $dataReq['stock'],
        ];

        // Jika upload foto baru
        if ($request->hasFile('foto')) {

            // Hapus foto lama (jika ada & memang tersimpan)
            if (
                $produk->foto &&
                Storage::disk('public')->exists($produk->foto)
            ) {
                Storage::disk('public')->delete($produk->foto);
            }

            // Simpan foto baru
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $produk->update($data);

        return redirect()->route('produk.edit', $produk->id)->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $this->authorize('delete', $produk);
        if ($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Product deleted successfully.');
    }
}