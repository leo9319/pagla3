<?php

namespace App\Http\Controllers;

use App\Product_type;
use Illuminate\Http\Request;
use DB;
use Auth;

class ProductTypeController extends Controller
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
        $product_types = Product_type::all();

        if ($user->user_type == 'sub_management') {

            return view('products.types.sub_management.type')
            ->with('product_types', $product_types)
            ->with('user', $user);

        } elseif($user->user_type == 'management') {

            return view('products.types.management.type')
            ->with('product_types', $product_types)
            ->with('user', $user);

        }

        return view('products.types.type')
            ->with('product_types', $product_types)
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
        Product_type::create($request->all());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product_type  $product_type
     * @return \Illuminate\Http\Response
     */
    public function show(Product_type $product_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product_type  $product_type
     * @return \Illuminate\Http\Response
     */
    public function edit(Product_type $product_type)
    {
        return view('products.types.edit', compact('product_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product_type  $product_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product_type $product_type)
    {
        $product_type->update($request->all());
        return redirect()->route('product_type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product_type  $product_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product_type $product_type)
    {
        // destroys the product type from the product type database
        $product_type->delete();

        // now we must also destroy that product type id from the commission database
        DB::table('commissions')->where('product_types_id', $product_type->id)->delete();
        
        return redirect()->back();
    }

    public function management_approval($id)
    {
        $product_type = Product_type::find($id);
        $product_type->management_approval = 1;
        $product_type->save();

        return redirect()->route('product_type.index');
    }

    public function management_dissapproval($id)
    {
        $product_type = Product_type::find($id);
        $product_type->management_approval = 0;
        $product_type->save();

        return redirect()->route('product_type.index');
    }

    public function audit_approval($id)
    {
        $product_type = Product_type::find($id);
        $product_type->audit_approval = 1;
        $product_type->save();

        return redirect()->route('product_type.index');
    }

    public function audit_dissapproval($id)
    {
        $product_type = Product_type::find($id);
        $product_type->audit_approval = 0;
        $product_type->save();

        return redirect()->route('product_type.index');
    }
}
