<?php

namespace App\Http\Controllers;

use App\Commission;
use App\Party_type;
use App\Product_type;
use Illuminate\Http\Request;
use DB;
use Auth;

class CommissionController extends Controller
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
        $this->middleware('role:superadmin,sub_management')->only('edit','destroy');
        $this->middleware('role:superadmin,audit,management,sub_management')->only('create');
    }

    public function index()
    {
        $party_types = DB::table('commissions')
            ->join('party_types', 'commissions.party_types_id', '=', 'party_types.id')
            ->select('commissions.party_types_id', 'party_types.type')
            ->distinct()
            ->get();

        return view('commissions.index')
            ->with('party_types', $party_types);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $party_types = Party_type::where([
            'audit_approval'=> 1,
            'management_approval'=> 1,
        ])->pluck('type', 'id');

        return view('commissions.create')
            ->with('party_types', $party_types);
    }

    public function create_second(Request $request)
    {
        
        $party_id = $request->party_type;
        $party_name = Party_type::find($party_id)->type;
        $product_types = Product_type::all();
        $product_types_array = Product_type::pluck('type','id');
        $table_entries = DB::table('commissions')->where('party_types_id', '=', $party_id)->exists();
        $table_entries = DB::table('commissions')->where('party_types_id', '=', $party_id)->delete();

        return view('commissions.create_second')
            ->with('party_id', $party_id)
            ->with('party_name', $party_name)
            ->with('product_types', $product_types)
            ->with('product_types_array', $product_types_array);
    }

    public function create_third(Request $request)
    {

        // get the product id
        $request->party_id;

        // get all the product_typ_id
        $product_types = Product_type::all();
        $counter = 0;

        foreach ($product_types as $product_type) {
                DB::table('commissions')
                ->insert([
                    'party_types_id' => $request->party_id, 
                    'product_types_id' => $product_type->id,
                    'commission_percentage' =>  $request->commission_percentage[$counter]
                ]);

                $counter++;
        }   

        return redirect('/commissions/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {      
        $user = Auth::user();
        $party_name = Party_type::find($id);
        // $product_type_names = Product_type::all();

        $product_type_data = DB::table('commissions')
            ->join('product_types', 'commissions.product_types_id', '=', 'product_types.id')
            ->select('commissions.product_types_id', 'commissions.commission_percentage', 'commissions.management_approval', 'commissions.audit_approval', 'product_types.type')
            ->where('party_types_id', $id)
            ->get();

        if($user->user_type == 'sub_management') {
            return view('commissions.sub_management.show')
                ->with('party_name', $party_name)
                ->with('product_type_data', $product_type_data)
                ->with('id', $id)
                ->with('user', $user);

        } elseif ($user->user_type == 'management') {
            return view('commissions.management.show')
                ->with('party_name', $party_name)
                ->with('product_type_data', $product_type_data)
                ->with('id', $id)
                ->with('user', $user);
        }
        
        
        return view('commissions.show')
            ->with('party_name', $party_name)
            ->with('product_type_data', $product_type_data)
            ->with('id', $id)
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $party_name = Party_type::find($id);
        $commissions = Commission::where('party_types_id', $id)->get();

        return view('commissions.edit')
            ->with('party_name', $party_name)
            ->with('commissions', $commissions)
            ->with('party_id', $id);
    }

    public function edit_active($id_party, $id_product)
    {
        $party_name = Party_type::find($id_party);
        $product_name = Product_type::find($id_product);

        $commission = DB::table('commissions')
            ->where([
                'party_types_id' => $id_party,
                'product_types_id'=> $id_product
                ])->first();

        // return $commission->commission_percentage;

        return view('commissions.edit')
            ->with('party_name', $party_name)
            ->with('product_name', $product_name)
            ->with('commission', $commission)
            ->with('id_party', $id_party)
            ->with('id_product', $id_product);
    }

    public function delete_active($id_party, $id_product)
    {
        $commission = DB::table('commissions')
            ->where([
                'party_types_id' => $id_party,
                'product_types_id'=> $id_product
            ])->delete();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commission $commission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commission $commission)
    {
        //
    }

    public function management_approval($id_party, $id_product)
    {
        DB::table('commissions')
            ->where([
                'party_types_id' => $id_party,
                'product_types_id' => $id_product
            ])
            ->update([
                'management_approval' => 1
            ]
        );

        return redirect()->route('commissions.show', ['id'=>$id_party]);
    }

    public function management_dissapproval($id_party, $id_product)
    {
        DB::table('commissions')
            ->where([
                'party_types_id' => $id_party,
                'product_types_id' => $id_product
            ])
            ->update([
                'management_approval' => 0
            ]
        );

        return redirect()->route('commissions.show', ['id'=>$id_party]);
    }

    public function audit_approval($id_party, $id_product)
    {
        DB::table('commissions')
            ->where([
                'party_types_id' => $id_party,
                'product_types_id' => $id_product
            ])
            ->update([
                'audit_approval' => 1
            ]
        );

        return redirect()->route('commissions.show', ['id'=>$id_party]);
    }

    public function audit_dissapproval($id_party, $id_product)
    {
        DB::table('commissions')
            ->where([
                'party_types_id' => $id_party,
                'product_types_id' => $id_product
            ])
            ->update([
                'audit_approval' => 0
            ]
        );

        return redirect()->route('commissions.show', ['id'=>$id_party]);
    }

    public function findCommission(Request $request)
    {
        $data = Commission::select('commission_percentage', 'id')
            ->where('party_types_id', '=', $request->party_types_id)
            ->where('product_types_id', '=', $request->product_types_id)
            ->where('audit_approval', '=', 1)
            ->where('management_approval', '=', 1)
            ->get();

        
        return response()->json($data);
    }

    public function update_commission(Request $request)
    {
        DB::table('commissions')
            ->where([
                'party_types_id' => $request->party_id,
                'product_types_id' => $request->product_id
            ])
            ->update(['commission_percentage' => $request->commission_percentage]);

        return redirect('/commissions/' . $request->party_id);
    }

}
