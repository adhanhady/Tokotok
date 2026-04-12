@extends('layouts.app')

@section('content')
<h2>Edit Produk</h2>

<form action="{{ route('products.update', $product->id) }}" method="POST">
@csrf
@method('PUT')

<input type="text" name="name" value="{{ $product->name }}" class="form-control mb-2">
<input type="text" name="description" value="{{ $product->description }}" class="form-control mb-2">
<input type="number" name="stock" value="{{ $product->stock }}" class="form-control mb-2">
<input type="number" name="price" value="{{ $product->price }}" class="form-control mb-2">
<input type="text" name="image" value="{{ $product->image }}" class="form-control mb-2">
<select name="category_id" class="form-control mb-2">
    @foreach($categories as $cat)
        <option value="{{ $cat->id }}" 
            {{ $product->category_id == $cat->id ? 'selected' : '' }}>
            {{ $cat->nama }}
        </option>
    @endforeach
</select>
<button class="btn btn-primary">Update</button>
</form>
@endsection