<?php

namespace App\Http\Controllers;

use App\Test;
use App\Product;
use App\Sale;
use DB;
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
        $sales = [
                0 => [
                        'product_id' => 'Shampoo 400 ml',
                        'idk'        => 1,
                        'quantity'   => 5,
                        'price'      => 239.74,
                        'total'      => 1198.7,
                        'vat'        => 15,
                        'price_2'      => 179.804,
                        'net_total'  => 1378.50
                    ],

                1 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],

                2 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],

                3 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],

                4 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],

                5 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],

                6 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],

                7 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],

                8 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],

                9 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],10 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],11 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],12 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],13 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],14 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],15 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],16 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],17 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],18 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],19 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],20 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],21 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],22 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],23 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],24 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],25 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],26 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],27 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],28 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],29 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],30 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],31 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],32 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],33 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],34 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],35 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],36 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],37 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],38 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],39 => [

                    'product_id' => 'Shampoo 400 ml',
                    'idk'        => 1,
                    'quantity'   => 5,
                    'price'      => 239.74,
                    'total'      => 1198.7,
                    'vat'        => 15,
                    'price_2'      => 179.804,
                    'net_total'  => 1378.50
                ],
        ];

        $number_of_products = count($sales);

        $pages = ceil($number_of_products / 26);


        return view('test2')->with([
            'pages' => $pages,
            'sales' => $sales,
        ]);
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
