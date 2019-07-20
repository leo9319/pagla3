<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_return extends Model
{
    protected $fillable = ['date', 'sales_invoice', 'invoice_no', 'client_id', 'total_sales_return', 'amount_paid', 'remarks', 'audit_approval', 'management_approval'];

    public function products()
    {
    	return $this->hasMany('App\Product', 'id', 'product_code');
    }

    public function clients()
    {
    	return $this->hasMany('App\Party', 'id', 'client_id');
    }

    public function sales_returns_products()
    {
    	return $this->hasMany('App\SalesReturnsProduct', 'invoice_no', 'invoice_no');
    }
}
