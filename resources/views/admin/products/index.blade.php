@extends('layouts.app')

@section('content')
<h2 class="mb-4">List Produk</h2>

<div class="d-flex justify-content-between align-items-center mb-3">

    <!-- LEFT: FILTER -->
    <form method="GET" action="/products" class="d-flex gap-2">
        <!-- KATEGORI -->
        <select name="category" class="form-control">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" 
                    {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->nama }}
                </option>
            @endforeach
        </select>

        <button class="btn btn-dark">Filter</button>

    </form>

    <!-- RIGHT: TAMBAH -->
    <a href="/products/create" class="btn btn-primary">
        + Tambah
    </a>

</div>
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>

    @foreach($products as $p)
        <tr>
            <td>{{ $products->firstItem() + $loop->index }}</td>
            <td>{{ $p->name }}</td>
            <td>{{ $p->description }}</td>
            <td>{{ $p->stock }}</td>
            <td>Rp {{ number_format($p->price) }}</td>
            <td>
                <img src="{{ asset('images/' . $p->image) }}" width="50">
            </td>
            <td>
                <a href="{{ route('products.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('products.destroy', $p->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
<div class="mt-4">
    {{ $products->links() }}
</div>
    </tbody>
</table>

{{ $products->links() }}

@endsection
