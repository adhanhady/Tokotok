@extends('layouts.app')

@section('content')

<h3>Tambah Produk</h3>

<form action="{{ route('products.store') }}" 
      method="POST" 
      enctype="multipart/form-data">

    @csrf

<div class="mb-3">
    <label class="form-label">Nama Produk</label>
    <input type="text" name="nama" class="form-control" placeholder="Contoh: Daster Rempel">
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="deskripsi" class="form-control" placeholder="Masukkan deskripsi produk..."></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Stok</label>
    <input type="number" name="stok" class="form-control" placeholder="Contoh: 100">
</div>

<div class="mb-3">
    <label class="form-label">Harga</label>
    <input type="number" name="harga" class="form-control" placeholder="Contoh: 50000">
</div>

<div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="category_id" class="form-control">
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Upload Gambar</label>
    <input type="file" name="gambar[]" multiple class="form-control">
    <small class="text-muted">Bisa upload lebih dari 1 gambar</small>
</div>
    <button type="submit" class="btn btn-success">
        Simpan
    </button>

</form>

@endsection