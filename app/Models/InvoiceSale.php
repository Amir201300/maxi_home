<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSale extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class,'invoice_detials','invoice_id','product_id')
            ->withPivot('quantity','price','note','color','cloth','id');
    }

    public function sales()
    {
        return $this->belongsTo(Admin::class,'sales_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
