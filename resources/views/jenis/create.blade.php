@extends('layouts.app')

@section('title', 'Tambah Jenis Produk')

@section('content')

@include('layouts.navbar')

<div class="container py-4" style="max-width: 1140px;">
    
    <!-- CARD FORM -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border border-2 border-secondary rounded-3 shadow-sm bg-white">
                
                <!-- HEADER -->
                <div class="card-header bg-white border-bottom border-2 border-secondary py-3">
                    <h1 class="h5 fw-bold text-dark mb-0">Tambah Jenis Produk</h1>
                    <small class="text-secondary fw-semibold">Masukkan nama kategori atau kelompok produk baru</small>
                </div>

                <!-- BODY -->
                <div class="card-body p-4">
                    <form action="{{ route('jenis.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="nama_jenis" class="form-label fw-bold text-dark small text-uppercase">Nama Jenis</label>
                            <input 
                                type="text" 
                                name="nama_jenis" 
                                id="nama_jenis" 
                                class="form-control border border-secondary rounded-2 @error('nama_jenis') is-invalid @enderror" 
                                value="{{ old('nama_jenis') }}" 
                                placeholder="" 
                                required
                            >
                            @error('nama_jenis')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- BUTTON ACTION -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('jenis.index') }}" class="btn btn-outline-dark fw-bold px-3">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-secondary fw-bold px-4">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection