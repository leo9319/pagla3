<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_type extends Model
{
    protected $fillable = ['type'];

    public function commissions()
    {
        return $this->hasMany('App\Commission', 'party_types_id');
    }
}
