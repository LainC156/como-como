<?php

namespace App\Http\Controllers;

use App\Menu;
use App\User;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit($user_id)
    {
        if(Auth::user()->hasRole('nutritionist')){
            $user = User::where('users.id', $user_id)->first();
            return view('profile.edit', ['user' => $user, 'role_id' => 2]);
        } else if(Auth::user()->hasRole('patient')) {
            $menus = Menu::where('user_id', $user_id)->count();
            $user = User::where('users.id', $user_id)
                        ->join('patients as p', 'p.user_id', '=', 'users.id')->first();
            return view('profile.edit', ['user' => $user, 'menus' => $menus, 'role_id' => 3]);
        }

    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }
}
