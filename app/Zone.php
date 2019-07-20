<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = ['id', 'zone', 'audit_approval', 'management_approval'];
}
