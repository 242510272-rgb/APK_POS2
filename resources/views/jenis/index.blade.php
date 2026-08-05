@extends('layouts.app')

@section('title', 'Jenis Produk')

@section('content')

@include('layouts.navbar')

<div class="container py-4" style="max-width: 1140px;">

    <!-- HEADER UTAMA -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom border-2 border-secondary">
        <div>
            <h1 class="h4 fw-bold text-dark mb-0">Jenis Produk</h1>
            <small class="text-secondary fw-semibold">Kelola kategori atau kelompok jenis produk</small>
        </div>
        <a href="{{ route('jenis.create') }}" class="btn btn-secondary fw-bold px-3">
            + Tambah Jenis
        </a>
    </div>

    <!-- CARD TABEL -->
    <div class="card border border-2 border-secondary rounded-3 shadow-sm bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase small fw-bold text-secondary border-bottom border-2 border-secondary">
                        <tr>
                            <th scope="col" class="ps-4" style="width: 5%;">#</th>
                            <th scope="col">Nama Jenis</th>
                            <th scope="col">Ditambahkan Oleh</th>
                            <th scope="col" class="text-end pe-4" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jenis as $item)
                            <tr>
                                <td class="ps-4 text-secondary fw-semibold">{{ $loop->iteration }}</td>
                                <td class="fw-bold text-dark">{{ $item->nama_jenis }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border border-secondary px-2 py-1 fw-bold">
                                        {{ $item->user->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('jenis.edit', $item->id) }}" class="btn btn-sm btn-outline-dark fw-bold">
                                            Edit
                                        </a>
                                        <form action="{{ route('jenis.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-dark fw-bold" onclick="return confirm('Yakin hapus jenis ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-muted text-center py-5 fst-italic">
                                    Data jenis produk belum ada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection