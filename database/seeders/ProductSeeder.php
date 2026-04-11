<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Parfum Mawar',
                'description' => 'Wangi lembut dan segar',
                'stock' => 10,
                'image' => 'parfum.jpg',
                'price' => 50000, // ✅ WAJIB ADA
                'category_id' => 1
            ],
            [
                'name' => 'Parfum Vanilla',
                'description' => 'Aroma manis',
                'stock' => 5,
                'image' => 'parfum.jpg',
                'price' => 60000, // ✅ WAJIB ADA
                'category_id' => 1
            ]
        ]);
    }
}