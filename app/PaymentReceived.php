<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentReceived extends Model
{
    protected $fillable = ['id', 'client_code', 'client_name', 'collector', 'paid_amount', 'gc_percentage', 'gc', 'bd_reference', 'bd_reference_attatchment', 'money_receipt_ref', 'total_received', 'payment_mode', 'cheque_clearing_date', 'cheque_clearing_status', 'audit_approval', 'management_approval'];

    public function clients()
    {
    	return $this->hasMany('App\Party', 'id', 'client_code');
    }

    public function payment_methods()
    {
    	return $this->hasMany('App\PaymentMethod', 'id', 'payment_mode');
    }

    public function collectors()
    {
    	return $this->hasMany('App\HR', 'id', 'collector');
    }
}
