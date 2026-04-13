@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="row g-4">

        <!-- 🔥 LEFT: IMAGE + SLIDER -->
        <div class="col-md-5">

            <div class="card border-0 shadow-sm p-3 text-center">

                <!-- MAIN IMAGE -->
                    <img id="main-image"
                    src="{{ asset('images/' . ($product->images->first()->image ?? $product->image)) }}"
                    class="img-fluid rounded product-detail-img mb-3">

                    <!-- THUMBNAIL -->
                <div class="d-flex justify-content-center gap-2">

                    @if($product->images->count() > 0)

                        @foreach($product->images as $index => $img)
                            <img src="{{ asset('images/' . $img->image) }}"
                                class="thumb-img {{ $index == 0 ? 'active' : '' }}"
                                onclick="changeImage(this)">
                        @endforeach

                    @else

                        <!-- 🔥 fallback kalau tidak ada multiple image -->
                        <img src="{{ asset('images/' . $product->image) }}"
                            class="thumb-img active"
                            onclick="changeImage(this)">

                    @endif

                </div>

            </div>

            <h5 class="mt-3 fw-semibold text-center">
                {{ $product->name }}
            </h5>

        </div>

        <!-- 🔥 RIGHT: INFO -->
        <div class="col-md-7">

            <div class="card border-0 shadow-sm p-4">

                <h2 class="fw-bold mb-1">{{ $product->name }}</h2>

                <p class="text-muted mb-3">
                    {{ $product->description ?? 'Deskripsi produk belum tersedia.' }}
                </p>

                <h3 class="text-danger fw-bold mb-3">
                    Rp {{ number_format($product->price) }}
                </h3>

                <!-- BADGE -->
                <div class="mb-3">
                    <span class="badge bg-success me-2 px-3 py-2">
                        Stok: {{ $product->stock }}
                    </span>

                    <span class="badge bg-primary px-3 py-2">
                        {{ $product->category->nama ?? '-' }}
                    </span>
                </div>

                <!-- BUTTON -->
                <div class="d-grid gap-2">

                    <button class="btn btn-dark btn-lg btn-add-cart" 
                            data-id="{{ $product->id }}">
                        + Tambah ke Keranjang
                    </button>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-warning btn-lg fw-semibold">
                            Checkout Sekarang
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


<!-- 🔥 SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    // 🛒 ADD TO CART
    document.querySelectorAll('.btn-add-cart').forEach(btn => {
        btn.addEventListener('click', function() {

            let id = this.dataset.id;

            fetch(`/cart/add/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {

                console.log("DATA:", data); // debug

                let badge = document.querySelector('#cart-count');

                if (badge) {
                    badge.textContent = data.cartCount ?? 0;
                }

                // efek tombol
                this.innerText = "✔ Ditambahkan";
                this.classList.add('btn-success');

                setTimeout(() => {
                    this.innerText = "+ Tambah ke Keranjang";
                    this.classList.remove('btn-success');
                }, 1000);
            });

        });
    });

});

// 🖼 SLIDER
function changeImage(el) {
    document.getElementById('main-image').src = el.src;

    document.querySelectorAll('.thumb-img').forEach(img => {
        img.classList.remove('active');
    });

    el.classList.add('active');
}
</script>


<!-- 🔥 STYLE -->
<style>
.product-detail-img {
    max-height: 450px;
    object-fit: cover;
    transition: 0.3s;
}

.product-detail-img:hover {
    transform: scale(1.03);
}

.thumb-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    cursor: pointer;
    border-radius: 8px;
    opacity: 0.6;
    transition: 0.3s;
}

.thumb-img:hover {
    opacity: 1;
    transform: scale(1.05);
}

.thumb-img.active {
    border: 2px solid #000;
    opacity: 1;
}

.card {
    border-radius: 15px;
}

.btn-lg {
    border-radius: 10px;
}
</style>