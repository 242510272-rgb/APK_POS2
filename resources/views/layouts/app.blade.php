<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Isi title yang dikirimkan dari views lain -->
    <title>@yield('title')</title>
    <!-- Memanggil Vite / Bootstrap -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light min-vh-100">

    <!-- Menggunakan container-fluid agar konten melebar penuh dari ujung kiri ke kanan -->
    <div class="container-fluid px-4 py-3">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Isi konten dari views lain -->
        @yield('content')

    </div>

</body>
</html>
