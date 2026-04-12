@extends('layouts.app')

@section('content')

<h3>Tambah Produk</h3>

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="text" name="nama" class="form-control mb-2" placeholder="Nama produk">

    <textarea name="deskripsi" class="form-control mb-2" placeholder="Deskripsi"></textarea>

    <input type="number" name="stok" class="form-control mb-2" placeholder="Stok">

    <input type="number" name="harga" class="form-control mb-2" placeholder="Harga">

    <select name="category_id" class="form-control mb-2">
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
        @endforeach
    </select>

    <!-- UPLOAD GAMBAR -->
    <input type="file" name="gambar" class="form-control mb-2">
        
    <button class="btn btn-success">Simpan</button>
</form>

@endsection