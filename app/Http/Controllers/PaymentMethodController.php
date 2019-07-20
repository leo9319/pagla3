<?php

namespace App\Http\Controllers;

use App\PaymentMethod;
use Illuminate\Http\Request;
use Auth;

class PaymentMethodController extends Controller
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
        $payment_methods = PaymentMethod::all();

        if ($user->user_type == 'sub_management') {
            return view('payment_methods.sub_management.index')
                ->with('payment_methods', $payment_methods)
                ->with('user', $user);

        } elseif ($user->user_type == 'management') {
            return view('payment_methods.management.index')
                ->with('payment_methods', $payment_methods)
                ->with('user', $user);
        }

        return view('payment_methods.index')
            ->with('payment_methods', $payment_methods)
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
        PaymentMethod::create($request->all());

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('payment_methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $paymentMethod->update($request->all());

        return redirect()->route('payment_methods.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()->back();
    }

    public function management_approval($id)
    {
        $paymentMethod = PaymentMethod::find($id);
        $paymentMethod->management_approval = 1;
        $paymentMethod->save();

        return redirect()->route('payment_methods.index');
    }

    public function management_dissapproval($id)
    {
        $paymentMethod = PaymentMethod::find($id);
        $paymentMethod->management_approval = 0;
        $paymentMethod->save();

        return redirect()->route('payment_methods.index');
    }
}
