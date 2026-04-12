<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyShop</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:#f5f5f5;">

    <!-- Navbar -->
<nav class="navbar navbar-dark bg-dark px-4">

    <a href="/products" class="navbar-brand fw-bold">
        MyShop 🛒
    </a>

    <div>
        <a href="/categories" class="text-white me-3">Kategori</a>
        <a href="/products" class="text-white me-3">Produk</a>
        <a href="/cart" class="text-white me-3">Cart</a>

        <span class="text-white me-3">
            {{ Auth::user()->name ?? 'Guest' }}
        </span>

        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button class="btn btn-link text-white text-decoration-none p-0">
                Logout
            </button>
        </form>
    </div>

</nav>

    <!-- Content -->
    <div class="container mt-4">
        @yield('content')
    </div>

</body>
</html>