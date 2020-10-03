<?php

namespace App\Http\Controllers;

use App\User;
use App\Menu;
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
            $user = Auth::user();
            $user_data = User::where('users.id', $user->id)
                    ->join('payments as p','p.user_id', '=', 'users.id')
                    ->first();
            return view('dashboard', ['role_id' => 2, 'user' => $user_data]);
        }else if( Auth::user()->hasRole('patient')) {
            $user = Auth::user();
            $user_data = User::where('users.id', $user->id)
                    ->leftJoin('payments as p','p.user_id', '=', 'users.id')
                    ->orderBy('p.id', 'desc')
                    ->first();
            //dd($user_data);
            $menus = Menu::where('user_id', $user->id)->count();
            return view('dashboard', ['role_id' => 3, 'menus' => $menus, 'user' => $user_data]);
        }else if( Auth::user()->hasRole('admin')) {
            $role_id = 1;
        }
    }
}
