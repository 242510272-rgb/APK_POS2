@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')

@include('layouts.navbar')

<div class="container mt-4">
    <h4>Edit Produk</h4>

    <!-- WAJIB: method="POST", enctype="multipart/form-data", @csrf, dan @method('PUT') -->
    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        @include('produk._form')
    </form>
</div>

@endsection