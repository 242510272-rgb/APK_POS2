<nav class="navbar navbar-expand-lg bg-light shadow-sm py-3 mb-4">
  <div class="container" style="max-width: 1140px;">
    <!-- Brand -->
    <a class="navbar-brand fw-bolder text-dark fs-4 me-4" href="#">POS</a>
    
    <!-- Toggler untuk Mobile -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Menu Navigation -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
        <li class="nav-item">
          <a class="nav-link fw-bold px-3 rounded-2 {{ Request::is('dashboard') ? 'active bg-secondary text-white' : 'text-secondary' }}" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold px-3 rounded-2 {{ Request::is('admin/users') ? 'active bg-secondary text-white' : 'text-secondary' }}" href="{{ route('admin.users') }}">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold px-3 rounded-2 {{ Request::is('jenis*') ? 'active bg-secondary text-white' : 'text-secondary' }}" href="{{ route('jenis.index') }}">Jenis</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold px-3 rounded-2 {{ Request::is('produk*') ? 'active bg-secondary text-white' : 'text-secondary' }}" href="{{ route('produk.index') }}">Produk</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold px-3 rounded-2 {{ Request::is('penjualan*') ? 'active bg-secondary text-white' : 'text-secondary' }}" href="{{ route('penjualan.index') }}">Penjualan</a>
        </li>
      </ul>

      <!-- Form Logout -->
      <form action="{{ route('logout') }}" method="POST" class="d-flex mb-0">
        @csrf
        <button type="submit" class="btn btn-outline-dark fw-bold px-3 py-1 rounded-2">Logout</button>
      </form>
    </div>
  </div>
</nav>