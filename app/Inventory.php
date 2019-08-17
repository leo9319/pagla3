<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $guarded = [];

    public function product_ids()
    {
    	return $this->hasMany('App\Product', 'id', 'product_id');
    }

    public function product()
    {
    	return $this->hasOne('App\Product', 'id', 'product_id');
    }

    public function product_names()
    {
    	return $this->hasMany('App\Product', 'id', 'product_name');
    }
}
