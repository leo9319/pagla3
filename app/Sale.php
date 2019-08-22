<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Party;
use App\SaleProduct;

class Sale extends Model
{
    protected $guarded = [];

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

    public function getTotal($vat)
    {
        $total_amount   = 0;
        $sales_products = SaleProduct::where('invoice_no', $this->invoice_no)->get();

        foreach ($sales_products as $sales_product) {

            $total = $sales_product->price_per_unit * $sales_product->quantity;

            if ($vat == 'sales without vat') {
                $total_amount += $total;
            } else if($vat == 'sales with vat') {
                $total_amount += $total + ($total * $this->vat/100);
            } else if($vat == 'vat') {
                $total_amount += $total * $this->vat/100;
            }
            
        }

        return $total_amount;
    }

}
