<?php

namespace App\Http\Controllers;

use App\Zone;
use Illuminate\Http\Request;
use Auth;

class ZoneController extends Controller
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
        $zones = Zone::all();

        if ($user->user_type == 'sub_management') {

            return view('zones.sub_management.index')
                ->with('zones', $zones)
                ->with('user', $user);

        } elseif ($user->user_type == 'management') {

            return view('zones.management.index')
                ->with('zones', $zones)
                ->with('user', $user);
        }

        return view('zones.index')
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
        Zone::create($request->all());

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function edit(Zone $zone)
    {
        return view('zones.edit', compact('zone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone)
    {
        $zone->update($request->all());
        return redirect()->route('zones.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone)
    {
        $zone->delete();
        return redirect()->route('zones.index');
    }

    public function management_approval($id)
    {
        $zone = Zone::find($id);
        $zone->management_approval = 1;
        $zone->save();

        return redirect()->route('zones.index');
    }

    public function management_dissapproval($id)
    {
        $zone = Zone::find($id);
        $zone->management_approval = 0;
        $zone->save();

        return redirect()->route('zones.index');
    }

    public function audit_approval($id)
    {
        $zone = Zone::find($id);
        $zone->audit_approval = 1;
        $zone->save();

        return redirect()->route('zones.index');
    }

    public function audit_dissapproval($id)
    {
        $zone = Zone::find($id);
        $zone->audit_approval = 0;
        $zone->save();

        return redirect()->route('zones.index');
    }
}
