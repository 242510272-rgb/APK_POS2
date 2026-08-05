<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function __construct()
    {
        // Proteksi agar Kasir tidak bisa akses URL /jenis
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->role && strtolower(auth()->user()->role->name) === 'kasir') {
                abort(403, 'Akses ditolak. Kasir tidak diizinkan mengelola jenis produk.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $jenis = Jenis::with('user')->get();
        return view('jenis.index', compact('jenis'));
    }

    public function create()
    {
        return view('jenis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255'
        ]);

        Jenis::create([
            'nama_jenis' => $request->nama_jenis,
            'user_id'    => auth()->id(),
        ]);

        return redirect()->route('jenis.index')->with('success', 'Jenis berhasil ditambahkan');
    }

    public function edit(Jenis $jeni)
    {
        return view('jenis.edit', ['jenis' => $jeni]);
    }

    public function update(Request $request, Jenis $jeni)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255'
        ]);

        $jeni->update([
            'nama_jenis' => $request->nama_jenis,
        ]);

        return redirect()->route('jenis.index')->with('success', 'Jenis berhasil diperbarui');
    }

    public function destroy(Jenis $jeni)
    {
        $jeni->delete();

        return redirect()->route('jenis.index')->with('success', 'Jenis berhasil dihapus');
    }
}