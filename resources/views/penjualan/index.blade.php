@extends('layouts.app')

@section('title', 'Riwayat Penjualan')

@section('content')

@include('layouts.navbar')

<div class="container py-4" style="max-width: 1140px;">

    <!-- ALERT ERROR -->
    @if(session('errors'))
        <div class="alert alert-dark border border-2 border-secondary rounded-3 mb-4 fw-semibold">
            {{ session('errors') }}
        </div>
    @endif

    <!-- HEADER UTAMA -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom border-2 border-secondary">
        <div>
            <h1 class="h4 fw-bold text-dark mb-0">Riwayat Penjualan</h1>
            <small class="text-secondary fw-semibold">Daftar transaksi penjualan dan status pembayaran</small>
        </div>
        <a href="{{ route('penjualan.create') }}" class="btn btn-secondary fw-bold px-3">
            + Transaksi Baru
        </a>
    </div>

    <!-- CARD UTAMA -->
    <div class="card border border-2 border-secondary rounded-3 shadow-sm bg-white">
        <!-- BAR PENCARIAN -->
        <div class="card-header bg-light border-bottom border-2 border-secondary py-3 px-4">
            <form action="{{ route('penjualan.index') }}" method="GET" class="m-0">
                <div class="input-group" style="max-width: 360px;">
                    <input
                        type="text"
                        name="search"
                        value="{{ request()->search }}"
                        class="form-control border-secondary"
                        placeholder="Cari transaksi..."
                    >
                    <button class="btn btn-secondary fw-bold px-3" type="submit">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- TABEL PENJUALAN -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase small fw-bold text-secondary border-bottom border-2 border-secondary">
                        <tr>
                            <th scope="col" class="ps-4" style="width: 5%;">#</th>
                            <th scope="col">Tanggal Transaksi</th>
                            <th scope="col">Kasir</th>
                            <th scope="col">Total Pembayaran</th>
                            <th scope="col">Metode</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-start ps-3" style="width: 22%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td class="ps-4 text-secondary fw-semibold">
                                    {{ $sales->firstItem() + $loop->index }}
                                </td>
                                <td class="text-secondary small fw-semibold">
                                    {{ $sale->created_at->translatedFormat('d-m-Y H:i:s') }}
                                </td>
                                <td class="fw-bold text-dark">{{ $sale->user->name ?? '-' }}</td>
                                <td class="fw-bold text-dark">Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border border-secondary px-2 py-1 text-uppercase">
                                        {{ $sale->metode_pembayaran }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border border-secondary px-2 py-1 fw-bold">
                                        {{ $sale->status }}
                                    </span>
                                </td>
                                <td class="text-start ps-3">
                                    <div class="d-inline-flex gap-1">
                                        <!-- Detail -->
                                        <a href="{{ route('penjualan.show', $sale) }}" class="btn btn-sm btn-outline-secondary fw-bold">
                                            Detail
                                        </a>

                                        <!-- Edit -->
                                        @can('view', $sale)
                                            <a href="{{ route('penjualan.edit', $sale) }}" class="btn btn-sm btn-outline-dark fw-bold">
                                                Edit
                                            </a>
                                        @endcan

                                        <!-- Hapus -->
                                        @can('delete', $sale)
                                            <form action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-dark fw-bold" onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted text-center py-5 fst-italic">
                                    Data transaksi tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PAGINASI -->
        @if ($sales->hasPages())
            <div class="card-footer bg-white border-top border-2 border-secondary rounded-bottom-3 py-3 px-4">
                {{ $sales->links() }}
            </div>
        @endif
    </div>

</div>

@endsection