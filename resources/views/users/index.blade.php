@extends('layouts.app')

@section('title', 'Kelola Users')

@section('content')

@include('layouts.navbar')

<div class="container py-4" style="max-width: 1140px;">

    <!-- HEADER UTAMA -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom border-2 border-secondary">
        <div>
            <h1 class="h4 fw-bold text-dark mb-0">Kelola Users</h1>
            <small class="text-secondary fw-semibold">Daftar akun pengguna dan peran (role) dalam sistem</small>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-secondary fw-bold px-3">
            + Tambah User
        </a>
    </div>

    <!-- CARD UTAMA -->
    <div class="card border border-2 border-secondary rounded-3 shadow-sm bg-white">
        <!-- BAR PENCARIAN -->
        <div class="card-header bg-light border-bottom border-2 border-secondary py-3 px-4">
            <form action="{{ route('admin.users') }}" method="GET" class="m-0">
                <div class="input-group" style="max-width: 360px;">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control border-secondary"
                        placeholder="Cari nama atau email..."
                    >
                    <button class="btn btn-secondary fw-bold px-3" type="submit">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- TABEL USERS -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase small fw-bold text-secondary border-bottom border-2 border-secondary">
                        <tr>
                            <th scope="col" class="ps-4" style="width: 5%;">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col" class="text-end pe-4" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4 text-secondary fw-semibold">{{ $users->firstItem() + $loop->index }}</td>
                                <td class="fw-bold text-dark">{{ $user->name }}</td>
                                <td class="text-secondary">{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border border-secondary px-2 py-1 fw-bold">
                                        {{ $user->role->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-dark fw-bold">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-dark fw-bold" onclick="return confirm('Yakin hapus user ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted text-center py-5 fst-italic">
                                    Data user tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PAGINASI -->
        @if ($users->hasPages())
            <div class="card-footer bg-white border-top border-2 border-secondary rounded-bottom-3 py-3 px-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>

@endsection