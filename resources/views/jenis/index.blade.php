@extends('layouts.app')

@section('content')

@include('layouts.navbar')

<div class="container mt-4">
    <h2>Halaman Jenis Produk</h2>
    <a href="{{ route('jenis.create') }}" class="btn btn-primary mb-3">Tambah Jenis</a>

    <table class="table border text-center">
        <thead>
            <tr>
                <th scope="col" width="10%">#</th>
                <th scope="col" width="60%">Nama Jenis</th>
                <th scope="col" width="30%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jenis as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama_jenis }}</td>
                <td class="d-flex gap-1 justify-content-center">
                    <a href="{{ route('jenis.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('jenis.destroy', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus jenis ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Tidak ada data jenis produk</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection