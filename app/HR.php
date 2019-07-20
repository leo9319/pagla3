<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HR extends Model
{
    protected $fillable = ['id', 'employee_id', 'name', 'role', 'zone', 'phone', 'created_at', 'updated_at', 'audit_approval', 'management_approval'];

    public function zones()
    {
    	return $this->hasMany('App\Zone', 'id', 'zone');
    }
}
