@extends('layouts.app')

@section('content')

<h2 class="mb-4">Dashboard</h2>

<div class="row">

    <!-- Produk -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h5>Total Produk</h5>
                <h2 class="fw-bold text-primary">{{ $totalProduk }}</h2>
            </div>
        </div>
    </div>

    <!-- Kategori -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h5>Total Kategori</h5>
                <h2 class="fw-bold text-success">{{ $totalKategori }}</h2>
            </div>
        </div>
    </div>

    <!-- Klik -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h5>Total Klik Produk</h5>
                <h2 class="fw-bold text-danger">{{ $totalKlik }}</h2>
            </div>
        </div>
    </div>

</div>

@endsection