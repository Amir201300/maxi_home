<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table ='stores';

    protected $fillable = [
        'name', 'address', 'status'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class,'product_stores','store_id','product_id');
    }
}
