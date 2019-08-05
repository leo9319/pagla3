<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['id', 'product_id', 'brand', 'quantity', 'expiry_date', 'dlp', 'wholesale_rate', 'mrp', 'product_name', 'product_type', 'cost', 'offer_rate', 'offer_start', 'offer_end', 'batch_code', 'created_at', 'updated_at', 'audit_approval', 'management_approval'];

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
