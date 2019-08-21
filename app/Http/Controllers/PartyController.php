<?php

namespace App\Http\Controllers;

use App\Party;
use App\Zone;
use App\Sale;
use App\PaymentMethod;
use App\PaymentReceived;
use App\Sales_return;
use App\Party_type;
use App\Collection;
use App\Sales_delivery;
use App\AdjustedBalance;
use DB;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PartyController extends Controller
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
        $parties = Party::all();
        
        $zones = Zone::where([
            'audit_approval'=> 1,
            'management_approval'=> 1,
        ])->pluck('zone', 'id');

        $party_types = Party_type::where([
            'audit_approval'=> 1,
            'management_approval'=> 1,
        ])->pluck('type', 'id');

        $last_client = DB::table('parties')->orderBy('id', 'desc')->limit(1)->first();

        // if the last_product exists
        if($last_client != NULL) {
            $client_id = 'CL' . sprintf('%06d', ($last_client->id + 1));
        }
        else {
            $client_id = 'CL000001';
        }

        if($user->user_type == 'sub_management') {
            return view('parties.sub_management.index')
            ->with('zones', $zones)
            ->with('party_types', $party_types)
            ->with('parties', $parties)
            ->with('client_id', $client_id)
            ->with('user', $user);

        } elseif($user->user_type == 'management') {
            return view('parties.management.index')
            ->with('zones', $zones)
            ->with('party_types', $party_types)
            ->with('parties', $parties)
            ->with('client_id', $client_id)
            ->with('user', $user);
        }

        return view('parties.index')
            ->with('zones', $zones)
            ->with('party_types', $party_types)
            ->with('parties', $parties)
            ->with('client_id', $client_id)
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
        Party::create($request->all());

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function show(Party $party)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function edit(Party $party)
    {
        $parties = $party;
        $zones = Zone::pluck('zone', 'id');
        $party_types = Party_type::pluck('type', 'id');

        return view('parties.edit')
            ->with('zones', $zones)
            ->with('party_types', $party_types)
            ->with('parties', $parties);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Party $party)
    {
        $party->update($request->all());   
        return redirect()->route('parties.index'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy(Party $party)
    {
        $party->delete();

        return redirect()->route('parties.index'); 
    }

    public function management_approval($id)
    {
        $party = Party::find($id);
        $party->management_approval = 1;
        $party->save();

        return redirect()->route('parties.index');
    }

    public function management_dissapproval($id)
    {
        $party = Party::find($id);
        $party->management_approval = 0;
        $party->save();

        return redirect()->route('parties.index');
    }

    public function audit_approval($id)
    {
        $party = Party::find($id);
        $party->audit_approval = 1;
        $party->save();

        return redirect()->route('parties.index');
    }

    public function audit_dissapproval($id)
    {
        $party = Party::find($id);
        $party->audit_approval = 0;
        $party->save();

        return redirect()->route('parties.index');
    }

    public function findClientName(Request $request) 
    {
        $data = DB::table('parties')
        ->join('party_types', 'parties.party_type_id', '=', 'party_types.id')
        ->join('h_r_s', 'parties.zone', '=', 'h_r_s.zone')
        ->select('parties.party_name', 'parties.party_type_id', 'parties.id', 'parties.zone', 'party_types.type', 'h_r_s.id AS hr_id', 'h_r_s.name AS hr_name')
        ->where('parties.id', '=', $request->id)
        ->where('h_r_s.role', '=', 'Sales')
        ->where('h_r_s.audit_approval', '=', 1)
        ->where('h_r_s.management_approval', '=', 1)
        ->where('h_r_s.sales_approval', '=', 1)
        ->get();

        return response()->json($data);
    }

    public function findClientCode(Request $request) 
    {
        $data= DB::table('parties')
        ->join('party_types', 'parties.party_type_id', '=', 'party_types.id')
        ->join('h_r_s', 'parties.zone', '=', 'h_r_s.zone')
        ->select('parties.party_id', 'parties.party_type_id', 'parties.id', 'parties.zone', 'party_types.type', 'h_r_s.id AS hr_id', 'h_r_s.name AS hr_name')
        ->where('parties.id', '=', $request->id)
        ->where('h_r_s.role', '=', 'Sales')
        ->where('h_r_s.audit_approval', '=', 1)
        ->where('h_r_s.management_approval', '=', 1)
        ->where('h_r_s.sales_approval', '=', 1)
        ->get();

        return response()->json($data);
    }
}
