<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table ='cetegories';

    protected $fillable = [
        'name_ar', 'name_en', 'desc_ar','desc_en','icon'
    ];

}
