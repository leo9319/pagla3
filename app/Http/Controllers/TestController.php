<?php

namespace App\Http\Controllers;

use App\Test;
use App\Product;
use App\Sale;
use App\Party;
use DB;
use DatePeriod;
use DateInterval;
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
        $parties = Party::limit(10)->get();

        $begin = new DateTime('2018-01-01');
        $end = new DateTime('2020-01-01');

        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ($parties as $key => $party) {

            foreach($period as $dt) {
                    echo $party->salesDisapproved($dt->format("m"), $dt->format("Y"))->count();
                }
        }
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
