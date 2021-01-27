<?php
/**
 * @param $total_value
 * @param $discount
 * @param $discount_type
 * @return float|int
 */
function getDiscountValue($total_value,$discount,$discount_type)
{
    $discount_amount= $discount;
    if($discount_type==2) {
        $discount_amount = ($total_value * $discount / 100);
    }
    return $discount_amount;
}

/**
 * @param $invoice
 * @return float|int
 */
function getProductPrice($invoice){
    $price = 0;
    foreach($invoice->products as $row){
        $realPrice = $row->pivot->price ? $row->pivot->price : $row->price;
        $price +=$realPrice * $row->pivot->quantity;
    }
    return $price;
}