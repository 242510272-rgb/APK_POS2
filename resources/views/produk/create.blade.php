@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')

@include('layouts.navbar')

<div class="container my-4">
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Tambah Produk</h3>
            <p class="text-muted mb-0">Isi formulir di bawah untuk menambahkan item produk baru</p>
        </div>
        <a href="{{ route('produk.index') }}" class="btn btn-secondary px-3">
            Kembali
        </a>
    </div>

    <!-- Form Container / Card -->
    <div class="card border-secondary shadow-sm" style="border-radius: 8px;">
        <div class="card-body p-4">
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                @include('produk._form')
            </form>
        </div>
    </div>
</div>

@endsection
