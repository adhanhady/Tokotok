<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;

class DashboardController extends Controller
{
    public function index()
    {
    $totalProduk = Product::count();
    $totalKategori = ProductCategory::count();
    $totalKlik = Product::sum('views');

    return view('dashboard', compact(
        'totalProduk',
        'totalKategori',
        'totalKlik'
    ));
    }
}