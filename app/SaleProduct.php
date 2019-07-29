<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleProduct extends Model
{
    protected $table = 'sales_products';

    public function products() 
    {
    	return $this->hasMany('App\Product', 'id', 'product_id');
    }

    public function product() 
    {
    	return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
