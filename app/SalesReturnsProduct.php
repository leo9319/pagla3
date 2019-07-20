<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesReturnsProduct extends Model
{
    protected $table = 'sales_returns_products';

    public function products() 
    {
    	return $this->hasMany('App\Product', 'id', 'product_id');
    }
}
