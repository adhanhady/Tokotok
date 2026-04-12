@extends('layouts.app')

@section('content')
<h2>Tambah Produk</h2>

<form action="{{ route('products.store') }}" method="POST">
@csrf

<input type="text" name="name" placeholder="Nama" class="form-control mb-2">
<input type="text" name="description" placeholder="Deskripsi" class="form-control mb-2">
<input type="number" name="stock" placeholder="Stok" class="form-control mb-2">
<input type="number" name="price" placeholder="Harga" class="form-control mb-2">
<input type="text" name="image" placeholder="Nama gambar" class="form-control mb-2">
<select name="category_id" class="form-control mb-2">
    <option value="">-- Pilih Kategori --</option>
    @foreach($categories as $cat)
        <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
    @endforeach
</select>
<button class="btn btn-success">Simpan</button>
</form>
@endsection