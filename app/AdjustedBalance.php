<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdjustedBalance extends Model
{
	protected $fillable = ['client_id', 'user_id', 'amount', 'reference', 'reference_attatchment', 'management_approval', 'sales_approval', 'warehouse_approval'];
	
    public static function getClientOverallApprovedAdjustments($client_id)
    {
    	return static::where([
    		'client_id' => $client_id,
    		'management_approval' => 1,
            'sales_approval' => 1,
    		'warehouse_approval' => 1,
    	])->get();
    }

    public static function getClientOverallAdjustments($client_id)
    {
    	return static::where([
    		'client_id' => $client_id
    	])->get();
    }
}
