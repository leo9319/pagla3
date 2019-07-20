<?php

namespace App\Http\Controllers;

use App\HR;
use App\Zone;
use Illuminate\Http\Request;
use Auth;

class HRController extends Controller
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
        $hrs = HR::all();
        $zones = Zone::all();

        if ($user->user_type == 'sub_management') {
            return view('hrs.sub_management.index')
                ->with('hrs', $hrs)
                ->with('zones', $zones)
                ->with('user', $user);

        } elseif ($user->user_type == 'management') {
            return view('hrs.management.index')
                ->with('hrs', $hrs)
                ->with('zones', $zones)
                ->with('user', $user);
        }

        return view('hrs.index')
            ->with('hrs', $hrs)
            ->with('zones', $zones)
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
        HR::create($request->all()); 

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HR  $hR
     * @return \Illuminate\Http\Response
     */
    public function show(HR $hR)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HR  $hR
     * @return \Illuminate\Http\Response
     */
    public function edit(HR $hR, $id)
    {
        $hr = HR::find($id);
        $zones = Zone::all();

        return view('hrs.edit')
            ->with('hr', $hr)
            ->with('zones', $zones);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HR  $hR
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HR $hR, $id)
    {
        $hr = HR::find($id);
        $hr->update($request->all());

        return redirect()->route('hrs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HR  $hR
     * @return \Illuminate\Http\Response
     */
    public function destroy(HR $hR, $id)
    {
        $test = HR::find($id)->delete();

        return redirect()->back();
    }

    public function management_approval($id)
    {
        $hr = HR::find($id);
        $hr->management_approval = 1;
        $hr->save();

        return redirect()->route('hrs.index');
    }

    public function management_dissapproval($id)
    {
        $hr = HR::find($id);
        $hr->management_approval = 0;
        $hr->save();

        return redirect()->route('hrs.index');
    }
    
    public function audit_approval($id)
    {
        $hr = HR::find($id);
        $hr->audit_approval = 1;
        $hr->save();

        return redirect()->route('hrs.index');
    }

    public function audit_dissapproval($id)
    {
        $hr = HR::find($id);
        $hr->audit_approval = 0;
        $hr->save();

        return redirect()->route('hrs.index');
    }

    public function sales_approval($id)
    {
        $hr = HR::find($id);
        $hr->sales_approval = 1;
        $hr->save();

        return redirect()->route('hrs.index');
    }

    public function sales_dissapproval($id)
    {
        $hr = HR::find($id);
        $hr->sales_approval = 0;
        $hr->save();

        return redirect()->route('hrs.index');
    }
}
