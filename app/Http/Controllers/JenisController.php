<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function index()
    {
        $jenis = Jenis::all();
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

        Jenis::create($request->all());

        return redirect()->route('jenis.index')->with('success', 'Jenis berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jenis $jeni)
    {
        // $jeni disesuaikan dengan parameter route laravel (jenis -> jeni)
        return view('jenis.edit', ['jenis' => $jeni]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jenis $jeni)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255'
        ]);

        $jeni->update($request->all());

        return redirect()->route('jenis.index')->with('success', 'Jenis berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jenis $jeni)
    {
        $jeni->delete();

        return redirect()->route('jenis.index')->with('success', 'Jenis berhasil dihapus');
    }
}