<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Party extends Model
{
    protected $fillable = ['id', 'party_id', 'party_name', 'party_type_id', 'party_phone', 'email', 'address', 'zone', 'owner_number', 'contact_person', 'credit_limit', 'distributor', 'bin', 'created_at', 'updated_at', 'audit_approval', 'management_approval'];

    public function clients()
    {
        return $this->hasMany('App\Party_type', 'id', 'party_type_id');
    }

    public function client()
    {
    	return $this->hasOne('App\Party_type', 'id', 'party_type_id');
    }

    public function partyType()
    {
        return $this->hasOne('App\Party_type', 'id', 'party_type_id');
    }

    public function zones()
    {
        return $this->hasMany('App\Zone', 'id', 'zone');
    }

    public function modalZone()
    {
    	return $this->hasOne('App\Zone', 'id', 'zone')
            ->where('audit_approval', 1)
            ->where('management_approval', 1);
    }

    public function sales()
    {
    	return $this->hasMany('App\Sale', 'client_id', 'id')
    		->where([
    			'audit_approval' => 1,
    			'management_approval' => 1,
    		]);
    }

    public function salesDisapproved($month, $year)
    {
        return $this->hasMany('App\Sale', 'client_id', 'id')
            ->where([
                'audit_approval' => 0,
                'management_approval' => 0,
            ])
            ->whereMonth('date', $month)
            ->whereYear('date', $year);
    }

    public function sales_return()
    {
        return $this->hasMany('App\Sales_return', 'client_id', 'id')
            ->where([
                'audit_approval' => 1,
                'management_approval' => 1,
            ]);
    }

    public function payments_received()
    {
        return $this->hasMany('App\PaymentReceived', 'client_code', 'id')
            ->where([
                'sales_approval' => 1,
                'management_approval' => 1,
            ]);
    }

    public function adjustmentedBalance()
    {
        return $this->hasMany('App\AdjustedBalance', 'client_id', 'id')
            ->where([
                'management_approval' => 1,
                'sales_approval'      => 1,
                'warehouse_approval'  => 1,
            ]);
    }

    public static function approvedParties()
    {
        return static::where([
                'audit_approval' => 1,
                'management_approval' => 1,
                ])->get();
    }

    public function payments_received_without_cheque()
    {
        $cheque_id = DB::table('payment_methods')->where('method', 'Cheque')->first()->id;

        return $this->hasMany('App\PaymentReceived', 'client_code', 'id')
            ->where([
                'sales_approval' => 1,
                'management_approval' => 1,
            ])
            ->where('payment_mode', '!=', $cheque_id);
    }

    public function payments_received_with_cheque()
    {
        $cheque_id = DB::table('payment_methods')->where('method', 'Cheque')->first()->id;

        return $this->hasMany('App\PaymentReceived', 'client_code', 'id')
            ->where([
                'sales_approval' => 1,
                'management_approval' => 1,
            ])
            ->where('payment_mode', '=', $cheque_id)
            ->where('cheque_clearing_status', '=', 'Cleared');
    }

    public function monthlyBalance($month, $year)
    {
        $sales            = $this->totalSales($month, $year);
        $sales_return     = $this->totalReturns($month, $year);
        $payment_received = $this->totalPaymentReceived($month, $year);

        return $total     = $sales - $sales_return - $payment_received;

    }

    public function totalSales($month, $year)
    {
        $sales =  Sale::where('client_id', $this->id)
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->where('audit_approval', 1)
                    ->where('management_approval', 1)
                    ->sum('amount_after_discount');


        return $sales;
    }

    public function totalReturns($month, $year)
    {
        $sales_return = Sales_return::where('client_id', $this->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('audit_approval', 1)
            ->where('management_approval', 1)
            ->sum('amount_after_discount');

        return $sales_return;
    }

    public function totalPaymentReceived($month, $year)
    {
        $payment_received = PaymentReceived::where('client_code', $this->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('sales_approval', 1)
            ->where('management_approval', 1)
            ->sum('total_received');

        return $payment_received;
    }

    public function getOverallBalance($till_date = '')
    {
        if(empty($till_date)) {
            $till_date = \Carbon\Carbon::now()->format('Y-m-d');
        }

        $total_sales = $this->sales
                        ->where('date', '<=', $till_date)
                        ->sum('amount_after_discount')
                     + $this->sales
                        ->where('date', '<=', $till_date)
                        ->sum('amount_after_vat_and_discount');

        $total_returns = $this->sales_return
                        ->where('date', '<=', $till_date)
                        ->sum('amount_after_discount');

        $total_payment_received_without_cheque = $this->payments_received_without_cheque
                                                    ->where('date', '<=', $till_date)
                                                    ->sum('paid_amount');

        $total_payment_received_with_cheque = $this->payments_received_with_cheque
                                                    ->where('date', '<=', $till_date)
                                                    ->sum('paid_amount');

        $total_adjusted_balance = $this->adjustmentedBalance
                                    ->where('created_at', '<=', $till_date)
                                    ->sum('amount');

        $balance =  $total_returns + 
                    $total_payment_received_without_cheque +
                    $total_payment_received_with_cheque -
                    $total_sales +
                    $total_adjusted_balance;

        return $balance;
        
    }
}
