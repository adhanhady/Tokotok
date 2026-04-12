@extends('layouts.app')

@section('content')

<h3>Tambah Kategori</h3>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf

    <input type="text" name="nama" class="form-control mb-2" placeholder="Nama kategori">
    
    @error('nama')
    <small class="text-danger">{{ $message }}</small>
    @enderror

    <button class="btn btn-success">Simpan</button>
</form>

@endsection