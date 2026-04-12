<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'categories';

    protected $fillable = ['nama'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}