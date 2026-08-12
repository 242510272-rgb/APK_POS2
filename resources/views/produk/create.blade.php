@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')

@include('layouts.navbar')

<!-- Menggunakan container-fluid agar mengikuti lebar layar penuh -->
<div class="container-fluid px-4 py-4">

    <!-- HEADER UTAMA -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom border-2 border-secondary">
        <div>
            <h1 class="h4 fw-bold text-dark mb-0">Tambah Produk Baru</h1>
            <small class="text-secondary fw-semibold">Masukkan informasi produk dan stok barang ke sistem</small>
        </div>
        <a href="{{ route('produk.index') }}" class="btn btn-outline-dark fw-bold px-3">
            &larr; Kembali
        </a>
    </div>

    <!-- CARD FORM UTAMA -->
    <div class="card border border-2 border-secondary rounded-3 shadow-sm bg-white">
        <div class="card-header bg-light border-bottom border-2 border-secondary py-3 px-4">
            <h2 class="h6 fw-bold text-dark mb-0">Formulir Data Produk</h2>
        </div>

        <div class="card-body p-4">
            {{-- Tag <form> dan @csrf WAJIB ada di sini --}}
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('produk._form')

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-2 border-secondary">
                    <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary fw-bold px-4">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-secondary fw-bold px-4">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
