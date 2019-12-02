<?php

namespace App\Http\Controllers;

use App\PaymentReceived;
use App\Party;
use App\HR;
use App\PaymentMethod;
use Illuminate\Http\Request;
use Storage;
use File;
use DB;
use Auth;

class PaymentReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin,management,sub_management,warehouse,audit,sales,hr')->only('index');
        $this->middleware('role:superadmin,sub_management')->only('edit', 'destroy');
    }


    public function index()
    {
        $user = Auth::user();
        $clients = Party::where([
            'audit_approval'=> 1,
            'management_approval'=> 1,
        ])->get();

        $collectors = HR::where([
            'audit_approval'=> 1,
            'management_approval'=> 1,
            'sales_approval'=> 1,
            'role'=>'collection'
        ])->get();

        $all_payment_received = PaymentReceived::all();
        $payment_methods = PaymentMethod::where([
            'management_approval'=> 1,
        ])->get();

        if ($user->user_type == 'sub_management') {

            return view('invoices.payment_received.sub_management.index')
            ->with('all_payment_received', $all_payment_received)
            ->with('clients', $clients)
            ->with('collectors', $collectors)
            ->with('payment_methods', $payment_methods)
            ->with('user', $user);

        } elseif ($user->user_type == 'management') {

            return view('invoices.payment_received.management.index')
            ->with('all_payment_received', $all_payment_received)
            ->with('clients', $clients)
            ->with('collectors', $collectors)
            ->with('payment_methods', $payment_methods)
            ->with('user', $user);
        }

        return view('invoices.payment_received.index')
            ->with('all_payment_received', $all_payment_received)
            ->with('clients', $clients)
            ->with('collectors', $collectors)
            ->with('payment_methods', $payment_methods)
            ->with('user', $user);
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
        if ($request->file('bd_reference_attatchment')) {
            $bd_reference_attatchment = $request->file('bd_reference_attatchment');
            $filename = $bd_reference_attatchment->getClientOriginalName();
            Storage::put('upload/images/' . $filename, file_get_contents($request->file('bd_reference_attatchment')->getRealPath()));
        }
        else {
            $filename = '';
        }

        // get the collector name:
        $collectors_name = DB::table('h_r_s')->where('id', $request->collector)->first()->name ?? 'N/A';

        $payment_received = new PaymentReceived;
        $payment_received->date = $request->date;
        $payment_received->client_code = $request->client_code;
        $payment_received->client_name = $request->client_name;
        $payment_received->collector = $collectors_name;
        $payment_received->paid_amount = $request->paid_amount;
        $payment_received->gc_percentage = $request->gc_percentage;
        $payment_received->gc = $request->gc;
        $payment_received->bd_reference = $request->bd_reference;
        $payment_received->bd_reference_attatchment = $filename;
        $payment_received->money_receipt_ref = $request->money_receipt_ref; 
        $payment_received->total_received = $request->total_received;
        $payment_received->payment_mode = $request->payment_mode;
        $payment_received->cheque_clearing_date = $request->cheque_clearing_date;
        $payment_received->cheque_clearing_status = $request->cheque_clearing_status;
        
        $payment_received->save();

        // PaymentReceived::create($request->all());

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentReceived  $paymentReceived
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentReceived $paymentReceived)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentReceived  $paymentReceived
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentReceived $paymentReceived)
    {
        $clients = Party::all();
        $collectors = HR::where('role', 'Collection')->get();
        $all_payment_received = $paymentReceived;
        $payment_methods = PaymentMethod::all();

        return view('invoices.payment_received.edit')
            ->with('all_payment_received', $all_payment_received)
            ->with('clients', $clients)
            ->with('collectors', $collectors)
            ->with('payment_methods', $payment_methods);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentReceived  $paymentReceived
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentReceived $paymentReceived)
    {
        $paymentReceived->update($request->all());

        if ($request->file('bd_reference_attatchment') != NULL)
        {
            $bd_reference_attatchment = $request->file('bd_reference_attatchment');
            $filename = $bd_reference_attatchment->getClientOriginalName();
            Storage::put('upload/images/' . $filename, file_get_contents($request->file('bd_reference_attatchment')->getRealPath()));

            DB::table('payment_receiveds')->where('id', $paymentReceived->id)->update(['bd_reference_attatchment' => $filename]);
        }

        return redirect()->route('payment_received.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentReceived  $paymentReceived
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentReceived $paymentReceived)
    {
        // Delete the image that is stored 
        $filename = $paymentReceived->bd_reference_attatchment;

        if(Storage::disk('local')->exists('/upload/images/' . $filename)) {
            Storage::disk('local')->delete('/upload/images/' . $filename);
        }

        $paymentReceived->delete();

        return redirect()->route('payment_received.index');
    }

    public function management_approval($id)
    {
        $paymentReceived = PaymentReceived::find($id);
        $paymentReceived->management_approval = 1;
        $paymentReceived->save();

        return redirect()->route('payment_received.index');
    }

    public function management_dissapproval($id)
    {
        $paymentReceived = PaymentReceived::find($id);
        $paymentReceived->management_approval = 0;
        $paymentReceived->save();

        return redirect()->route('payment_received.index');
    }

    public function sales_approval($id)
    {
        $paymentReceived = PaymentReceived::find($id);
        $paymentReceived->sales_approval = 1;
        $paymentReceived->save();

        return redirect()->route('payment_received.index');
    }

    public function sales_dissapproval($id)
    {
        $paymentReceived = PaymentReceived::find($id);
        $paymentReceived->sales_approval = 0;
        $paymentReceived->save();

        return redirect()->route('payment_received.index');
    }

    public function findGatewayCharge(Request $request)
    {
        $data = PaymentMethod::select('gateway_charge', 'id')->where('id', $request->id)->get();

        return response()->json($data);
    }

}
