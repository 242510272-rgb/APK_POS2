{{-- resources/views/produk/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')

@include('layouts.navbar')

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h4 class="mb-0 fw-bold text-dark">Detail Produk</h4>
                </div>
                
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <!-- Foto Produk -->
                        <div class="col-md-5 text-center border-end-md">
                            @if($produk->foto)
                                <img src="{{ asset('storage/' . str_replace('storage/', '', $produk->foto)) }}" 
                                     class="img-fluid rounded shadow-sm border p-1" 
                                     alt="{{ $produk->nama }}"
                                     style="max-height: 280px; object-fit: cover;"
                                     onerror="this.onerror=null;this.src='https://via.placeholder.com/280?text=No+Image';">
                            @else
                                <div class="text-center py-5 bg-light rounded border">
                                    <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                    <p class="mb-0 text-muted small">Tidak ada foto produk</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Informasi Produk -->
                        <div class="col-md-7">
                            <table class="table table-borderless table-sm mb-0">
                                <tbody>
                                    <tr>
                                        <th width="40%" class="text-muted fw-semibold">Nama Produk</th>
                                        <td class="fw-bold text-dark fs-5">{{ $produk->nama }}</td>
                                    </tr>
                                    <!-- Jenis Produk -->
                                    <tr>
                                        <th class="text-muted fw-semibold align-middle">Jenis Produk</th>
                                        <td class="align-middle">
                                            <span class="badge bg-info text-dark px-3 py-2 rounded-pill">
                                                {{ $produk->jenis->nama_jenis ?? $produk->jenis->nama ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-semibold">Harga Beli</th>
                                        <td class="text-secondary fw-semibold">Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-semibold">Harga Jual</th>
                                        <td class="text-primary fw-bold">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-semibold align-middle">Stok</th>
                                        <td class="align-middle">
                                            <span class="badge bg-{{ $produk->stok > 0 ? 'success' : 'danger' }} px-2 py-1">
                                                {{ $produk->stok }} unit
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-semibold">Ditambahkan Oleh</th>
                                        <td>{{ $produk->user->name ?? 'Tidak diketahui' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-semibold">Tanggal Dibuat</th>
                                        <td>{{ $produk->created_at ? $produk->created_at->translatedFormat('d F Y H:i') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-semibold">Terakhir Diupdate</th>
                                        <td>{{ $produk->updated_at ? $produk->updated_at->translatedFormat('d F Y H:i') : '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <!-- Informasi Keuntungan -->
                            @php
                                $margin = $produk->harga_jual - $produk->harga_beli;
                                $persentase = $produk->harga_beli > 0 ? ($margin / $produk->harga_beli) * 100 : 0;
                                $isLaba = $margin >= 0;
                            @endphp

                            <div class="alert {{ $isLaba ? 'alert-info' : 'alert-danger' }} mt-4 mb-0 border-0 shadow-sm">
                                <h6 class="alert-heading fw-bold mb-2">Informasi Keuntungan</h6>
                                <hr class="my-2">
                                <div class="row text-center">
                                    <div class="col-6 border-end">
                                        <small class="text-muted d-block mb-1">Margin</small>
                                        <h6 class="mb-0 fw-bold {{ $isLaba ? 'text-success' : 'text-danger' }}">
                                            Rp {{ number_format($margin, 0, ',', '.') }}
                                        </h6>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block mb-1">Persentase</small>
                                        <h6 class="mb-0 fw-bold {{ $isLaba ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($persentase, 2) }}%
                                        </h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light py-3 text-end border-top">
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary me-1">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    @can('update', $produk)
                        <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection