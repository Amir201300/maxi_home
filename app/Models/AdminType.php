<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminType extends Model
{
    protected $table ='admin_types';

    protected $fillable = [
        'commission_status', 'name'
    ];
}
