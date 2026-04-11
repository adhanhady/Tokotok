<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Tampilkan semua produk
    public function index()
    {
        $products = Product::with('category')->paginate(6);
        return view('products.index', compact('products'));
    }

    // Form tambah produk
    public function create()
    {
        return view('products.create');
    }

    // Simpan produk
    public function store(Request $request)
    {
        Product::create($request->all());
        return redirect('/products');
    }

    // Detail produk
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    // Form edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // Update produk
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return redirect('/products');
    }

    // Hapus produk
    public function destroy($id)
    {
        Product::destroy($id);
        return redirect('/products');
    }
}