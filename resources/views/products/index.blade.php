@extends('layouts.app')

@section('content')
<h2 class="mb-4">Daftar Produk</h2>

<div class="row">
@foreach($products as $product)
    <div class="col-md-4 col-sm-6 mb-4">
        <div class="card product-card h-100 shadow-sm border-0">

            <!-- Gambar -->
            <img src="{{ asset('images/' . $product->gambar) }}" 
                 class="card-img-top product-img">

            <div class="card-body d-flex flex-column">
                
                <!-- Nama -->
                <h5 class="card-title fw-semibold">
                    {{ $product->nama }}
                </h5>

                <!-- Deskripsi -->
                <p class="card-text text-muted small mb-2">
                    {{ $product->deskripsi }}
                </p>

                <!-- Harga -->
                <p class="fw-bold text-danger mt-auto fs-5">
                    Rp {{ number_format($product->harga) }}
                </p>

                <!-- Tombol -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-success w-100 mt-2">
                        Tambah ke Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection