@extends('layouts.app')

@section('content')
<h2 class="mb-4">Keranjang Belanja 🛒</h2>

@if(session('cart') && count(session('cart')) > 0)

<div class="card shadow-sm">
    <div class="card-body">

        <table class="table align-middle">
            <thead class="table-dark">
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
                    $subtotal = $item['harga'] * $item['qty']; 
                    $total += $subtotal; 
                @endphp

                <tr>
                    <td>
                        <strong>{{ $item['nama'] }}</strong>
                    </td>

                    <td>Rp {{ number_format($item['harga']) }}</td>

                    <td>
                    <div class="d-flex align-items-center">

                        <!-- MINUS -->
                        <form action="{{ route('cart.decrease', $id) }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-secondary btn-sm">-</button>
                        </form>

                        <!-- QTY -->
                        <span class="mx-2">{{ $item['qty'] }}</span>

                        <!-- PLUS -->
                        <form action="{{ route('cart.increase', $id) }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-secondary btn-sm">+</button>
                        </form>

                    </div>
                </td>
                    <td>Rp {{ number_format($subtotal) }}</td>

                    <td>
                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm">
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