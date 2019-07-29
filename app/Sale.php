<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Party;

class Sale extends Model
{
    protected $fillable = ['date', 'invoice_no', 'client_id', 'total_sales', 'remarks', 'audit_approval', 'management_approval'];

    public function sale_products()
    {
    	return $this->hasMany('App\SaleProduct', 'invoice_no', 'invoice_no');
    }

    public function clients()
    {
    	return $this->hasMany('App\Party', 'id', 'client_id');
    }

    public function client()
    {
    	return $this->hasOne('App\Party', 'id', 'client_id');
    }

}
