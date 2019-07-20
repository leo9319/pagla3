<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function user()
    {
        return view('auth.register');
    }

    public function register_user(Request $request)
    {   
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'username' => $request['username'],
            'password' => bcrypt($request['password']),
            'username' => $request['username'],
            'user_type' => $request['user_type'],
        ]);

        return redirect()->back();

    }

    public function view_users()
    {
        $users = User::all();

        return view('auth.profile')
            ->with('users', $users);
    }
    
}
