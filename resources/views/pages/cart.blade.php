@extends('layouts.app')

@section('content')

<h2 class="mb-4 fw-bold">Keranjang</h2>

<div class="row">

    <!-- LIST PRODUK -->
    <div class="col-md-8">
        <div id="cart-container">

            @forelse($cart as $id => $item)
            <div class="card mb-3 shadow-sm border-0">
                <div class="card-body d-flex align-items-center">

                    <!-- IMAGE -->
                    <img src="{{ asset('images/' . $item['image']) }}" 
                         width="80" 
                         class="rounded me-3">

                    <!-- INFO -->
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $item['name'] }}</h6>
                        <small class="text-muted">
                            Rp {{ number_format($item['price']) }}
                        </small>
                    </div>

                    <!-- QTY -->
                    <div class="d-flex align-items-center">

                        <button class="btn btn-light btn-sm btn-decrease" data-id="{{ $id }}">-</button>

                        <span class="mx-2 qty" id="qty-{{ $id }}">
                            {{ $item['qty'] }}
                        </span>

                        <button class="btn btn-light btn-sm btn-increase" data-id="{{ $id }}">+</button>

                    </div>

                    <!-- REMOVE -->
                    <button class="btn btn-danger btn-sm btn-remove ms-3" data-id="{{ $id }}">
                        🗑
                    </button>

                </div>
            </div>
            @empty
                <div class="alert alert-info text-center">
                    Keranjang masih kosong 😢
                </div>
            @endforelse

        </div>
    </div>

    <!-- SUMMARY -->
    <div class="col-md-4">

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h5 class="mb-3">Ringkasan</h5>

            @php $total = 0; @endphp

            @foreach($cart as $item)
                @php $total += $item['price'] * $item['qty']; @endphp
            @endforeach

            <div class="d-flex justify-content-between">
                <span>Total</span>
                <strong id="total-price">Rp {{ number_format($total) }}</strong>
            </div>

            <hr>

            @php
                $message = "Halo admin MyShop\n\n";

                foreach($cart as $item) {
                    $harga = number_format($item['price'] * $item['qty'], 0, ',', '.');

                    $message .= "- {$item['name']} ({$item['qty']}x) = Rp {$harga}\n";
                }

                $totalFormatted = number_format($total, 0, ',', '.');

                $message .= "\nTotal: Rp {$totalFormatted}";
            @endphp

            <!-- 🔥 WA CHECKOUT -->
            <a href="https://wa.me/6285647595353?text={{ urlencode($message) }}" 
            target="_blank"
            class="btn btn-success w-100">
                Checkout
            </a>

        </div>
    </div>

</div>

</div>

@endsection


<!-- 🔥 SCRIPT REALTIME -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    function updateCartUI(data, id = null) {
        if (id) {
            let qtyEl = document.getElementById('qty-' + id);
            if (qtyEl) qtyEl.innerText = data.qty;
        }

        document.getElementById('total-price').innerText = 'Rp ' + data.total;

        let badge = document.getElementById('cart-count');
        if (badge) badge.innerText = data.cartCount;

        let cards = document.querySelectorAll('#cart-container .card');

        if (cards.length === 0) {
            document.getElementById('cart-container').innerHTML = `
                <div class="alert alert-info text-center">
                    Keranjang masih kosong 😢
                </div>
            `;
        }
    }

    // ➕ INCREASE
    document.querySelectorAll('.btn-increase').forEach(btn => {
        btn.addEventListener('click', function() {
            let id = this.dataset.id;

            fetch(`/cart/increase/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => updateCartUI(data, id));
        });
    });

    // ➖ DECREASE
    document.querySelectorAll('.btn-decrease').forEach(btn => {
        btn.addEventListener('click', function() {
            let id = this.dataset.id;

            fetch(`/cart/decrease/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => updateCartUI(data, id));
        });
    });

    // 🗑 REMOVE
    document.querySelectorAll('.btn-remove').forEach(btn => {
        btn.addEventListener('click', function() {
            let id = this.dataset.id;

            fetch(`/cart/remove/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                this.closest('.card').remove();
                updateCartUI(data);
            });
        });
    });

});
</script>