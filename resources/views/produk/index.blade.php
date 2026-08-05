@extends('layouts.app')

@section('title', 'Produk')

@section('content')

@include('layouts.navbar')

<h1>Halaman Produk</h1>

@can('create', App\Models\Produk::class)
<a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">create</a>
@endcan

<form action="{{ route('produk.index') }}" method="GET" class="mb-3">
    <div class="input-group">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="form-control"
            placeholder="Search nama produk"
        >
        <button class="btn btn-outline-secondary" type="submit">
            Search
        </button>
    </div>
</form>

<table class="table text-center">
<thead>
    <tr>
        <th scope="col" width="5%">#</th>
        <th scope="col" width="10%">User</th>
        <th scope="col" width="10%">Foto</th>
        <th scope="col" width="15%">Nama</th>
        <th scope="col" width="10%">Jenis</th> {{-- Header Kolom Jenis Baru --}}
        <th scope="col" width="10%">Harga Beli</th>
        <th scope="col" width="10%">Harga Jual</th>
        <th scope="col" width="10%">Stok</th>
        <th scope="col" width="20%">Aksi</th>
   </tr>
</thead>
<tbody>
    @forelse ($products as $product)
    <tr>
        <td>{{ $products->firstItem() + $loop->index }}</td>
        <td>{{ $product->user->name }}</td>
        <td>
            <img src="{{ asset('storage/'.$product->foto) }}"
                 width="100"
                 class="img-thumbnail">
        </td>
        <td class="text-start">{{ $product->nama }}</td>
        {{-- Menampilkan Nama Jenis / Kategori Produk --}}
        <td>
            <span class="badge bg-info text-dark">
                {{ $product->jenis->nama_jenis ?? '-' }}
            </span>
        </td>
        <td>{{ number_format($product->harga_beli, 0, ',', '.') }}</td>
        <td>{{ number_format($product->harga_jual, 0, ',', '.') }}</td>
        <td class="align-middle">{{ $product->stok }}</td>
        <td class="d-flex gap-1 justify-content-center">
            <!-- Tombol Detail -->
            <a href="{{ route('produk.show', $product->id) }}" 
               class="btn btn-info btn-sm">
               <i class="fas fa-eye"></i> Detail
            </a>
            
            <!-- Tombol Edit -->
            @can('update', $product)
            <a href="{{ route('produk.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
            @endcan

            <!-- Tombol Hapus -->
            @can('delete', $product)
            <form action="{{ route('produk.destroy', $product) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin akan menghapus produk ini?')">
                    Hapus
                </button>
            </form>
            @endcan
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="9" class="text-center">Tidak ada data</td> {{-- Diubah ke 9 karena tambah 1 kolom --}}
    </tr>
    @endforelse
</tbody>
</table>

{{ $products->links() }}

<style>
    .table th, .table td {
        vertical-align: middle;
    }
</style>

@endsection