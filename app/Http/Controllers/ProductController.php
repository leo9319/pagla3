<?php

namespace App\Http\Controllers;

use App\Product;
use App\Inventory;
use App\Product_type;
use Illuminate\Http\Request;
use DB;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superadmin,sub_management')->only('edit', 'destroy');
        $this->middleware('role:management,sub_management')->only('management_approval');
    }

    public function index()
    {
        $products = Product::all();
        $product_types = Product_type::where([
            'audit_approval' => 1,
            'management_approval' => 1,
        ])->pluck('type','id');

        // Generating the products_id
        $last_product = DB::table('products')->orderBy('id', 'desc')->limit(1)->first();

        // if the last_product exists
        if($last_product != NULL) {
            $product_id = 'PAL' . sprintf('%06d', ($last_product->id + 1));
        }
        else {
            $product_id = 'PAL000001';
        }

        $user = Auth::user();

        if($user->user_type == 'sub_management') {
            return view('products.sub_management.input')
                ->with('products', $products)
                ->with('product_types', $product_types)
                ->with('product_id', $product_id)
                ->with('user', $user);

        } elseif($user->user_type == 'management') {

            return view('products.management.input')
                ->with('products', $products)
                ->with('product_types', $product_types)
                ->with('product_id', $product_id)
                ->with('user', $user);

        }   
        
        return view('products.input')
            ->with('products', $products)
            ->with('product_types', $product_types)
            ->with('product_id', $product_id)
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
        Product::create($request->all());
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Product::all();
        $product = Product::find($id);
        $product_types = Product_type::pluck('type','id');

        return view('products.edit')
            ->with('products', $products)
            ->with('product', $product)
            ->with('product_types', $product_types);
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
        $product = Product::find($id);
        $product->update($request->all());

        return redirect()->route('products.index')->with('message','item has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();

        return redirect()->back();
        
    }

    public function management_approval($id)
    {
        $product = Product::find($id);
        $product->management_approval = 1;
        $product->save();

        return redirect()->route('products.index');
    }

    public function management_dissapproval($id)
    {
        $product = Product::find($id);
        $product->management_approval = 0;
        $product->save();

        return redirect()->route('products.index');
    }

    public function audit_approval($id)
    {
        $product = Product::find($id);
        $product->audit_approval = 1;
        $product->save();

        return redirect()->route('products.index');
    }

    public function audit_dissapproval($id)
    {
        $product = Product::find($id);
        $product->audit_approval = 0;
        $product->save();

        return redirect()->route('products.index');
    }

    public function type()
    {
        return view('products.type');
    }

    public function findProductName(Request $request)
    {
        $product   = Product::find($request->id);

        $inventory = Inventory::where([
            'product_id'          => $request->id,
            'audit_approval'      => 1,
            'management_approval' => 1,
        ]);

        $latest_inventory = $inventory->latest()->first();

        $data['product_id']     = $product->id;
        $data['quantity']       = $inventory->sum('quantity');
        $data['product_code']   = $product->product_code;
        $data['product_name']   = $product->product_name;
        $data['brand']          = $product->brand;
        $data['product_type']   = $product->productType->type;
        $data['dlp']            = $latest_inventory->dlp;
        $data['wholesale_rate'] = $latest_inventory->wholesale_rate;
        $data['mrp']            = $latest_inventory->mrp;

        return $data;
    }

    public function findName(Request $request)
    {

        $data= DB::table('products')
        ->join('product_types', 'products.product_type', '=', 'product_types.id')
        ->join('inventories', 'products.id', '=', 'inventories.product_id')
        ->select('products.id','products.product_code', 'products.product_name', 'products.product_type', 'products.brand', 'product_types.type', 'inventories.wholesale_rate', 'inventories.mrp', DB::raw("(SELECT SUM(quantity) FROM inventories WHERE product_id = $request->id) as sum_of_quantity"))
        ->where('products.id', '=', $request->id)
        ->where('inventories.audit_approval', '=', 1)
        ->where('inventories.management_approval', '=', 1)
        ->orderBy('inventories.created_at', 'desc')
        ->get();

        return response()->json($data);
    }

    public function findProductNameForInventory(Request $request)
    {
        $data= DB::table('products')
        ->join('product_types', 'products.product_type', '=', 'product_types.id')
        ->select('products.id','products.product_code', 'products.product_name', 'products.product_type', 'products.brand', 'product_types.type')
        ->where('products.id', '=', $request->id)
        ->get();

        return response()->json($data);
    }

    public function findNameForInventory(Request $request)
    {
        $data= DB::table('products')
        ->join('product_types', 'products.product_type', '=', 'product_types.id')
        ->select('products.id','products.product_code', 'products.product_name', 'products.product_type', 'products.brand', 'product_types.type')
        ->where('products.id', '=', $request->id)
        ->get();

        return response()->json($data);
    }

}
