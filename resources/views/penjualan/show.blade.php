@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')

@include('layouts.navbar')

<div class="container py-4" style="max-width: 1140px;">

    <!-- ALERT MESSAGES -->
    @if(session('error'))
        <div class="alert alert-dark border border-2 border-secondary rounded-3 mb-4 fw-semibold alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-light border border-2 border-secondary rounded-3 mb-4 fw-semibold alert-dismissible fade show text-dark" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- HEADER UTAMA -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom border-2 border-secondary">
        <div>
            <h1 class="h4 fw-bold text-dark mb-0">Detail Transaksi Penjualan</h1>
            <small class="text-secondary fw-semibold">Rincian lengkap informasi dan item transaksi #{{ $sale->id }}</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary fw-bold px-3">
                &larr; Kembali
            </a>
            @if($sale->status !== 'COMPLETED')
                <a href="{{ route('penjualan.edit', $sale) }}" class="btn btn-secondary fw-bold px-3">
                    Edit Transaksi
                </a>
            @endif
        </div>
    </div>

    <!-- INFORMASI UTAMA (2 KOLOM) -->
    <div class="row g-4 mb-4">
        <!-- Rincian Transaksi -->
        <div class="col-md-6">
            <div class="card border border-2 border-secondary rounded-3 shadow-sm h-100 bg-white">
                <div class="card-header bg-light border-bottom border-2 border-secondary py-3 px-4">
                    <h2 class="h6 fw-bold text-dark mb-0 text-uppercase">Informasi Transaksi</h2>
                </div>
                <div class="card-body p-4">
                    <table class="table table-borderless align-middle mb-0">
                        <tr>
                            <th class="ps-0 text-secondary fw-semibold" style="width: 45%;">ID Transaksi</th>
                            <td class="fw-bold text-dark">: #{{ $sale->id }}</td>
                        </tr>
                        <tr>
                            <th class="ps-0 text-secondary fw-semibold">Tanggal Transaksi</th>
                            <td class="text-dark">: {{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th class="ps-0 text-secondary fw-semibold">Status</th>
                            <td>
                                : 
                                <span class="badge bg-light text-dark border border-secondary px-2 py-1 fw-bold">
                                    {{ strtoupper($sale->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="ps-0 text-secondary fw-semibold">Metode Pembayaran</th>
                            <td class="text-dark">: {{ $sale->metode_pembayaran ?? 'CASH' }}</td>
                        </tr>
                        <tr>
                            <th class="ps-0 text-secondary fw-semibold">Total Pembayaran</th>
                            <td class="fw-bold text-dark fs-6">: Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Rincian Kasir -->
        <div class="col-md-6">
            <div class="card border border-2 border-secondary rounded-3 shadow-sm h-100 bg-white">
                <div class="card-header bg-light border-bottom border-2 border-secondary py-3 px-4">
                    <h2 class="h6 fw-bold text-dark mb-0 text-uppercase">Informasi Kasir</h2>
                </div>
                <div class="card-body p-4">
                    <table class="table table-borderless align-middle mb-0">
                        <tr>
                            <th class="ps-0 text-secondary fw-semibold" style="width: 45%;">Nama Kasir</th>
                            <td class="fw-bold text-dark">: {{ $sale->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="ps-0 text-secondary fw-semibold">Email</th>
                            <td class="text-dark">: {{ $sale->user->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="ps-0 text-secondary fw-semibold">Role</th>
                            <td class="text-dark">: {{ $sale->user->role->name ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL ITEM PRODUK -->
    <div class="card border border-2 border-secondary rounded-3 shadow-sm bg-white mb-4">
        <div class="card-header bg-light border-bottom border-2 border-secondary py-3 px-4">
            <h2 class="h6 fw-bold text-dark mb-0 text-uppercase">Daftar Produk yang Dibeli</h2>
        </div>
        <div class="card-body p-0">
            @if($sale->itemPenjualan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase small fw-bold text-secondary border-bottom border-2 border-secondary">
                            <tr>
                                <th scope="col" class="ps-4" style="width: 5%;">#</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col" class="text-end">Harga Satuan</th>
                                <th scope="col" class="text-center">Jumlah</th>
                                <th scope="col" class="text-end pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->itemPenjualan as $item)
                                <tr>
                                    <td class="ps-4 text-secondary fw-semibold">{{ $loop->iteration }}</td>
                                    <td class="fw-bold text-dark">{{ $item->produk->nama ?? 'Produk Tidak Ditemukan' }}</td>
                                    <td class="text-end text-secondary">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border border-secondary px-2 py-1 font-monospace">
                                            {{ $item->kuantitas }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4 fw-bold text-dark">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-top border-2 border-secondary bg-light">
                            <tr>
                                <th colspan="4" class="text-end fw-bold text-dark text-uppercase py-3">Total</th>
                                <th class="text-end pe-4 fw-bold text-dark fs-6 py-3">
                                    @php
                                        $total = $sale->itemPenjualan->sum('subtotal');
                                    @endphp
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="p-4 text-center text-muted fst-italic">
                    Tidak ada item produk dalam transaksi ini.
                </div>
            @endif
        </div>
    </div>

    <!-- TOMBOL AKSI BAWAH -->
    @if($sale->status === 'OPEN')
        <div class="d-flex justify-content-end">
            <form action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-dark fw-bold px-4" onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')">
                    Hapus Penjualan
                </button>
            </form>
        </div>
    @endif

</div>

@endsection