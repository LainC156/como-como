<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if( Auth::user()->hasRole('nutritionist')) {
            $user = Auth::user()
                    ->join('payments as p','p.user_id', '=', 'users.id')
                    ->first();
            $role_id = 2;
        }else if( Auth::user()->hasRole('patient')) {
            $role_id = 3;
        }else if( Auth::user()->hasRole('admin')) {
            $role_id = 1;
        }
        return view('dashboard', ['role_id' => $role_id, 'user' => $user]);
    }
}
