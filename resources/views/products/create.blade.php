@extends('layouts.app')

@section('content')
<h2>Tambah Produk</h2>

<form action="{{ route('products.store') }}" method="POST">
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

    <input type="text" name="gambar" class="form-control mb-2" placeholder="Nama gambar">

    <button class="btn btn-success">Simpan</button>
</form>
@endsection