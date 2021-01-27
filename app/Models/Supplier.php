<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table ='suppliers';

    protected $fillable = [
        'name', 'phone', 'note','email','address'
    ];

    public function type(){
        return $this->belongsTo(StatusTypes::class,'type_id');
    }
}