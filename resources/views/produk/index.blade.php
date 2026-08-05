@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')

@include('layouts.navbar')

<div class="container py-4" style="max-width: 1140px;">

    <!-- HEADER UTAMA -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom border-2 border-secondary">
        <div>
            <h1 class="h4 fw-bold text-dark mb-0">Kelola Produk</h1>
            <small class="text-secondary fw-semibold">Daftar item produk, harga, dan ketersediaan stok</small>
        </div>
        @can('create', App\Models\Produk::class)
            <a href="{{ route('produk.create') }}" class="btn btn-secondary fw-bold px-3">
                + Tambah Produk
            </a>
        @endcan
    </div>

    <!-- CARD UTAMA -->
    <div class="card border border-2 border-secondary rounded-3 shadow-sm bg-white">
        <!-- BAR PENCARIAN -->
        <div class="card-header bg-light border-bottom border-2 border-secondary py-3 px-4">
            <form action="{{ route('produk.index') }}" method="GET" class="m-0">
                <div class="input-group" style="max-width: 360px;">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control border-secondary"
                        placeholder="Cari nama produk..."
                    >
                    <button class="btn btn-secondary fw-bold px-3" type="submit">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- TABEL PRODUK -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase small fw-bold text-secondary border-bottom border-2 border-secondary">
                        <tr>
                            <th scope="col" class="ps-4" style="width: 5%;">#</th>
                            <th scope="col" style="width: 8%;">Foto</th>
                            <th scope="col"><Nama Produk/th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Harga Beli</th>
                            <th scope="col">Harga Jual</th>
                            <th scope="col" class="text-center">Stok</th>
                            <th scope="col">User</th>
                            <th scope="col" class="text-end pe-4" style="width: 22%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="ps-4 text-secondary fw-semibold">
                                    {{ $products->firstItem() + $loop->index }}
                                </td>
                                <td>
                                    @if($product->foto)
                                        <img src="{{ asset('storage/'.$product->foto) }}"
                                             alt="{{ $product->nama }}"
                                             width="50"
                                             height="50"
                                             class="rounded-2 border border-secondary object-fit-cover">
                                    @else
                                        <div class="bg-light border border-secondary rounded-2 d-flex align-items-center justify-content-center text-muted small fw-bold" style="width: 50px; height: 50px;">
                                            No Img
                                        </div>
                                    @endif
                                </td>
                                <td class="fw-bold text-dark">{{ $product->nama }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border border-secondary px-2 py-1">
                                        {{ $product->jenis->nama_jenis ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-secondary">Rp {{ number_format($product->harga_beli, 0, ',', '.') }}</td>
                                <td class="fw-bold text-dark">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border border-secondary px-2 py-1 font-monospace fs-6">
                                        {{ $product->stok }}
                                    </span>
                                </td>
                                <td class="small text-secondary">{{ $product->user->name ?? '-' }}</td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-1">
                                        <!-- Tombol Detail -->
                                        <a href="{{ route('produk.show', $product->id) }}" class="btn btn-sm btn-outline-secondary fw-bold">
                                            Detail
                                        </a>

                                        <!-- Tombol Edit -->
                                        @can('update', $product)
                                            <a href="{{ route('produk.edit', $product) }}" class="btn btn-sm btn-outline-dark fw-bold">
                                                Edit
                                            </a>
                                        @endcan

                                        <!-- Tombol Hapus -->
                                        @can('delete', $product)
                                            <form action="{{ route('produk.destroy', $product) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-dark fw-bold" onclick="return confirm('Apakah Anda yakin akan menghapus produk ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-muted text-center py-5 fst-italic">
                                    Tidak ada data produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PAGINASI -->
        @if ($products->hasPages())
            <div class="card-footer bg-white border-top border-2 border-secondary rounded-bottom-3 py-3 px-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>

@endsection