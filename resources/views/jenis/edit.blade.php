@extends('layouts.app')

@section('content')

@include('layouts.navbar')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Jenis Produk</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('jenis.update', $jenis->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="nama_jenis" class="form-label">Nama Jenis</label>
                            <input 
                                type="text" 
                                name="nama_jenis" 
                                id="nama_jenis" 
                                class="form-control @error('nama_jenis') is-invalid @enderror" 
                                value="{{ old('nama_jenis', $jenis->nama_jenis) }}" 
                                required
                            >
                            @error('nama_jenis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning">Update</button>
                        <a href="{{ route('jenis.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection