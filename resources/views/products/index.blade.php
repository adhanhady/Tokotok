<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Daftar Produk</h1>

@foreach($products as $product)
    <p>{{ $product->name }} - Rp {{ $product->price }}</p>
@endforeach
</body>
</html>