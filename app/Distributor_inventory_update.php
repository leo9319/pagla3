<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distributor_inventory_update extends Model
{
	protected $table = 'distributor_inventory_updates';
	
    protected $fillable = ['id', 'client_code', 'product_code', 'product_type', 'ppu', 'client_name', 'product_name', 'brand', 'quantity', 'commission_percentage', 'ppu_after_commission', 'total_commission', 'total_before_commission', 'CIVAC', 'remarks', 'audit_approval', 'management_approval'];

    public function products()
    {
    	return $this->hasMany('App\Product', 'id', 'product_code');
    }

    public function clients()
    {
    	return $this->hasMany('App\Party', 'id', 'client_code');
    }
}
