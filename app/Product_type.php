<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_type extends Model
{
    protected $fillable = ['type'];

    public static function approvedProductTypes()
    {
    	return static::where(['audit_approval' => 1, 'management_approval' => 1])->get();
    }

    public function commissions()
    {
        return $this->hasMany('App\Commission', 'party_types_id');
    }
}
