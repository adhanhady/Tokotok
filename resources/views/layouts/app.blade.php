<!DOCTYPE html>
<html>
<head>
    <title>Ecommerce</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .product-img {
            width: 100%;
            aspect-ratio: 1 / 1; /* kotak marketplace */
            object-fit: cover;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .product-card {
            border-radius: 12px;
            transition: 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.15);
        }
    </style>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
        }
    </style>
    <style>
        .product-card {
            transition: 0.3s;
            border-radius: 12px;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }
</style>
</head>

<body class="d-flex flex-column">

    <!-- Navbar -->
    @include('components.navbar')

    <!-- Content -->
    <div class="container py-5" style="flex: 1;">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <p class="mb-0">© 2026 Ecommerce by Buddy</p>
    </footer>

</body>
</html>