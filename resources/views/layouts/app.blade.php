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
        <span class="navbar-brand mb-0 h1">MyShop 🛒</span>

        <div>
            <a href="/products" class="text-white me-3">Produk</a>
            <a href="/cart" class="text-white me-3">Cart</a>
            <a href="/logout" class="text-white">Logout</a>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-4">
        @yield('content')
    </div>

</body>
</html>