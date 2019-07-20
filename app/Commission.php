<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = ['party_types_id', 'product_types_id', 'commission_percentage'];

    public function party_types()
    {
        return $this->hasMany('App\Party_type', 'id', 'party_types_id');
    }

    public function product_types()
    {
    	return $this->hasMany('App\Product_type', 'id', 'product_types_id');
    }

    public function product()
    {
    	return $this->hasMany('App\Product_type', 'product_types_id');
    }
}
