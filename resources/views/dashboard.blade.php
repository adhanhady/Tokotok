@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h3 class="mb-4 fw-bold">Dashboard</h3>

    <div class="row">

        <!-- PRODUK -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="text-muted">Jumlah Produk</h5>
                    <h2 class="fw-bold text-primary">
                        {{ $totalProduk }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- KATEGORI -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="text-muted">Jumlah Kategori</h5>
                    <h2 class="fw-bold text-success">
                        {{ $totalKategori }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- KLIK -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="text-muted">Jumlah Klik Produk</h5>
                    <h2 class="fw-bold text-danger">
                        {{ $totalKlik }}
                    </h2>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection