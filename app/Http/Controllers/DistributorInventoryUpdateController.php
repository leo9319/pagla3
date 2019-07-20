<?php

namespace App\Http\Controllers;

use App\Distributor_inventory_update;
use App\Party;
use App\Product;
use DB;
use Illuminate\Http\Request;
use Auth;

class DistributorInventoryUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin,management,warehouse,audit,sales,hr')->only('index');
        $this->middleware('role:superadmin,management')->only('edit', 'destroy');
    }


    public function index()
    {
        $user = Auth::user();
        $distributor_inventory_updates = Distributor_inventory_update::all();
        // $clients = Party::all();
        $clients = Party::where([
            'audit_approval'=> 1,
            'management_approval'=> 1,
        ]);

        // Getting all the products from the approved inventory list
        // $products = DB::table('products')
        // ->join('inventories', 'products.id', '=', 'inventories.product_id')
        // ->select('products.id','products.product_code', 'products.product_name')
        // ->where([
        //     'inventories.audit_approval'=> 1,
        //     'inventories.management_approval'=> 1,
        // ])
        // ->get();

        // Getting all the products from the approved product list.
        $products = Product::where([
            'audit_approval' => 1,
            'management_approval' => 1,
        ]);

        return view('inventories.distribution_inventory_update.index')
            ->with('distributor_inventory_updates', $distributor_inventory_updates)
            ->with('clients', $clients)
            ->with('products', $products)
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
        Distributor_inventory_update::create($request->all());

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Distributor_inventory_update  $distributor_inventory_update
     * @return \Illuminate\Http\Response
     */
    public function show(Distributor_inventory_update $distributor_inventory_update)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Distributor_inventory_update  $distributor_inventory_update
     * @return \Illuminate\Http\Response
     */
    public function edit(Distributor_inventory_update $distributor_inventory_update, $id)
    {
        $distributor_inventory_update = DB::table('distributor_inventory_updates')->where('id', $id)->first();
        $clients = Party::all();
        $products = DB::table('products')
        ->join('inventories', 'products.id', '=', 'inventories.product_id')
        ->select('products.id','products.product_code', 'products.product_name')
        ->get();

        return view('inventories.distribution_inventory_update.edit')
            ->with('distributor_inventory_update', $distributor_inventory_update)
            ->with('clients', $clients)
            ->with('products', $products);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Distributor_inventory_update  $distributor_inventory_update
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        DB::table('distributor_inventory_updates')
            ->where('id', $id)
            ->update([
                'client_code' => $request->client_code,
                'product_code' => $request->product_code,
                'product_type' => $request->product_type,
                'ppu' => $request->ppu,
                'client_name' => $request->client_name,
                'product_name' => $request->product_name,
                'brand' => $request->brand,
                'quantity' => $request->quantity,
                'commission_percentage' => $request->commission_percentage,
                'ppu_after_commission' => $request->ppu_after_commission,
                'total_commission' => $request->total_commission,
                'total_before_commission' => $request->total_before_commission,
                'CIVAC' => $request->CIVAC,
                'remarks' => $request->remarks,
            ]);

        return redirect()->route('distribution.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Distributor_inventory_update  $distributor_inventory_update
     * @return \Illuminate\Http\Response
     */
    public function destroy(Distributor_inventory_update $distributor_inventory_update, $id)
    {
        DB::table('distributor_inventory_updates')->where('id', $id)->delete();
        return redirect()->route('distribution.index');
    }

    public function management_approval($id)
    {
        $distributor_inventory_update = Distributor_inventory_update::find($id);
        $distributor_inventory_update->management_approval = 1;
        $distributor_inventory_update->save();

        return redirect()->route('distribution.index');
    }

    public function management_dissapproval($id)
    {
        $distributor_inventory_update = Distributor_inventory_update::find($id);
        $distributor_inventory_update->management_approval = 0;
        $distributor_inventory_update->save();

        return redirect()->route('distribution.index');
    }

    public function audit_approval($id)
    {
        $distributor_inventory_update = Distributor_inventory_update::find($id);
        $distributor_inventory_update->audit_approval = 1;
        $distributor_inventory_update->save();

        return redirect()->route('distribution.index');
    }

    public function audit_dissapproval($id)
    {
        $distributor_inventory_update = Distributor_inventory_update::find($id);
        $distributor_inventory_update->audit_approval = 0;
        $distributor_inventory_update->save();

        return redirect()->route('distribution.index');
    }
}
