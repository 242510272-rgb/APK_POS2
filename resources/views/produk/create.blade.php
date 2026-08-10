@extends('layouts.app')

@section('title', '')

@section('content')

@include('layouts.navbar')

<div class="container mt-4">
    <h4>Tambah Produk</h4>

    {{-- Tag <form> dan @csrf WAJIB ada di sini --}}
    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @include('produk._form')
    </form>
</div>

@endsection