<?php

namespace App\Http\Controllers;

use App\Party;
use App\Product;
use App\Sale;
use App\SaleProduct;
use App\Test;
use DB;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Storage;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return SaleProduct::select('*')
        //         // ->join('parties', 'sales.client_id', '=', 'parties.id')
        //         // ->join('party_types', 'parties.party_type_id', '=', 'party_types.id')
        //         ->leftJoin('sales', 'sales.invoice_no', '=', 'sales_products.invoice_no')
        //         // ->whereIn('party_types.id', [1,2,3])
        //         ->groupBy('sales.invoice_no')
        //         // ->where('sales.audit_approval', 1)
        //         // ->where('sales.management_approval', 1)
        //         ->limit(100)
        //         ->get();

        return Sale::with(['sale_products' => function($query){
           $query->sum('quantity');
        }])->limit(100)->get();
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
        $image = $request->file('image');
        $filename = $image->getClientOriginalName();
        Storage::put('upload/images/' . $filename, file_get_contents($request->file('image')->getRealPath()));

        $test = new Test;
        $test->bank_reference = $request->bank_reference;
        $test->image = $filename;
        $test->save();

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        //
    }

    public function test()
    {
        return view('test');
    }
}
