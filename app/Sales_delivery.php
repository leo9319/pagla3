<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_delivery extends Model
{
    protected $fillable = ['id', 'shop_id', 'salesman', 'salesman_start', 'salesman_end', 'discontinued'];
}
