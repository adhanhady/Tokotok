@extends('layouts.app')

@section('content')

<h2 class="mb-4 fw-bold">Produk</h2>

<div class="row g-4">

@foreach($products as $p)
<div class="col-md-3">

    <a href="{{ route('products.show', $p->id) }}" 
       class="text-decoration-none text-dark">

        <div class="card product-card border-0 shadow-sm h-100">

            <!-- IMAGE -->
            <div class="position-relative overflow-hidden">
                <img src="{{ asset('images/' . $p->image) }}" 
                     class="card-img-top product-img">

                @if($p->stock > 0)
                    <span class="badge bg-success position-absolute top-0 start-0 m-2">
                        Ready
                    </span>
                @else
                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                        Habis
                    </span>
                @endif
            </div>

            <!-- BODY -->
            <div class="card-body d-flex flex-column">

                <h6 class="fw-semibold mb-1">{{ $p->name }}</h6>

                <small class="text-muted mb-2">
                    {{ $p->category->nama ?? 'Umum' }}
                </small>

                <h5 class="text-danger fw-bold mb-3">
                    Rp {{ number_format($p->price) }}
                </h5>

                <!-- BUTTON -->
                <div class="mt-auto">

                    <form action="{{ route('cart.add', $p->id) }}" method="POST"
                          onclick="event.stopPropagation();">
                        @csrf
                        <button class="btn btn-warning w-100 mb-2">
                            Checkout
                        </button>
                    </form>

                    <button class="btn btn-dark w-100 btn-add-cart" 
                            data-id="{{ $p->id }}"
                            onclick="event.stopPropagation();">
                        + Keranjang
                    </button>

                </div>

            </div>

        </div>

    </a>

</div>
@endforeach

</div>

@endsection
<script>
    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

    document.querySelectorAll('.btn-add-cart').forEach(btn => {
        btn.addEventListener('click', function() {

            // 🔥 cek login dulu
            if (!isLoggedIn) {
                window.location.href = "/login";
                return;
            }

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

                let badge = document.getElementById('cart-count');
                if (badge) badge.innerText = data.cartCount;

                this.innerText = "✔ Ditambahkan";
                this.classList.remove('btn-dark');
                this.classList.add('btn-success');

                setTimeout(() => {
                    this.innerText = "+ Keranjang";
                    this.classList.remove('btn-success');
                    this.classList.add('btn-dark');
                }, 1000);

            });

        });
    });

});
</script>