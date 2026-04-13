<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyShop</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
        }

        /* NAVBAR GLASS */
        .navbar-glass {
            position: sticky;
            top: 10px;
            z-index: 999;
            margin: 10px 20px;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }

        .nav-link-custom {
            margin-right: 20px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .nav-link-custom:hover {
            background: rgba(0,0,0,0.05);
        }

        /* SEARCH */
        .search-box input {
            border-radius: 20px;
            padding-left: 15px;
        }

        .search-result a:hover {
            background: #f5f5f5;
        }

        /* DROPDOWN */
        .dropdown-toggle::after {
            display: none !important;
        }

        .dropdown-menu {
            border-radius: 12px;
            padding: 10px;
        }

        .dropdown img {
            cursor: pointer;
        }

        /* BADGE */
        #cart-count {
            font-size: 10px;
        }
        .pagination {
            justify-content: center;
        }

        .page-link {
            border-radius: 8px;
        }

    </style>

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-glass px-4">

    <!-- LOGO -->
    <a href="/products" class="navbar-brand fw-bold text-dark">
        MyShop
    </a>

    <!-- MENU (KIRI) -->
    <div class="ms-4 d-flex align-items-center gap-3">

        @auth
            @if(Auth::user()->role == 'admin')
                <!-- 👑 ADMIN MENU -->
                <a href="/dashboard" class="nav-link-custom">Dashboard</a>
                <a href="/products" class="nav-link-custom">Produk</a>
                <a href="/categories" class="nav-link-custom">Kategori</a>
            @else
                <!-- 👤 USER MENU -->
                <a href="/products" class="nav-link-custom">Produk</a>
            @endif
        @else
            <a href="/products" class="nav-link-custom">Produk</a>
        @endauth

    </div>

<!-- SEARCH (TENGAH) -->
<div class="mx-auto position-relative" style="width:300px;">

    @auth
        @if(Auth::user()->role == 'admin')

            <!-- 🔍 ADMIN SEARCH (SUBMIT FORM) -->
            <form action="/products" method="GET">
                <input type="text" 
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Cari produk admin...">
            </form>

        @else

            <!-- 🔍 USER SEARCH (LIVE SEARCH) -->
            <input type="text" 
                   id="search-input"
                   class="form-control"
                   placeholder="Cari produk...">

            <div id="search-result" 
                 class="search-result bg-white shadow rounded position-absolute w-100 mt-2"
                 style="z-index:999; display:none;">
            </div>

        @endif

    @else

        <!-- 🔍 BELUM LOGIN → USER MODE -->
        <input type="text" 
               id="search-input"
               class="form-control"
               placeholder="Cari produk...">

        <div id="search-result" 
             class="search-result bg-white shadow rounded position-absolute w-100 mt-2"
             style="z-index:999; display:none;">
        </div>

    @endauth

</div>
    <!-- RIGHT -->
    <div class="d-flex align-items-center gap-3">

        @auth

            @if(Auth::user()->role != 'admin')
                <!-- 🛒 CART (HANYA USER) -->
                <a href="/cart" class="position-relative text-dark text-decoration-none">
                    🛒
                    <span id="cart-count" 
                          class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ count(session('cart', [])) }}
                    </span>
                </a>
            @endif

            <!-- PROFILE -->
            <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" 
                         class="rounded-circle" width="35">
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li class="dropdown-item-text text-muted small">
                        {{ Auth::user()->name }}
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        @else
            <!-- BELUM LOGIN -->
            <a href="{{ route('login') }}" class="btn btn-dark rounded-pill px-3">
                Login
            </a>
        @endauth

    </div>

</nav>

<!-- CONTENT -->
<div class="container mt-4">
    @yield('content')
</div>

<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // =====================
    // 🔍 SEARCH
    // =====================
    const input = document.getElementById('search-input');
    const resultBox = document.getElementById('search-result');

    if (input) {
        input.addEventListener('keyup', function() {

            let keyword = this.value;

            if (keyword.length < 2) {
                resultBox.style.display = 'none';
                return;
            }

            fetch(`/search?search=${keyword}`)
                .then(res => res.json())
                .then(data => {

                    let html = '';

                    data.forEach(item => {
                        html += `
                            <a href="/products/${item.id}" 
                               class="d-block p-2 text-dark text-decoration-none border-bottom">
                                ${item.name}
                            </a>
                        `;
                    });

                    resultBox.innerHTML = html;
                    resultBox.style.display = 'block';
                });

        });
    }

    // =====================
    // 🛒 UPDATE BADGE
    // =====================
    function updateCartBadge(count) {
        let badge = document.querySelector('#cart-count');
        if (badge) badge.textContent = count ?? 0;
    }

    // =====================
    // 🛒 ADD TO CART GLOBAL
    // =====================
    document.querySelectorAll('.btn-add-cart').forEach(btn => {
        btn.addEventListener('click', function(e) {

            e.preventDefault();
            e.stopPropagation();

            let id = this.dataset.id;

            fetch(`/cart/add/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {

                console.log("SUCCESS:", data); // debug

                updateCartBadge(data.cartCount);

                this.innerText = "✔ Ditambahkan";
                this.classList.add('btn-success');

                setTimeout(() => {
                    this.innerText = "+ Keranjang";
                    this.classList.remove('btn-success');
                }, 1000);

            })
            .catch(err => {
                console.error("ERROR:", err);
            });

        });
    });

});
</script>

</body>
</html>