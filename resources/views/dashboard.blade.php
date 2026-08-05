@extends('layouts.app')

@section('title', 'Dashboard Ringkasan')

@section('content')

@include('layouts.navbar')

<div class="container py-4" style="max-width: 1140px;">

    <!-- HEADER UTAMA -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom border-2 border-secondary">
        <div>
            <h1 class="h4 fw-bold text-dark mb-0">Ringkasan Hari Ini</h1>
            <small class="text-secondary fw-semibold">Overview aktivitas toko dan status inventaris</small>
        </div>
        <span class="badge bg-secondary text-white px-3 py-2 fw-semibold rounded-2 fs-6 shadow-sm">
            {{ $tanggalHariIni->translatedFormat('l, d F Y') }}
        </span>
    </div>

    @can('viewAny', App\Models\User::class)
        <!-- METRIK UTAMA & PEMBAYARAN -->
        <div class="row g-3 mb-4">
            <!-- Total Penjualan -->
            <div class="col-lg-5">
                <div class="card border border-2 border-secondary rounded-3 shadow-sm bg-secondary text-white h-100">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <span class="text-uppercase small fw-bold text-white-50">Total Penjualan Hari Ini</span>
                            <h2 class="display-6 fw-bolder text-white my-2">Rp {{ number_format($ringkasan['total_penjualan'], 0, ',', '.') }}</h2>
                        </div>
                        <div class="pt-3 border-top border-white-50 d-flex justify-content-between align-items-center">
                            <span class="small text-white-50">Jumlah Transaksi</span>
                            <span class="fw-bold fs-6">{{ number_format($ringkasan['total_transaksi']) }} Transaksi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="col-lg-7">
                <div class="card border border-2 border-secondary rounded-3 shadow-sm bg-white h-100">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <span class="text-uppercase small fw-bold text-secondary mb-3 d-block">Rincian Pembayaran</span>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-3 rounded-3 bg-light border border-secondary">
                                    <small class="text-secondary d-block fw-bold mb-1">Pembayaran Tunai</small>
                                    <h4 class="fw-bolder text-dark mb-0">Rp {{ number_format($ringkasan['total_cash'], 0, ',', '.') }}</h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-3 bg-light border border-secondary">
                                    <small class="text-secondary d-block fw-bold mb-1">Non-Tunai / Digital</small>
                                    <h4 class="fw-bolder text-dark mb-0">Rp {{ number_format($ringkasan['total_non_tunai'], 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    <!-- PRODUK TERLARIS & INVENTARIS KRITIS -->
    <div class="row g-4">
        
        <!-- KOLOM KIRI: PRODUK TERLARIS -->
        <div class="col-lg-7">
            <div class="card border border-2 border-secondary rounded-3 shadow-sm bg-white h-100">
                <div class="card-header bg-light border-bottom border-2 border-secondary py-3 px-4 d-flex justify-content-between align-items-center">
                    <h2 class="h6 fw-bold text-dark mb-0">Produk Terlaris Hari Ini</h2>
                    <span class="badge bg-secondary text-white rounded-2 px-3">Teratas</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-uppercase small fw-bold text-secondary border-bottom border-2 border-secondary">
                                <tr>
                                    <th class="ps-4">Nama Produk</th>
                                    <th class="text-center">Sisa Stok</th>
                                    <th class="text-end pe-4">Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkTerlaris as $produk)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $produk->nama }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border border-secondary px-2 py-1">{{ $produk->stok }}</span>
                                        </td>
                                        <td class="text-end pe-4 fw-bolder text-dark fs-6">{{ number_format($produk->total_terjual) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-muted text-center py-5 fst-italic">Belum ada transaksi produk terlaris.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: STATUS INVENTARIS KRITIS -->
        <div class="col-lg-5">
            <div class="d-flex flex-column gap-3">
                
                <!-- STOK RENDAH -->
                <div class="card border border-2 border-secondary rounded-3 shadow-sm bg-white">
                    <div class="card-header bg-secondary text-white border-bottom border-2 border-secondary py-3 px-3 d-flex justify-content-between align-items-center">
                        <span class="fw-bold small text-uppercase">Daftar Stok Rendah</span>
                        <span class="badge bg-light text-dark rounded-2">Perhatian</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 200px;">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <tbody>
                                    @forelse ($produkStokRendah as $produk)
                                        <tr>
                                            <td class="ps-3 fw-semibold text-dark">{{ $produk->nama }}</td>
                                            <td class="text-end pe-3">
                                                <span class="badge bg-light text-dark border border-secondary font-monospace">{{ $produk->stok }} tersisa</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-muted text-center py-3 small fst-italic">Semua stok produk aman.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- STOK HABIS -->
                <div class="card border border-2 border-secondary rounded-3 shadow-sm bg-white">
                    <div class="card-header bg-light text-dark border-bottom border-2 border-secondary py-3 px-3 d-flex justify-content-between align-items-center">
                        <span class="fw-bold small text-uppercase">Produk Habis Stok</span>
                        <span class="badge bg-secondary text-white rounded-2">Kosong</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 200px;">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <tbody>
                                    @forelse ($produkStokHabis as $produk)
                                        <tr>
                                            <td class="ps-3 fw-semibold text-dark">{{ $produk->nama }}</td>
                                            <td class="text-end pe-3">
                                                <span class="badge bg-secondary text-white font-monospace">0</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-muted text-center py-3 small fst-italic">Tidak ada produk yang habis.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

@endsection