@extends('layouts.app')

@section('title', 'POS - Kasir')

@section('content')

@if(session('errors'))
    <div class="alert alert-dark border border-2 border-secondary mb-4 rounded-3">
        <strong class="d-block mb-1">Terjadi Kesalahan:</strong>
        {{ session('errors') }}
    </div>
@endif

<!-- HEADER UTAMA -->
<div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom border-2 border-secondary">
    <div>
        <h1 class="h4 fw-bold text-dark mb-0">Transaksi Kasir (POS)</h1>
        <small class="text-secondary fw-semibold">Pilih produk dan selesaikan transaksi pembayaran</small>
    </div>
    <div>
        <span class="badge bg-light text-dark border border-secondary px-3 py-2 font-monospace fw-bold">
            STATUS: {{ $sale->status ?? 'PENDING' }}
        </span>
    </div>
</div>

<div class="row g-4">

    {{-- ---------------- DAFAR PRODUK ---------------- --}}
    <div class="col-lg-6">
        <div class="card border border-2 border-secondary rounded-3 shadow-sm h-100 bg-white">
            <div class="card-header bg-white border-bottom border-2 border-secondary py-3">
                <h2 class="h6 fw-bold text-dark mb-2">Katalog Produk</h2>
                <form method="GET" action="{{ route('penjualan.create') }}">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control border-secondary"
                           placeholder="Cari produk berdasarkan nama..."
                           onkeyup="this.form.submit()">
                </form>
            </div>

            <div class="card-body p-3" style="max-height: 65vh; overflow-y: auto;">
                @forelse($products as $product)
                    <form method="POST" action="{{ route('itempenjualan.store') }}" class="row g-2 mb-2 align-items-center pb-2 border-bottom border-light">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="col-7">
                            <div class="p-2 border border-secondary rounded bg-light">
                                <div class="fw-bold text-dark text-truncate">{{ $product->nama }}</div>
                                <small class="text-secondary fw-semibold">
                                    Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                </small>
                            </div>
                        </div>

                        <div class="col-3">
                            <input type="number" 
                                   name="quantity" 
                                   value="1" 
                                   min="1"
                                   class="form-control border-secondary text-center fw-bold"
                                   {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                        </div>

                        <div class="col-2">
                            <button type="submit" 
                                    class="btn btn-dark w-100 fw-bold {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                +
                            </button>
                        </div>
                    </form>
                @empty
                    <div class="text-center py-4 text-secondary">
                        <small class="fw-semibold">Produk tidak ditemukan</small>
                    </div>
                @endforelse
            </div> 
        </div>
    </div>

    {{-- ---------------- KERANJANG BELANJA ---------------- --}}
    <div class="col-lg-6">
        <div class="card border border-2 border-secondary rounded-3 shadow-sm h-100 bg-white d-flex flex-column">
            <div class="card-header bg-white border-bottom border-2 border-secondary py-3">
                <h2 class="h6 fw-bold text-dark mb-0">Rincian Keranjang</h2>
            </div>

            <div class="card-body p-0 flex-grow-1" style="max-height: 45vh; overflow-y: auto;">
                <table class="table table-borderless align-middle mb-0">
                    <thead class="table-light border-bottom border-secondary">
                        <tr class="text-secondary small fw-bold">
                            <th class="ps-3">Produk</th>
                            <th>Harga</th>
                            <th style="width: 20%;">Qty</th>
                            <th>Subtotal</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sale->itemPenjualan as $item)
                            <tr class="border-bottom border-light">
                                <td class="ps-3 fw-semibold text-dark">
                                    {{ $item->produk->nama ?? 'Tidak Ditemukan' }}
                                </td>
                                <td class="text-secondary small">
                                    Rp {{ number_format($item->produk->harga_jual ?? 0, 0, ',', '.') }}
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('itempenjualan.update', $item->id) }}">
                                        @csrf 
                                        @method('PUT')
                                        <input type="number"
                                               name="quantity"
                                               value="{{ $item->kuantitas }}"
                                               min="1"
                                               onchange="this.form.submit()"
                                               class="form-control form-control-sm border-secondary text-center fw-bold"
                                               {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                    </form>
                                </td>
                                <td class="fw-bold text-dark">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                                <td class="text-end pe-3">
                                    @can('delete', $item)
                                        <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-dark btn-sm fw-bold px-2 py-0"
                                                    {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                                &times;
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-secondary">
                                    <small class="fw-semibold">Keranjang masih kosong</small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- RINGKASAN TOTAL & PEMBAYARAN -->
            <div class="card-footer bg-light border-top border-2 border-secondary p-3 mt-auto">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold text-secondary text-uppercase small">Total Pembayaran</span>
                    <span class="fs-4 fw-bold text-dark">
                        Rp {{ number_format($sale->total_pembayaran ?? 0, 0, ',', '.') }}
                    </span>
                </div>

                <!-- FORM CHECKOUT -->
                <form method="POST"
                      action="{{ route('penjualan.update', $sale->id) }}"
                      onsubmit="return confirm('Proses checkout transaksi ini?')" 
                      class="mb-2">
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        <select name="payment_method" class="form-select border-secondary fw-semibold" required {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                            <option value="">-- Pilih Metode Pembayaran --</option>
                            <option value="CASH" {{ $sale->metode_pembayaran == 'CASH' ? 'selected' : '' }}>Tunai (Cash)</option>
                            <option value="QRIS" {{ $sale->metode_pembayaran == 'QRIS' ? 'selected' : '' }}>Nontunai (QRIS)</option>
                        </select>
                    </div>

                    <button class="btn btn-dark w-100 fw-bold py-2 {{ $sale->itemPenjualan->count() == 0 || $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                        Selesaikan Transaksi (Checkout)
                    </button>
                </form>

                <!-- FORM BATALKAN TRANSAKSI -->
                @can('delete', $sale)
                    <form action="{{ route('penjualan.destroy', $sale->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin ingin membatalkan transaksi ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-secondary w-100 fw-bold py-1 btn-sm {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                            Batalkan Transaksi
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>

</div>
@endsection