<?php

namespace App\Http\Controllers;

use App\Menu;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\PasswordRequest;
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
        if(Auth::user()->hasRole('nutritionist')){
            $user = User::where('users.id', $user_id)->first();
            return view('profile.edit', ['user' => $user, 'role_id' => 2]);
        } else if(Auth::user()->hasRole('patient')) {
            $auth = Auth::user();
            $user = User::join('payments as p', 'p.user_id', '=', 'users.id')
                    ->where('users.id', $auth->id)->orderBy('p.id', 'desc')->first();
            if(!$user){
                return redirect()->route('home')->with('error', __('No tienes privilegios necesarios para acceder a Mi perfil'));
            }
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
    public function update(Request $request)
    {
        if(Auth::user()->hasRole('nutritionist')){
            $name= $request['name'];
            $last_name = $request['last_name'];
            //dd($last_name);
            $email = $request['email'];
            //dd($email);
            $password = $request['password'];
            $b_password = bcrypt($password);
            $p_l = strlen($password);
            //dd($password);
            $password_confirmation = $request['password_confirmation'];
            $p_c_l = strlen($password_confirmation);
            $compare_passwords = strcmp($password, $password_confirmation);
            //dd($password_confirmation);
            $identificator = $request['identificator'];
            //dd($identificator);
            $email_validation = User::where('email', $email)->exists();

            if( !$name){
                $msg = ['status' => 'error', 'message' => __('El nombre no puede ser un campo vacío')];
                return response()->json($msg, 400);
            }
            if( !$last_name){
                $msg = ['status' => 'error', 'message' => __('El apellido no puede ser un campo vacío')];
                return response()->json($msg, 400);
            }
            if( !$email){
                $msg = ['status' => 'error', 'message' => __('El correo no puede ser un campo vacío')];
                return response()->json($msg, 400);
            }
            if($email_validation && $email != Auth::user()->email) {
                $msg = ['status' => 'error', 'message' => __('El correo proporcionado ya existe en nuestros registros')];
                return response()->json($msg, 400);
            }
            if( $password && $password_confirmation ){
                if( $password =! $password_confirmation ){
                    $msg = ['status' => 'error', 'message' => __('Las contraseñas no coinciden')];
                    return response()->json($msg, 400);    
                }
                if( $p_l < 8 || $p_c_l < 8){
                    $msg = ['status' => 'error', 'message' => __('Las contraseñas deben de ser de al menos 8 caracteres')];
                    return response()->json($msg, 400);    
                }
            }
            
            if($p_l > 7 && $p_c_l > 7){
                try {
                    /* update nutritionist profile first if new password exists else with no new password */
                    
                    DB::beginTransaction();
                    $user = User::where('id', Auth::user()->id)->first();
                        $user->name = $name;
                        $user->last_name = $last_name;
                        $user->email = $email;
                        $user->password = $b_password;
                        $user->identificator = $identificator;
                        $user->save();
                        DB::commit();
                        $msg = ['status' => 'success', 'message' => __('Datos1 actualizados correctamente') ];
                        return response()->json($msg);                    
                    } catch(\Illuminate\Database\QueryException $ex){
                    DB::rollback();
                    //dd($ex);
                    $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage() ];
                    return response()->json($msg, 400);
                    }
                    catch(\Exception $ex){
                        DB::rollback();
                        $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage() ];
                        return response()->json($msg, 400);
                    }
            } else {
                try {
                    
                    DB::beginTransaction();
                    $user = User::where('id', Auth::user()->id)->first();
                        $user->name = $name;
                        $user->last_name = $last_name;
                        $user->email = $email;
                        $user->identificator = $identificator;
                        $user->save();
                        DB::commit();
                        $msg = ['status' => 'success', 'message' => __('Datos2 actualizados correctamente') ];
                        return response()->json($msg);                    
                    } catch(\Illuminate\Database\QueryException $ex){
                    DB::rollback();
                    //dd($ex);
                    $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage() ];
                    return response()->json($msg, 400);
                    }
                    catch(\Exception $ex){
                        DB::rollback();
                        $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage() ];
                        return response()->json($msg, 400);
                    }
            }
            
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
