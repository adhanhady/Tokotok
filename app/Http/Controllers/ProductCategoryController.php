<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    // 🔥 LIST DATA
    public function index()
    {
        $categories = ProductCategory::withCount('products')->get();
        return view('categories.index', compact('categories'));
    }

    // 🔥 FORM TAMBAH
    public function create()
    {
        return view('categories.create');
    }

    // 🔥 SIMPAN
    public function store(Request $request)
    {
        ProductCategory::create($request->all());
        return redirect('/categories')->with('success', 'Kategori ditambahkan');
    }

    // 🔥 FORM EDIT
    public function edit($id)
    {
        $cat = ProductCategory::findOrFail($id);
        return view('categories.edit', compact('cat'));
    }

    // 🔥 UPDATE
    public function update(Request $request, $id)
    {
        $cat = ProductCategory::findOrFail($id);
        $cat->update($request->all());
        return redirect('/categories')->with('success', 'Kategori diupdate');
    }

    // 🔥 DELETE
    public function destroy($id)
    {
        ProductCategory::destroy($id);
        return redirect('/categories')->with('success', 'Kategori dihapus');
    }
}