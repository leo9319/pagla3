<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Sales_return;
use App\PaymentReceived;
use App\Party;
use App\Party_type;
use App\Zone;
use App\Product;
use App\Collection;
use App\SaleProduct;
use App\PaymentMethod;
use App\AdjustedBalance;
use Illuminate\Http\Request;
use DB;
use Auth;
use Redirect;

class SaleController extends Controller
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

        $sales_return_data = Sales_return::where([
            'audit_approval' => 1,
            'management_approval' => 1,
        ])->get();
        
        $products = DB::table('products')
        ->join('inventories', 'products.id', '=', 'inventories.product_id')
        ->select('products.id','products.product_code', 'products.product_name')
        ->where([
            'inventories.audit_approval'=> 1,
            'inventories.management_approval'=> 1,
        ])
        ->get();

        $sales = Sale::orderBy('invoice_no', 'desc')->get();

        $last_invoice = Sale::latest('id')->first();

        if($last_invoice != NULL) {

            $last_code = preg_replace("/[^0-9\.]/", '', $last_invoice->invoice_no);
            $last_code = $last_code + 1;
            $invoice_id = 'IN' . sprintf('%06d', ($last_code));

        }
        else {
            $invoice_id = 'IN000001';
        }

        if($user->user_type == 'sub_management') {
            return view('invoices.sales.sub_management.index')
            ->with('sales', $sales)
            ->with('clients', $clients)
            ->with('products', $products)
            ->with('invoice_id', $invoice_id)
            ->with('user', $user);

        } elseif ($user->user_type == 'management') {
            return view('invoices.sales.management.index')
            ->with('sales', $sales)
            ->with('clients', $clients)
            ->with('products', $products)
            ->with('invoice_id', $invoice_id)
            ->with('user', $user);
        }

        return view('invoices.sales.index')
            ->with('sales', $sales)
            ->with('clients', $clients)
            ->with('products', $products)
            ->with('invoice_id', $invoice_id)
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
        // check if the invoice number exixts

        $invoice_exists = Sale::where('invoice_no', $request->invoice_no)->get();

        if(count($invoice_exists) > 0) {

            // invoice exits

            $last_invoice = Sale::latest('id')->first();

            $last_code = preg_replace("/[^0-9\.]/", '', $last_invoice->invoice_no);

            $last_code = $last_code + 1;

            $invoice_id = 'IN' . sprintf('%06d', ($last_code + 1));

        } else {

            // invoice doesnt exist

            $invoice_id = $request->invoice_no;
            
        }

        $sale = new Sale;

        // get the sales person name

        $sales_person_name = DB::table('h_r_s')->where('id', $request->present_sr_id)->first()->name;

        $sale->date = $request->date;
        $sale->invoice_no = $invoice_id;
        $sale->client_id = $request->client_id; 
        $sale->total_sales = $request->total_sales;
        $sale->discount_percentage = $request->discount_percentage;
        $sale->amount_after_discount = $request->amount_after_discount;
        $sale->present_sr_id = $sales_person_name;
        $sale->remarks = $request->remarks;
        $sale->save();

        $counter = count($request->product_code);

        for ($i=0; $i < $counter; $i++) { 
            DB::table('sales_products')->insert([
                'invoice_no' => $invoice_id,
                'product_id' => $request->product_code[$i],
                'price_per_unit' => $request->price_per_unit[$i],
                'quantity' => $request->quantity[$i],
                'commission_percentage' => $request->commission_percentage[$i],
                'remark' => $request->remark[$i]
            ]);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */

    public function date($id)
    {   
        return view('invoices.sales.date')
            ->with('id', $id);
    }
    
    public function show(Sale $sale)
    {
        $data = Sale::where([
            'client_id' => $sale->client_id,
            'audit_approval' => 1,
            'management_approval' => 1,
        ])->get();

        // Time to get all the sales return from that particular client
        $sales_return_data = Sales_return::where([
            'client_id' => $sale->client_id,
            'audit_approval' => 1,
            'management_approval' => 1,
        ])->get();
        
        $balance_including_this_sale = $data->sum('amount_after_discount'); //Total due including this sale
        
        $balance_excluding_current_sale = $balance_including_this_sale - $sale->amount_after_discount; 
        $total_amount_return = $sales_return_data->sum('amount_after_discount'); // Total sales returned

        $balance = $total_amount_return - $balance_including_this_sale;

        return view('invoices.sales.show')
            ->with('sale', $sale)
            ->with('balance_including_this_sale', $balance_including_this_sale)
            ->with('balance_excluding_current_sale', $balance_excluding_current_sale)
            ->with('total_amount_return', $total_amount_return)
            ->with('balance', $balance);
    }

    public function show_invoice(Request $request, Sale $sale)
    {
        $sale->amount_after_discount;
        $sale->date;

        $due_till_date = $request->date;

        // bypassing due by adding one more day to include that days invoices
        $due_till_date = \Carbon\Carbon::parse($due_till_date)->addDays(1);

        $sales_due = 0;
        $overall_due = 0;

        $client_sales_date = Sale::where([
            'client_id' => $sale->client_id,
            'audit_approval' => 1,
            'management_approval' => 1
        ])
        ->where('date', '<', $due_till_date)
        ->where('invoice_no', '<', $sale->invoice_no)
        ->get();

        $all_previous_sales_amount = $client_sales_date->sum('amount_after_discount');
        
        $sales_due = $all_previous_sales_amount;

        // Time to find the sales_return_amount
        $client_sales_return_data = Sales_return::where([
            'client_id' => $sale->client_id,
            'audit_approval' => 1,
            'management_approval' => 1,
        ])
        ->where('date', '<', $due_till_date)
        ->get();

        // This are all the previous sales return 
        $all_previous_sales_return_amount = $client_sales_return_data->sum('amount_after_discount');

        // Now its time to find all the payment received other than cheque

        // slect all from payment received where method = Cheque and find its id
        $payment_method = PaymentMethod::where([
            'method' => 'Cheque',
            'management_approval' => 1
        ])->first();

        $cheque_method_id = $payment_method->id;

        $client_payment_received_data_without_cheque = PaymentReceived::where([
            'client_code' => $sale->client_id,
            'sales_approval' => 1,
            'management_approval' => 1,
        ])
        ->where('date', '<', $due_till_date)
        ->where('payment_mode', '!=', $cheque_method_id)
        ->get();

        $client_payment_received_data_with_cleared_cheque = PaymentReceived::where([
            'client_code' => $sale->client_id,
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
        // $payment_received = $client_payment_received_data->sum('total_received');

        $adjustments = AdjustedBalance::getClientOverallApprovedAdjustments($sale->client_id)->sum('amount');

        // $overall_due = ($all_previous_sales_return_amount + $payment_received) - $sales_due;
        // $dues_including_current_sale = $overall_due - $sale->amount_after_discount;

        $overall_due = ($all_previous_sales_return_amount + $payment_received) - $sales_due + $adjustments;
        $dues_including_current_sale = $overall_due - $sale->amount_after_discount;

        return view('invoices.sales.show')
            ->with('sale', $sale)
            ->with('due_till_date', $due_till_date)
            ->with('overall_due', $overall_due)
            ->with('dues_including_current_sale', $dues_including_current_sale);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $clients = Party::where([
            'audit_approval'=> 1,
            'management_approval'=> 1,
        ])->get();

        $sales = $sale;

        $last_invoice = DB::table('sales')->orderBy('id', 'desc')->limit(1)->first();
        
        $products = DB::table('products')
        ->join('inventories', 'products.id', '=', 'inventories.product_id')
        ->select('products.id','products.product_code', 'products.product_name')
        ->where([
            'inventories.audit_approval'=> 1,
            'inventories.management_approval'=> 1,
        ])
        ->get();

        $sales_products = SaleProduct::where('invoice_no', $sale->invoice_no)->get();

        return view('invoices.sales.edit')
            ->with('sales', $sales)
            ->with('clients', $clients)
            ->with('sales_products', $sales_products)
            ->with('products', $products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        $invoice_no = $request->invoice_no;

        // echo $invoice_no;

        // echo '<hr>';
        $sale = Sale::find($sale->id);

        $sale->date = $request->date;
        $sale->client_id = $request->client_code;
        $sale->total_sales = $request->total_sales;
        $sale->discount_percentage = $request->discount_percentage;
        $sale->amount_after_discount = $request->amount_after_discount;
        $sale->remarks = $request->remarks;
        $sale->save();

        $counter = count($request->product_code);

        // Delete them all

        DB::table('sales_products')->where('invoice_no', $invoice_no)->delete();

        for ($i=0; $i < $counter; $i++) { 
            DB::table('sales_products')->insert([
                'invoice_no' => $invoice_no,
                'product_id' => $request->product_code[$i],
                'price_per_unit' => $request->price_per_unit[$i],
                'quantity' => $request->quantity[$i],
                'commission_percentage' => $request->commission[$i],
                'remark' => $request->remark[$i]
            ]);

            // echo 'Product Code: ' . $request->product_code[$i] . '<br>';
            // echo 'Price per unit: ' . $request->price_per_unit[$i] . '<br>';
            // echo 'Quantity: ' . $request->quantity[$i] . '<br>';
            // echo 'Commission Percentage: ' . $request->commission[$i] . '%<br>';
            // echo 'Remarks: ' . $request->remark[$i] . '<br>';
            // echo '<hr>';
        }

        return redirect()->route('sales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->back();
    }

    public function management_approval($id)
    {
        $execute = false;
        $sale = Sale::find($id);

        if ($sale->audit_approval == 1) {
            $sale_products = DB::table('sales_products')->where('invoice_no', $sale->invoice_no)->get();

            // go through each of the products and reduce from the inventories
            foreach ($sale_products as $sale_product) {
                $all_inventories = DB::table('inventories')
                    ->where([
                        'product_id' => $sale_product->product_id,
                        'audit_approval' => 1,
                        'management_approval' => 1
                    ])
                    ->orderBy('created_at')
                    ->get();

                $sum_of_quantity = $all_inventories->sum('quantity');
                ($sale_product->quantity <= $sum_of_quantity) ? ( $execute = true) : ($execute = false);

                if(!$execute) {
                    break;
                }
            }

            if ($execute) {
                echo '<b>Everything is good and we are good to go!</b>';
                $sale->management_approval = 1;
                $sale->save();

                foreach($sale_products as $sale_product) {
                    $quantity_remaining = $sale_product->quantity;

                    $all_inventories = DB::table('inventories')
                                        ->where([
                                            'product_id' => $sale_product->product_id,
                                            'audit_approval' => 1,
                                            'management_approval' => 1
                                        ])
                                        ->orderBy('created_at')
                                        ->get();

                    while($quantity_remaining > 0) {
                        foreach ($all_inventories as $inventory) {
                            if ($inventory->quantity >= $quantity_remaining) {
                                $remaining_quantity_in_present_inventory = $inventory->quantity - $quantity_remaining;

                                DB::table('inventories')
                                    ->where('id', $inventory->id)
                                    ->update(['quantity' => $remaining_quantity_in_present_inventory]);

                                $quantity_remaining = 0;
                                break;
                            }

                            else {
                                DB::table('inventories')
                                    ->where('id', $inventory->id)
                                    ->update(['quantity' => 0]);

                                $quantity_remaining = $quantity_remaining - $inventory->quantity;

                                echo $quantity_remaining;
                            }
                        }
                    }
                }

                return Redirect::back();
            }

            else {
                return Redirect::back()->withErrors(['There is a shortage of products in the inventory!']);
            }

        }
        else {
            $sale->management_approval = 1;
            $sale->save();

            return Redirect::back();
        }
    }

    public function management_dissapproval($id)
    {
        $sale = Sale::find($id);
        $sale->management_approval = 0;
        $sale->save();

        return redirect()->route('sales.index');
    }

    public function audit_approval($id)
    {
        $execute = false;
        $sale = Sale::find($id);

        if ($sale->management_approval == 1) {
            $sale_products = DB::table('sales_products')->where('invoice_no', $sale->invoice_no)->get();

            foreach ($sale_products as $sale_product) {
                $all_inventories = DB::table('inventories')
                    ->where([
                        'product_id' => $sale_product->product_id,
                        'audit_approval' => 1,
                        'management_approval' => 1
                    ])
                    ->orderBy('created_at')
                    ->get();

                $sum_of_quantity = $all_inventories->sum('quantity');
                ($sale_product->quantity <= $sum_of_quantity) ? ( $execute = true) : ($execute = false);

                if(!$execute) {
                    break;
                }
            }

            if ($execute) {
                $sale->audit_approval = 1;
                $sale->save();

                foreach($sale_products as $sale_product) {
                    $quantity_remaining = $sale_product->quantity;

                    $all_inventories = DB::table('inventories')
                                        ->where([
                                            'product_id' => $sale_product->product_id,
                                            'audit_approval' => 1,
                                            'management_approval' => 1
                                        ])
                                        ->orderBy('created_at')
                                        ->get();

                    while($quantity_remaining > 0) {
                        foreach ($all_inventories as $inventory) {
                            if ($inventory->quantity >= $quantity_remaining) {
                                $remaining_quantity_in_present_inventory = $inventory->quantity - $quantity_remaining;

                                DB::table('inventories')
                                    ->where('id', $inventory->id)
                                    ->update(['quantity' => $remaining_quantity_in_present_inventory]);

                                $quantity_remaining = 0;
                                break;
                            }

                            else {
                                DB::table('inventories')
                                    ->where('id', $inventory->id)
                                    ->update(['quantity' => 0]);

                                $quantity_remaining = $quantity_remaining - $inventory->quantity;

                                echo $quantity_remaining;
                            }
                        }
                    }
                }

                return Redirect::back();
            }

            else {
                return Redirect::back()->withErrors(['There is a shortage of products in the inventory!']);
            }

        }
        else {
            $sale->audit_approval = 1;
            $sale->save();

            return Redirect::back();
        }
    }

    public function audit_dissapproval($id)
    {
        $sale = Sale::find($id);
        $sale->audit_approval = 0;
        $sale->save();

        return redirect()->route('sales.index');
    }

    public function test()
    {
        $sales = Sale::with('products');
        // $products = Product::with('sale');
        $products = Product::all();

        return view('test')
            ->with('sales', $sales)
            ->with('products', $products);
    }

    public function findSalesInvoices(Request $request)
    {
        $data= DB::table('sales')
        ->select('id', 'invoice_no')
        ->where([
            'client_id' => $request->id,
            'audit_approval' => 1,
            'management_approval' => 1
        ])
        ->get();

        return response()->json($data);
    }

    public function preview(Sale $sale)
    {
        $clients = Party::where([
            'audit_approval'=> 1,
            'management_approval'=> 1,
        ])->get();

        $sales = $sale;

        $last_invoice = DB::table('sales')->orderBy('id', 'desc')->limit(1)->first();
        
        $products = DB::table('products')
        ->join('inventories', 'products.id', '=', 'inventories.product_id')
        ->select('products.id','products.product_code', 'products.product_name')
        ->where([
            'inventories.audit_approval'=> 1,
            'inventories.management_approval'=> 1,
        ])
        ->get();

        $sales_products = SaleProduct::where('invoice_no', $sale->invoice_no)->get();

        // Due Calculation

        $due_till_date = \Carbon\Carbon::today()->format('Y-m-d');

        // bypassing due by adding one more day to include that days invoices
        $due_till_date = \Carbon\Carbon::parse($due_till_date)->addDays(1);

        $sales_due = 0;
        $overall_due = 0;

        $client_sales_date = Sale::where([
            'client_id' => $sale->client_id,
            'audit_approval' => 1,
            'management_approval' => 1
        ])
        ->where('date', '<', $due_till_date)
        ->where('invoice_no', '<', $sale->invoice_no)
        ->get();

        $all_previous_sales_amount = $client_sales_date->sum('amount_after_discount');

        $sales_due = $all_previous_sales_amount;

        // Time to find the sales_return_amount
        $client_sales_return_data = Sales_return::where([
            'client_id' => $sale->client_id,
            'audit_approval' => 1,
            'management_approval' => 1,
        ])
        ->where('date', '<', $due_till_date)
        ->get();

        // This are all the previous sales return 
        $all_previous_sales_return_amount = $client_sales_return_data->sum('amount_after_discount');

        // Now its time to find all the payment received other than cheque

        // slect all from payment received where method = Cheque and find its id
        $payment_method = PaymentMethod::where([
            'method' => 'Cheque',
            'management_approval' => 1
        ])->first();

        $cheque_method_id = $payment_method->id;

        $client_payment_received_data_without_cheque = PaymentReceived::where([
            'client_code' => $sale->client_id,
            'sales_approval' => 1,
            'management_approval' => 1,
        ])
        ->where('date', '<', $due_till_date)
        ->where('payment_mode', '!=', $cheque_method_id)
        ->get();

        $client_payment_received_data_with_cleared_cheque = PaymentReceived::where([
            'client_code' => $sale->client_id,
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
        // $payment_received = $client_payment_received_data->sum('total_received');

        // echo $all_previous_sales_return_amount;
        $overall_due = ($all_previous_sales_return_amount + $payment_received) - $sales_due;
        $dues_including_current_sale = $overall_due - $sale->amount_after_discount;

        return view('invoices.sales.preview')
            ->with('sales', $sales)
            ->with('clients', $clients)
            ->with('sales_products', $sales_products)
            ->with('products', $products)
            ->with('overall_due', $overall_due)
            ->with('dues_including_current_sale', $dues_including_current_sale);

    }
}