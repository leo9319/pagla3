<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['id', 'method', 'gateway_charge', 'audit_approval', 'management_approval'];
}
