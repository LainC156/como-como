<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Menu;
use App\Patient;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        if (Auth::user()->hasRole('nutritionist')) {
            $user = Auth::user();
            if ($user_id != $user->id) {
                abort(403);
            }
            $total_patients = Patient::where('nutritionist_id', $user->id)->count();
            return view('profile.edit', ['user' => $user, 'total_patients' => $total_patients, 'role_id' => 2]);
        } else if (Auth::user()->hasRole('patient')) {
            $user = User::join('patients as p', 'p.user_id', '=', 'users.id')
                ->where('users.id', Auth::id())->first();
            if ($user->nutritionist_id) {
                return redirect()->route('home')->with('error', __('No tienes privilegios necesarios para acceder a Mi perfil'));
            }
            if ($user_id != $user->id) {
                abort(403);
            }
            $menus = Menu::where('user_id', $user_id)->count();
            return view('profile.edit', ['user' => $user, 'menus' => $menus, 'role_id' => 3]);
        } else {
            abort(403);
        }
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $name = $request['name'];
        $last_name = $request['last_name'];
        $email = $request['email'];
        $password = $request['password'];
        $password_confirmation = $request['password_confirmation'];
        $compare_passwords = strcmp($password, $password_confirmation);
        $identificator = $request['identificator'];
        $email_validation = User::where('email', $email)->exists();

        if (!$name) {
            $msg = ['status' => 'error', 'message' => __('El nombre no puede ser un campo vacío')];
            return response()->json($msg, 400);
        }
        if (!$last_name) {
            $msg = ['status' => 'error', 'message' => __('El apellido no puede ser un campo vacío')];
            return response()->json($msg, 400);
        }
        if (!$email) {
            $msg = ['status' => 'error', 'message' => __('El correo no puede ser un campo vacío')];
            return response()->json($msg, 400);
        }
        if ($email_validation && $email != Auth::user()->email) {
            $msg = ['status' => 'error', 'message' => __('El correo proporcionado ya existe en nuestros registros')];
            return response()->json($msg, 400);
        }
        if ($password && $password_confirmation) {
            if ($password !== $password_confirmation) {
                $msg = ['status' => 'error', 'message' => __('Las contraseñas no coinciden')];
                return response()->json($msg, 400);
            }
            if (strlen($password) < 8 || strlen($password_confirmation) < 8) {
                $msg = ['status' => 'error', 'message' => __('Las contraseñas deben de ser de al menos 8 caracteres')];
                return response()->json($msg, 400);
            }
        }

        try {
            /* update nutritionist profile first if new password exists else with no new password */
            DB::beginTransaction();
            $user = User::where('id', Auth::user()->id)->first();
            $user->name = $name;
            $user->last_name = $last_name;
            $user->email = $email;
            if ($password && $password_confirmation && $password === $password_confirmation) {
                $user->password = bcrypt($password);
            }
            $user->identificator = $identificator;
            $user->save();
            DB::commit();
            $msg = ['status' => 'success', 'message' => __('Datos actualizados correctamente')];
            return response()->json($msg);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            //dd($ex);
            $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage()];
            return response()->json($msg, 400);
        } catch (\Exception $ex) {
            DB::rollback();
            $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage()];
            return response()->json($msg, 400);
        }
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
