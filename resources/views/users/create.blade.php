@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

@include('layouts.navbar')

<div class="container py-4" style="max-width: 1140px;">

    <!-- CARD FORM -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border border-2 border-secondary rounded-3 shadow-sm bg-white">
                
                <!-- HEADER -->
                <div class="card-header bg-white border-bottom border-2 border-secondary py-3">
                    <h1 class="h5 fw-bold text-dark mb-0">Tambah User Baru</h1>
                    <small class="text-secondary fw-semibold">Buat akun pengguna baru beserta peran (role) aksesnya</small>
                </div>

                <!-- BODY -->
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        
                        <!-- NAMA USER -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold text-dark small text-uppercase">Nama Lengkap</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control border border-secondary rounded-2 @error('name') is-invalid @enderror" 
                                value="{{ old('name') }}" 
                                placeholder="Masukkan nama pengguna" 
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- EMAIL -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold text-dark small text-uppercase">Email Address</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-control border border-secondary rounded-2 @error('email') is-invalid @enderror" 
                                value="{{ old('email') }}" 
                                placeholder="nama@email.com" 
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- ROLE -->
                        <div class="mb-3">
                            <label for="role_id" class="form-label fw-bold text-dark small text-uppercase">Role / Hak Akses</label>
                            <select 
                                name="role_id" 
                                id="role_id" 
                                class="form-select border border-secondary rounded-2 @error('role_id') is-invalid @enderror"
                                required
                            >
                                <option value="" disabled selected>-- Pilih Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- PASSWORD (DENGAN FITUR MATA / TOGGLE VISIBILITY) -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold text-dark small text-uppercase">Password</label>
                            <div class="input-group">
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    class="form-control border border-secondary rounded-start-2 @error('password') is-invalid @enderror" 
                                    placeholder="••••••••" 
                                    required
                                >
                                <button class="btn btn-outline-secondary border border-secondary rounded-end-2" type="button" id="togglePassword">
                                    <!-- Icon Mata Tutup (Default) -->
                                    <svg id="eyeIconClosed" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                                        <path d="M10.79 12.912l-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                                        <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708l-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>
                                    </svg>
                                    <!-- Icon Mata Buka (Hidden Default) -->
                                    <svg id="eyeIconOpen" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill d-none" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback fw-bold d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- BUTTON ACTION -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-dark fw-bold px-3">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-secondary fw-bold px-4">
                                Simpan User
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- SCRIPT TOGGLE VISIBILITY PASSWORD -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const eyeIconClosed = document.getElementById('eyeIconClosed');
        const eyeIconOpen = document.getElementById('eyeIconOpen');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIconClosed.classList.add('d-none');
            eyeIconOpen.classList.remove('d-none');
        } else {
            passwordInput.type = 'password';
            eyeIconClosed.classList.remove('d-none');
            eyeIconOpen.classList.add('d-none');
        }
    });
</script>

@endsection