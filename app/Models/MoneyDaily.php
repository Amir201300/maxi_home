<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyDaily extends Model
{
    protected $table ='money_dailies';

    protected $fillable = [
        'amount', 'desc', 'note','paymentType_id','model_id','modelType'
    ];

    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class,'paymentType_id');
    }

}
