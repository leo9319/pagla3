<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\Product;
use Illuminate\Http\Request;
use Auth;

class InventoryController extends Controller
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
        $user        = Auth::user();
        $inventories = Inventory::orderBy('id', 'desc')
                        ->where('audit_approval', '!=', 0)
                        ->where('management_approval', '!=', 0)
                        ->get();

        $products    = Product::where([
                            'audit_approval' => 1,
                            'management_approval' => 1,
                       ]);

        if($user->user_type == 'sub_management') {
            return view('inventories.sub_management.index')
             ->with('inventories', $inventories)
             ->with('products', $products)
             ->with('user', $user);

        } elseif($user->user_type == 'management') {

            return view('inventories.management.index')
             ->with('inventories', $inventories)
             ->with('products', $products)
             ->with('user', $user);

        }

        return view('inventories.index')
         ->with('inventories', $inventories)
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
        Inventory::create($request->all());

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        $inventories = $inventory;
        $products = Product::all();

        return view('inventories.edit')
         ->with('inventories', $inventories)
         ->with('products', $products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        $inventory->update($request->all());
        return redirect()->route('inventories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventories.index');
    }

    public function management_approval($id)
    {
        $inventory = Inventory::find($id);
        $inventory->management_approval = 1;
        $inventory->save();

        return redirect()->route('inventories.index');
    }

    public function management_dissapproval($id)
    {
        $inventory = Inventory::find($id);
        $inventory->management_approval = 0;
        $inventory->save();

        return redirect()->route('inventories.index');
    }

    public function audit_approval($id)
    {
        $inventory = Inventory::find($id);
        $inventory->audit_approval = 1;
        $inventory->save();

        return redirect()->route('inventories.index');
    }

    public function audit_dissapproval($id)
    {
        $inventory = Inventory::find($id);
        $inventory->audit_approval = 0;
        $inventory->save();

        return redirect()->route('inventories.index');
    }
}
