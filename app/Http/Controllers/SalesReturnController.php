<?php

namespace App\Http\Controllers;

use App\Sales_return;
use App\SalesReturnsProduct;
use App\SaleProduct;
use App\Party;
use App\Product;
use App\Sale;
use App\Inventory;
use App\PaymentReceived;
use App\PaymentMethod;
use DB;
use Illuminate\Http\Request;
use Auth;

class SalesReturnController extends Controller
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
        $sales_returns = Sales_return::all();
        $clients = Party::where([
            'audit_approval'=> 1,
            'management_approval'=> 1,
        ])->get();

        if($user->user_type == 'sub_management') {
            return view('invoices.sales_return.sub_management.index')
            ->with('sales_returns', $sales_returns)
            ->with('clients', $clients)
            ->with('user', $user);

        } elseif ($user->user_type == 'management') {
            return view('invoices.sales_return.management.index')
            ->with('sales_returns', $sales_returns)
            ->with('clients', $clients)
            ->with('user', $user);
        }
        
        return view('invoices.sales_return.index')
            ->with('sales_returns', $sales_returns)
            ->with('clients', $clients)
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
        $sales_returns = new Sales_return;

        // finding the sales id
        $invoice_no = Sale::where('id', $request->sales_invoice)->first()->invoice_no;

        $sales_returns->date = $request->date;
        $sales_returns->sales_invoice = $invoice_no;
        $sales_returns->invoice_no = $request->invoice_no;
        $sales_returns->client_id = $request->client_id;
        $sales_returns->total_sales_return = $request->total_sales_return;
        $sales_returns->discount_percentage = $request->discount_percentage;
        $sales_returns->amount_after_discount = $request->amount_after_discount;
        $sales_returns->present_sr_id = $request->present_sr_id;
        $sales_returns->remarks = $request->remarks;
        $sales_returns->save();

        $invoice_no = $request->invoice_no;
        $counter = count($request->product_code);

        for ($i=0; $i < $counter; $i++) { 
            if ($request->quantity[$i] > 0) {
                DB::table('sales_returns_products')->insert([
                    'invoice_no' => $invoice_no,
                    'product_id' => $request->product_id[$i],
                    'price_per_unit' => $request->price_per_unit[$i],
                    'quantity' => $request->quantity[$i],
                    'commission_percentage' => $request->commission[$i],
                    'remark' => $request->remark[$i]
                ]);
            }
            
        }

        return redirect()->route('sales_return.index');

    }

    public function return_products(Request $request)
    {
        $client_data = Party::select('party_id', 'party_name')->where('id', $request->client_id)->first();
        $client_id = $client_data->id;
        $client_code = $client_data->party_id;
        $client_name = $client_data->party_name;

        $last_invoice = Sales_return::latest('id')->first();

        if($last_invoice != NULL) {
            $return_invoice_id = 'INR' . sprintf('%06d', ($last_invoice->id + 1));
        }
        else {
            $return_invoice_id = 'INR000001';
        }

        $invoice_no = Sale::where('id', $request->sales_invoice)->first()->invoice_no;
        $sales_products = SaleProduct::where('invoice_no', $invoice_no)->get();

        return view('invoices.sales_return.return_products')
            ->with('return_invoice_id', $return_invoice_id)
            ->with('client_id', $client_id)
            ->with('client_code', $client_code)
            ->with('client_name', $client_name)
            ->with('sales_products', $sales_products);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sales_return  $sales_return
     * @return \Illuminate\Http\Response
     */
    public function date($id)
    {   
        return view('invoices.sales_return.date')
            ->with('id', $id);
    }

    public function show(Sales_return $sales_return)
    {
        $data = Sale::where([
            'client_id' => $sales_return->client_id,
            'audit_approval' => 1,
            'management_approval' => 1,
        ])->get();

        $sales_return_data = Sales_return::where([
            'client_id' => $sales_return->client_id,
            'audit_approval' => 1,
            'management_approval' => 1,
        ])->get();

        $due_balance_for_that_client = $data->sum('amount_after_discount');
        $total_due_after_current_sale = $due_balance_for_that_client - $sales_return->amount_after_discount;
        $total_amount_return = $sales_return_data->sum('amount_after_discount');

        $total_amount_return_excluding_current = $sales_return_data->sum('amount_after_discount') - $sales_return->amount_after_discount;

        $balance = $total_amount_return - $due_balance_for_that_client;

        return view('invoices.sales_return.show')
            ->with('sales_return', $sales_return)
            ->with('due_balance_for_that_client', $due_balance_for_that_client)
            ->with('total_due_after_current_sale', $total_due_after_current_sale)
            ->with('total_amount_return', $total_amount_return)
            ->with('total_amount_return_excluding_current', $total_amount_return_excluding_current)
            ->with('balance', $balance);
    }

    public function show_invoice(Request $request, Sales_return $sales_return)
    {
        $sales_return->amount_after_discount;
        $sales_return->date;

        $due_till_date = $request->date;

        // bypassing due by adding one more day to include that days invoices
        $due_till_date = \Carbon\Carbon::parse($due_till_date)->addDays(1);

        $sales_due = 0;
        $overall_due = 0;

        $client_sales_data = Sale::where([
            'client_id' => $sales_return->client_id,
            'audit_approval' => 1,
            'management_approval' => 1
        ])
        ->where('date', '<', $due_till_date)
        ->get();

        $all_previous_sales_amount = $client_sales_data->sum('amount_after_discount');

        /* 
        * If this date is included in the search date then exlude this amount
        * Search date is for all invoices before.
        * Current invoice date is of date.
        */

        $client_sales_return_data = Sales_return::where([
            'client_id' => $sales_return->client_id,
            'audit_approval' => 1,
            'management_approval' => 1,
        ])
        ->where('date', '<', $due_till_date)
        ->get();

        // // These are all the previous sales return 
        $all_previous_sales_return_amount = $client_sales_return_data->sum('amount_after_discount');

        if ($sales_return->date < $due_till_date) {

            /* 
            * This date is included so the total due amount should be with the included amount
            * Total amount is : -
            */

            $excluding_this_amount = $all_previous_sales_return_amount - $sales_return->amount_after_discount;
            $sales_return_amount = $excluding_this_amount;
        }

        else {

            
        //     * This invoice is not included therefore go with all the previous amount value. 
        //     * Total amount of sale is :-
            

             $sales_return_amount = $all_previous_sales_return_amount;

        }

        $payment_method = PaymentMethod::where([
            'method' => 'Cheque',
            'management_approval' => 1
        ])->first();

        $cheque_method_id = $payment_method->id;

        $client_payment_received_data_without_cheque = PaymentReceived::where([
            'client_code' => $sales_return->client_id,
            'sales_approval' => 1,
            'management_approval' => 1,
        ])
        ->where('date', '<', $due_till_date)
        ->where('payment_mode', '!=', $cheque_method_id)
        ->get();

        $client_payment_received_data_with_cleared_cheque = PaymentReceived::where([
            'client_code' => $sales_return->client_id,
            'sales_approval' => 1,
            'management_approval' => 1,
        ])
        ->where('date', '<', $due_till_date)
        ->where('payment_mode', '=', $cheque_method_id)
        ->where('cheque_clearing_status', '=', 'Cleared')
        ->get();

        $payment_received_not_cheque = $client_payment_received_data_without_cheque->sum('total_received');
        $payment_received_with_cheque = $client_payment_received_data_with_cleared_cheque->sum('total_received');

        $payment_received = $payment_received_not_cheque + $payment_received_with_cheque;

        $overall_due = ($payment_received + $sales_return_amount) - $all_previous_sales_amount;
        $dues_including_current_return = $overall_due + $sales_return->amount_after_discount;

        return view('invoices.sales_return.show')
            ->with('sales_return', $sales_return)
            ->with('due_till_date', $due_till_date)
            ->with('overall_due', $overall_due)
            ->with('dues_including_current_return', $dues_including_current_return);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sales_return  $sales_return
     * @return \Illuminate\Http\Response
     */
    public function edit(Sales_return $sales_return)
    {
        $sales_returns = $sales_return;
        $clients = Party::where([
            'audit_approval'=> 1,
            'management_approval'=> 1,
        ])->get();
        
        $products = DB::table('products')
        ->join('inventories', 'products.id', '=', 'inventories.product_id')
        ->select('products.id','products.product_code', 'products.product_name')
        ->where([
            'inventories.audit_approval'=> 1,
            'inventories.management_approval'=> 1,
        ])
        ->get();

        $sales_returns_products = SalesReturnsProduct::where('invoice_no', $sales_return->invoice_no)->get();
        
        return view('invoices.sales_return.edit')
            ->with('sales_returns', $sales_returns)
            ->with('clients', $clients)
            ->with('products', $products)
            ->with('sales_returns_products', $sales_returns_products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sales_return  $sales_return
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sales_return $sales_return)
    {
        $invoice_no = $request->invoice_no;

        $sales_return->date = $request->date;
        $sales_return->client_id = $request->client_code;
        $sales_return->total_sales_return = $request->total_sales_return;
        $sales_return->discount_percentage = $request->discount_percentage;
        $sales_return->amount_after_discount = $request->amount_after_discount;
        $sales_return->remarks = $request->remarks;
        $sales_return->save();

        $counter = count($request->product_code);

        DB::table('sales_returns_products')->where('invoice_no', $invoice_no)->delete();

        for ($i=0; $i < $counter; $i++) { 
            DB::table('sales_returns_products')->insert([
                'invoice_no' => $invoice_no,
                'product_id' => $request->product_code[$i],
                'price_per_unit' => $request->price_per_unit[$i],
                'quantity' => $request->quantity[$i],
                'commission_percentage' => $request->commission[$i],
                'remark' => $request->remark[$i]
            ]);
        }

        return redirect()->route('sales_return.index');  

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sales_return  $sales_return
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sales_return $sales_return)
    {
        // destroy all the products of that sales_return
        SalesReturnsProduct::where('invoice_no', $sales_return->invoice_no)->delete();

        $sales_return->delete();

        return redirect()->route('sales_return.index');
    }

    public function management_approval($id)
    {
        $sales_return = Sales_return::find($id);

        // first lets see if it is approved by audit or not
        if ($sales_return->audit_approval == 1) {
            // let us just get hte products now
            $all_returned_products = DB::table('sales_returns_products')
                ->where('invoice_no', $sales_return->invoice_no)
                ->get();

            // now select each of the product and find out the quantity:
            foreach ($all_returned_products as $product) {
                $quantity = 0;

                $products_in_inventory = Inventory::where([
                    'product_id' => $product->product_id,
                    'audit_approval' => 1,
                    'management_approval' => 1
                    ])
                    ->orderBy('created_at', 'desc')
                    ->first();

                $quantity = $product->quantity + $products_in_inventory->quantity;
                $products_in_inventory->quantity = $quantity;
                $products_in_inventory->save();
            }

            $sales_return->management_approval = 1;
            $sales_return->save();

            return redirect()->back();
        }

        else {
            $sales_return->management_approval = 1;
            $sales_return->save();

            return redirect()->back();
        }
    }

    public function management_dissapproval($id)
    {
        $sales_return = Sales_return::find($id);
        $sales_return->management_approval = 0;
        $sales_return->save();

        return redirect()->route('sales_return.index');
    }

    public function audit_approval($id)
    {
        $sales_return = Sales_return::find($id);

        // first lets see if it is approved by audit or not
        if ($sales_return->management_approval == 1) {
            // let us just get hte products now
            $all_returned_products = DB::table('sales_returns_products')
                ->where('invoice_no', $sales_return->invoice_no)
                ->get();

            // now select each of the product and find out the quantity:
            foreach ($all_returned_products as $product) {
                $quantity = 0;

                $products_in_inventory = Inventory::where([
                    'product_id' => $product->product_id,
                    'audit_approval' => 1,
                    'management_approval' => 1
                    ])
                    ->orderBy('created_at', 'desc')
                    ->first();

                $quantity = $product->quantity + $products_in_inventory->quantity;
                $products_in_inventory->quantity = $quantity;
                $products_in_inventory->save();
            }

            $sales_return->audit_approval = 1;
            $sales_return->save();

            return redirect()->back();
        }

        else {
            $sales_return->audit_approval = 1;
            $sales_return->save();

            return redirect()->back();
        }
    }

    public function audit_dissapproval($id)
    {
        $sales_return = Sales_return::find($id);
        $sales_return->audit_approval = 0;
        $sales_return->save();

        return redirect()->route('sales_return.index');
    }
}
