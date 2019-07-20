<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['date', 'product_code', 'product_name', 'brand', 'product_size', 'case_size', 'product_type', 'audit_approval', 'management_approval']; 

    public function sale()
    {
    	return $this->belongsTo('App\Sale', 'invoice_no', 'invoice_no');
    }

    public function product_types()
    {
    	return $this->hasMany('App\Product_type', 'id', 'product_type');
    }
}
