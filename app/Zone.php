<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = ['id', 'zone', 'audit_approval', 'management_approval'];

    public function hrs()
    {
    	return $this->hasMany('App\HR', 'zone')
    		->where('audit_approval', 1)
    		->where('management_approval', 1)
    		->where('sales_approval', 1);
    }
}
