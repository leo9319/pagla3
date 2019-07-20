<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Party_type;
use DB;
use Auth;

class PartyTypeController extends Controller
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
        $party_types = Party_type::all();

        if($user->user_type == 'sub_management') {
            return view('parties.sub_management.type')
            ->with('party_types', $party_types)
            ->with('user', $user);

        } elseif($user->user_type == 'management') {
            return view('parties.management.type')
            ->with('party_types', $party_types)
            ->with('user', $user);
        }

        return view('parties.type')
            ->with('party_types', $party_types)
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
        Party_type::create($request->all());
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
        $party_type = Party_type::find($id);
        return view('parties.party_type_edit', compact('party_type'));
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
        $party_type = Party_type::find($id);

        $party_type->update($request->all());

        return redirect()->route('party_type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Party_type $party_type)
    {
        // Deletes the entry from the party_table
        $party_type->delete();

        // Then delete the entry from the commission table
        DB::table('commissions')->where('party_types_id', $party_type->id)->delete();

        return redirect()->back();
    }

    public function management_approval($id)
    {
        $party_type = Party_type::find($id);
        $party_type->management_approval = 1;
        $party_type->save();

        return redirect()->route('party_type.index');
    }

    public function management_dissapproval($id)
    {
        $party_type = Party_type::find($id);
        $party_type->management_approval = 0;
        $party_type->save();

        return redirect()->route('party_type.index');
    }

    public function audit_approval($id)
    {
        $party_type = Party_type::find($id);
        $party_type->audit_approval = 1;
        $party_type->save();

        return redirect()->route('party_type.index');
    }

    public function audit_dissapproval($id)
    {
        $party_type = Party_type::find($id);
        $party_type->audit_approval = 0;
        $party_type->save();

        return redirect()->route('party_type.index');
    }
}
