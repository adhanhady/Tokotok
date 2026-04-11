@extends('layouts.app')

@section('content')
<h2 class="mb-4">Keranjang Belanja 🛒</h2>

@if(session('cart') && count(session('cart')) > 0)

<div class="card shadow-sm">
    <div class="card-body">

        <table class="table table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th width="150">Qty</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                @php $total = 0; @endphp

                @foreach(session('cart') as $id => $item)

                @php 
                    $price = $item['price'] ?? 0; // 🔥 anti error
                    $qty = $item['qty'] ?? 1;
                    $subtotal = $price * $qty;
                    $total += $subtotal;
                @endphp

                <tr>
                    <!-- PRODUK + GAMBAR -->
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('images/' . ($item['image'] ?? 'default.jpg')) }}" 
                                width="50" height="50"
                                style="object-fit: cover;"
                                class="me-2 rounded">

                            <strong>{{ $item['name'] ?? '-' }}</strong>
                        </div>
                    </td>

                    <!-- HARGA -->
                    <td class="text-center">Rp {{ number_format($price) }}</td>

                    <!-- QTY -->
                    <td class="text-center">
                        <div class="d-flex align-items-center justify-content-center gap-2">

                            <!-- MINUS -->
                            <form action="{{ route('cart.decrease', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary btn-sm" style="width: 35px;">-</button>
                            </form>

                            <span class="mx-2">{{ $qty }}</span>

                            <!-- PLUS -->
                            <form action="{{ route('cart.increase', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary btn-sm" style="width: 35px;">+</button>
                            </form>

                        </div>
                    </td>

                    <!-- TOTAL -->
                   <td class="text-center">Rp {{ number_format($subtotal) }}</td>

                    <!-- AKSI -->
                    <td>
                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>

                @endforeach

            </tbody>
        </table>

        <!-- TOTAL -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h4>Total: Rp {{ number_format($total) }}</h4>

            <a href="#" class="btn btn-success btn-lg">
                Checkout
            </a>
        </div>

    </div>
</div>

@else
<div class="text-center">
    <h5>Keranjang masih kosong 😢</h5>
    <a href="/products" class="btn btn-primary mt-3">
        Belanja Sekarang
    </a>
</div>
@endif

@endsection 