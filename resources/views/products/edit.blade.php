@extends('layouts.app')

@section('content')

<h3>Edit Produk</h3>

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="text" name="nama" value="{{ $product->name }}" class="form-control mb-2">

    <textarea name="deskripsi" class="form-control mb-2">{{ $product->description }}</textarea>

    <input type="number" name="stok" value="{{ $product->stock }}" class="form-control mb-2">

    <input type="number" name="harga" value="{{ $product->price }}" class="form-control mb-2">

    <select name="category_id" class="form-control mb-2">
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" 
                {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                {{ $cat->nama }}
            </option>
        @endforeach
    </select>

    <!-- GAMBAR LAMA -->
    <p>Gambar sekarang:</p>
    <img src="{{ asset('images/' . $product->image) }}" width="100" class="mb-2">

    <!-- UPLOAD BARU -->
    <input type="file" name="gambar" class="form-control mb-2">

    <button class="btn btn-success">Update</button>
</form>

@endsection