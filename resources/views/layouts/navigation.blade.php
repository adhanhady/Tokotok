<nav class="navbar navbar-dark bg-dark px-4">

    <!-- LOGO -->
    <a href="/products" class="navbar-brand fw-bold">
        MyShop 🛒
    </a>

    <!-- MENU -->
    <div class="d-flex align-items-center">
        <a href="/categories" class="text-white me-3">Kategori</a>
        <a href="/products" class="text-white me-3">Produk</a>
        <a href="/cart" class="text-white me-3">Cart</a>

        <!-- USER -->
        <span class="text-white me-3">
            {{ Auth::user()->name ?? 'Guest' }}
        </span>

        <!-- LOGOUT -->
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-link text-white text-decoration-none p-0">
                Logout
            </button>
        </form>
    </div>

</nav>