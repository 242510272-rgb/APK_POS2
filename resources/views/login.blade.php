@extends('layouts.app')

@section('title', 'Login POS')

@section('content')

<div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="card border border-2 border-secondary rounded-3 shadow-sm bg-white p-2" style="width: 100%; max-width: 400px;">
        
        <!-- HEADER -->
        <div class="card-header bg-white border-bottom border-2 border-secondary text-center py-3">
            <h1 class="h4 fw-bold text-dark mb-0">Login POS</h1>
            <small class="text-secondary fw-semibold">Masuk untuk mengelola sistem kasir</small>
        </div>

        <!-- FORM BODY -->
        <div class="card-body p-4">
            <form action="{{ route('auth') }}" method="POST">
                @csrf

                <!-- FIELD EMAIL -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold text-dark small text-uppercase">Email Address</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        class="form-control border border-secondary rounded-2 @error('email') is-invalid @enderror" 
                        placeholder="nama@email.com"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <div class="text-danger small fw-bold mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- FIELD PASSWORD -->
                <div class="mb-4">
                    <label for="password" class="form-label fw-bold text-dark small text-uppercase">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        class="form-control border border-secondary rounded-2 @error('password') is-invalid @enderror" 
                        placeholder="••••••••"
                        required
                    >
                    @error('password')
                        <div class="text-danger small fw-bold mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- BUTTON SUBMIT -->
                <button type="submit" class="btn btn-secondary fw-bold w-100 py-2 rounded-2">
                    Masuk Akun
                </button>
            </form>
        </div>

    </div>
</div>

@endsection