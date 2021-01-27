<?php

namespace App\Reposatries;


use App\Models\MoneyDaily;

class InvoiceRepo
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param $request
     * @param $invoice
     */
    public function save_date($request,$invoice){
        $invoice->sales_id  = $request->sales_id ;
        $invoice->user_id   = $request->user_id  ;
        $invoice->note   = $request->note  ;
        $invoice->delivery_date   = $request->delivery_date  ;
        $invoice->deposit   = $request->deposit  ;
        $invoice->invoice_status   = $request->invoice_status  ;
        $invoice->invoice_type   = $request->invoice_type  ;
        $invoice->discount_type   = $request->discount_type  ;
        $invoice->discount   = $request->discount  ;
        $invoice->tax   = $request->tax  ;
        $invoice->cortex_cost   = $request->cortex_cost  ;
        $invoice->delivery_cost   = $request->delivery_cost  ;
        $invoice->save();
         $this->updatePrices($invoice);
         $this->saveInMoney($invoice);
    }

    /**
     * @param $invoice
     */
    public function updatePrices($invoice){
        $product_price=getProductPrice($invoice);
        $discount_price=getDiscountValue(getProductPrice($invoice),$invoice->discount,$invoice->discount_type);
        $tax=getDiscountValue($product_price,10,2);
        $invoice->product_cost=$product_price;
        $invoice->discount_cost=$discount_price;
        $invoice->tax_cost=$tax;
        $invoice->total_price=$product_price + $tax + $invoice->cortex_cost + $invoice->delivery_cost -  $discount_price;
        $invoice->save();
    }

    /**
     * @param $invoice
     */
    public function saveInMoney($invoice){
        $MoneyDaily=MoneyDaily::where('model_id',$invoice->id)->where('modelType',5)->first();
        $note='تم تعديل الفاتورة';
        if(is_null($MoneyDaily)){
            $MoneyDaily=new MoneyDaily();
            $MoneyDaily->model_id=$invoice->id;
            $MoneyDaily->modelType=5;
            $note='تم اضافة الفاتورة';
        }
        $MoneyDaily->amount=$invoice->total_price;
        $MoneyDaily->note=$note;
        $MoneyDaily->save();
    }

}
