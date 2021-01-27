<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';

    protected $fillable = [
        'name_ar', 'name_en', 'desc_ar', 'desc_en', 'image', 'par_code', 'price', 'cat_id','price_2'
    ];


    public function cat()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }



    public function productQuantity()
    {
        return $this->belongsToMany(Store::class,'product_stores','product_id','store_id')
            ->withPivot('quantity','id');
    }
}
