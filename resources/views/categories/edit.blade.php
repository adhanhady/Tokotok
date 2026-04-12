@extends('layouts.app')

@section('content')
<h2>Edit Kategori</h2>

    <form action="{{ route('categories.update', $cat->id) }}" method="POST">
        @csrf
    @method('PUT')

    <input type="text" name="nama" value="{{ $cat->nama }}" class="form-control mb-2">

    <button class="btn btn-primary">Update</button>
</form>
@endsection