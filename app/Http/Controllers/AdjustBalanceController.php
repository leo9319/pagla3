<?php

namespace App\Http\Controllers;

use Auth;
use App\Party;
use App\Sale;
use App\Sales_return;
use App\PaymentMethod;
use App\PaymentReceived;
use App\AdjustedBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdjustBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin,management,sub_management,warehouse,audit,sales')->only('index');
        $this->middleware('role:superadmin,management,sub_management')->only('edit', 'destroy');
    }


    public function index()
    {
        $data['clients'] = Party::all();

        return view('adjust_balances.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filename = '';

        if ($request->hasFile('reference_attatchment'))
        {
            $reference_attatchment = $request->file('reference_attatchment');
            $filename = time() . '_' . $reference_attatchment->getClientOriginalName();

            Storage::put('upload/references/' . $filename, file_get_contents($request->file('reference_attatchment')->getRealPath()));
        }

        $adjust_balances = new AdjustedBalance();

        $adjust_balances->client_id = $request->client_id;
        $adjust_balances->user_id = Auth::user()->id;
        $adjust_balances->amount = $request->amount;
        $adjust_balances->reference = $request->reference;
        $adjust_balances->reference_attatchment = $filename;

        $adjust_balances->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['client'] = Party::find($id);

        $data['total_sales'] = $client_sales_date = Sale::where([
            'client_id' => $id,
            'audit_approval' => 1,
            'management_approval' => 1
        ])->get();

        $data['total_sales_return'] = $client_sales_return_data = Sales_return::where([
            'client_id' => $id,
            'audit_approval' => 1,
            'management_approval' => 1,
        ])->get();

        $payment_method = PaymentMethod::where([
            'method' => 'Cheque',
            'management_approval' => 1
        ])->first();

        $cheque_method_id = $payment_method->id;

        $sales_due = $all_previous_sales_amount = $client_sales_date->sum('amount_after_discount');
        $all_previous_sales_return_amount = $client_sales_return_data->sum('amount_after_discount');

        $client_payment_received_data_without_cheque = PaymentReceived::where([
            'client_code' => $id,
            'sales_approval' => 1,
            'management_approval' => 1,
        ])->where('payment_mode', '!=', $cheque_method_id)
          ->get();

        $client_payment_received_data_with_cleared_cheque = PaymentReceived::where([
            'client_code' => $id,
            'sales_approval' => 1,
            'management_approval' => 1,
        ])
        ->where('payment_mode', '=', $cheque_method_id)
        ->where('cheque_clearing_status', '=', 'Cleared')
        ->get();

        $payment_received_not_cheque = $client_payment_received_data_without_cheque->sum('total_received');
        $payment_received_with_cheque = $client_payment_received_data_with_cleared_cheque->sum('total_received');

        $data['payment_received'] = $payment_received = $payment_received_not_cheque + $payment_received_with_cheque;
        $data['true_balance'] = $overall_due = ($all_previous_sales_return_amount + $payment_received) - $sales_due;

        // Get all the adjusted balances
        $data['overall_adjustments'] =  AdjustedBalance::getClientOverallApprovedAdjustments($id)->sum('amount');

        return view('adjust_balances.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $filename = '';
        $current_adjustment = AdjustedBalance::find($request->balance_id);

        if ($request->hasFile('reference_attatchment'))
        {
            if(is_file('upload/references/' . $current_adjustment->reference_attatchment)){
                Storage::delete('upload/references/' . $current_adjustment->reference_attatchment);
            }
            
            $reference_attatchment = $request->file('reference_attatchment');
            $filename = time() . '_' . $reference_attatchment->getClientOriginalName();

            Storage::put('upload/references/' . $filename, file_get_contents($request->file('reference_attatchment')->getRealPath()));

            AdjustedBalance::find($request->balance_id)->update([
                'amount' => $request->amount,
                'reference' => $request->reference,
                'reference_attatchment' => $filename,
            ]);
        } else {
            AdjustedBalance::find($request->balance_id)->update([
                'amount' => $request->amount,
                'reference' => $request->reference
            ]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AdjustedBalance::find($id)->delete();

        return redirect()->back();
    }

    public function history($id)
    {
        $data['adjustment_histories'] = AdjustedBalance::getClientOverallAdjustments($id);

        return view('adjust_balances.history', $data);
    }

    public function download($filename)
    {
        if(Storage::disk('local')->has('upload/references/' . $filename)) {
            return Storage::download('upload/references/' . $filename);

        } else {
            echo 'File not found!';
        }
    }

    public function getClientAdjustments(Request $request)
    {
        $data = AdjustedBalance::find($request->id);

        return response()->json($data);
    }

    public function approval($status, $adjustment_id)
    {
        if(Auth::user()->user_type == 'management') {

            AdjustedBalance::find($adjustment_id)->update([
                'management_approval' => $status
            ]);
        } elseif(Auth::user()->user_type == 'sales') {
            AdjustedBalance::find($adjustment_id)->update([
                'sales_approval' => $status
            ]);
        } elseif(Auth::user()->user_type == 'warehouse') {
            AdjustedBalance::find($adjustment_id)->update([
                'warehouse_approval' => $status
            ]);
        }

        return redirect()->back();
    }
}
