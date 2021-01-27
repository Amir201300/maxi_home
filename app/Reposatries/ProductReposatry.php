<?php

namespace App\Reposatries;

use App\Models\Product;
use App\Models\ProductStore;
use Illuminate\Support\Facades\App;

class ProductReposatry
{
    use \App\Traits\ApiResponseTrait;

    /***
     * @param $product_id
     * @param $store_id
     * @param $quantity
     * @return mixed
     */
    public function addStoreToProduct($product_id, $store_id,$quantity)
    {
        $ProductStore = ProductStore::where('product_id', $product_id)->where('store_id', $store_id)->first();
        $quantity=$quantity ? $quantity : 0;
        if (is_null($ProductStore)) {
            $ProductStore = new ProductStore;
            $ProductStore->store_id = $store_id;
            $ProductStore->product_id = $product_id;
            $ProductStore->quantity = $quantity;
            $ProductStore->save();
        }else{
            $ProductStore->quantity += $quantity;
            $ProductStore->save();
        }
        return 1;
    }

    /***
     * @param $product_id
     */
    public function updateQuantity($product_id){
        $newQuantity = ProductStore::where('product_id', $product_id)->sum('quantity');
        $product=Product::find($product_id);
        $product->quantity=$newQuantity;
        $product->save();
    }
}
