<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Party_type extends Model
{
    protected $fillable = ['type', 'audit_approval', 'management_approval'];

    public function commissions()
    {
        return $this->hasMany('App\Commission', 'party_types_id');
    }
}
