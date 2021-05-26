<?php

namespace App\Http\Controllers;

use App\Menu;
use App\User;
use Carbon\Carbon;
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
        $user = auth()->user();
        if (Auth::user()->hasRole('nutritionist')) {
            if ($user->trial_version_status) {
                $user->expiration_date = Carbon::parse($user->createdAt)->addMonths(1);
                return view('dashboard', ['role_id' => 2, 'user' => $user]);
            }
            if (!$user->trial_version_status && $user->subscription_status) {
                $user_data = User::where('users.id', $user->id)
                    ->join('payments as p', 'p.user_id', '=', 'users.id')
                    ->where('p.active', 1)
                    ->first();
                return view('dashboard', ['role_id' => 2, 'user' => $user_data]);
            }

        } else if (Auth::user()->hasRole('patient')) {
            $menus = Menu::where('user_id', $user->id)->count();
            if ($user->trial_version_status) {
                $user->expiration_date = Carbon::parse($user->createdAt)->addMonths(1);
                return view('dashboard', ['role_id' => 3, 'menus' => $menus, 'user' => $user]);
            }
            if (!$user->trial_version_status && $user->subscription_status) {
                $user_data = User::where('users.id', $user->id)
                    ->leftJoin('payments as p', 'p.user_id', '=', 'users.id')
                    ->where('p.active', 1)
                    ->join('patients as pa', 'pa.user_id', '=', 'users.id')
                    ->orderBy('p.id', 'desc')
                    ->first();
                return view('dashboard', ['role_id' => 3, 'menus' => $menus, 'user' => $user_data]);
            }
        } else if (Auth::user()->hasRole('admin')) {
            return view('dashboard', ['role_id' => 1, 'user' => $user]);
        }
    }
}
