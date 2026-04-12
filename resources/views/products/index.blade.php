@extends('layouts.app')

@section('content')
<h2 class="mb-4">List Produk</h2>

<a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
    + Tambah
</a>

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

    </tbody>
</table>

{{ $products->links() }}

@endsection