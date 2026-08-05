@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')

@include('layouts.navbar')

<div class="container py-4" style="max-width: 1140px;">

    <!-- HEADER UTAMA -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom border-2 border-secondary">
        <div>
            <h1 class="h4 fw-bold text-dark mb-0">Detail Produk</h1>
            <small class="text-secondary fw-semibold">Informasi spesifikasi, harga, dan stok produk</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary fw-bold px-3">
                &larr; Kembali
            </a>
            @can('update', $produk)
                <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-secondary fw-bold px-3">
                    Edit Produk
                </a>
            @endcan
        </div>
    </div>

    <!-- UTAMA (2 KOLOM: FOTO & RINCIAN) -->
    <div class="card border border-2 border-secondary rounded-3 shadow-sm bg-white mb-4">
        <div class="card-body p-4">
            <div class="row g-4 align-items-start">
                
                <!-- FOTO PRODUK -->
                <div class="col-md-5 text-center">
                    <div class="p-3 border border-2 border-secondary rounded-3 bg-light">
                        @if($produk->foto)
                            <img src="{{ asset('storage/' . str_replace('storage/', '', $produk->foto)) }}" 
                                 class="img-fluid rounded border border-secondary" 
                                 alt="{{ $produk->nama }}"
                                 style="max-height: 320px; object-fit: cover; width: 100%;"
                                 onerror="this.onerror=null;this.src='https://via.placeholder.com/320?text=No+Image';">
                        @else
                            <div class="text-center py-5">
                                <div class="fw-bold text-secondary mb-1">[ TANPA FOTO ]</div>
                                <p class="mb-0 text-muted small">Foto produk belum diunggah</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- RINCIAN INFORMASI PRODUK -->
                <div class="col-md-7">
                    <h2 class="h4 fw-bold text-dark mb-3">{{ $produk->nama }}</h2>

                    <table class="table table-borderless align-middle mb-4">
                        <tbody>
                            <tr>
                                <th class="ps-0 text-secondary fw-semibold" style="width: 35%;">Jenis Produk</th>
                                <td>
                                    : <span class="badge bg-light text-dark border border-secondary px-2 py-1 fw-bold">
                                        {{ $produk->jenis->nama_jenis ?? $produk->jenis->nama ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-0 text-secondary fw-semibold">Harga Beli</th>
                                <td class="text-dark fw-medium">: Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0 text-secondary fw-semibold">Harga Jual</th>
                                <td class="fw-bold text-dark fs-6">: Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0 text-secondary fw-semibold">Stok Saat Ini</th>
                                <td>
                                    : <span class="badge bg-light text-dark border border-secondary px-2 py-1 font-monospace fw-bold">
                                        {{ $produk->stok }} unit
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-0 text-secondary fw-semibold">Ditambahkan Oleh</th>
                                <td class="text-dark">: {{ $produk->user->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0 text-secondary fw-semibold">Tanggal Dibuat</th>
                                <td class="text-dark">: {{ $produk->created_at ? $produk->created_at->translatedFormat('d F Y H:i') : '-' }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0 text-secondary fw-semibold">Terakhir Diupdate</th>
                                <td class="text-dark">: {{ $produk->updated_at ? $produk->updated_at->translatedFormat('d F Y H:i') : '-' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- INFORMASI MARGIN & KEUNTUNGAN -->
                    @php
                        $margin = $produk->harga_jual - $produk->harga_beli;
                        $persentase = $produk->harga_beli > 0 ? ($margin / $produk->harga_beli) * 100 : 0;
                    @endphp

                    <div class="card border border-2 border-secondary rounded-3 bg-light">
                        <div class="card-header bg-white border-bottom border-2 border-secondary py-2 px-3">
                            <span class="fw-bold text-dark text-uppercase small">Analisis Keuntungan</span>
                        </div>
                        <div class="card-body p-3">
                            <div class="row text-center">
                                <div class="col-6 border-end border-secondary">
                                    <small class="text-secondary d-block fw-semibold mb-1">Estimasi Margin</small>
                                    <span class="fw-bold text-dark fs-6">
                                        Rp {{ number_format($margin, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="col-6">
                                    <small class="text-secondary d-block fw-semibold mb-1">Persentase Laba</small>
                                    <span class="fw-bold text-dark fs-6">
                                        {{ number_format($persentase, 2) }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

@endsection