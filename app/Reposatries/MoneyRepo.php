<?php

namespace App\Reposatries;


use App\Models\MoneyDaily;

class MoneyRepo
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param $request
     * @param $MoneyDaily
     */
    public function save_date($request,$MoneyDaily){
        if(is_null($MoneyDaily)){
            $MoneyDaily=new MoneyDaily();
        }
        $MoneyDaily->modelType = $request->modelType;
        $MoneyDaily->amount = $request->amount;
        $MoneyDaily->note = $request->note;
        if($request->model_id)
            $MoneyDaily->model_id = $request->model_id;
        $MoneyDaily->paymentType_id = $request->paymentType_id;
        $MoneyDaily->amount = $request->amount;
        $MoneyDaily->desc = $request->desc;
        $MoneyDaily->save();
    }

    /**
     * @param $request
     * @param $money
     * @return mixed
     */
    public function filterMoney($request,$money){
        if($request->type == 1)
            $money->whereDay('created_at',now());
        if($request->type == 2)
            $money->whereMonth('created_at',now());
        if($request->type == 3)
            $money->whereYear('created_at',now());
        if($request->type == 4)
            $money->whereDate('created_at',$request->from);
        if($request->type == 5)
            $money->whereDate('created_at','>',$request->from)->whereDate('created_at','<',$request->to);
        return $money;
    }
}
