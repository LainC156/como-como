<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\RegisterMail as RegisterMail;
use App\Patient;
use App\User;
use App\Role;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        if( Auth::user()->hasRole('nutritionist')) {
            //$auth = Auth::user();

            $user=  User::where('users.id', auth()->id())
                    ->join('payments as p','p.user_id', '=', 'users.id')
                    ->first();
            //dd($user);
            $patients = Patient::where('nutritionist_id', auth()->id())
                        ->join('users as u', 'u.id', '=', 'patients.user_id')
                        ->get();
            //dd($patients);
            $role_id = 2;
        }
        return view('users.index', ['user' => $user,'patients' => $patients, 'role_id' => $role_id]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if( Auth::user()->hasRole('nutritionist')) {
            $user = Auth::user()
                    ->join('payments as p','p.user_id', '=', 'users.id')
                    ->first();
            $role_id = 2;
        }
        return view('users.create', ['user' => $user, 'role_id' => $role_id]);
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
                $name = $request['name'];
                $last_name = $request['last_name'];
                $identificator = $request['identificator'];
                $email = $request['email'];
                $password = $request['password'];
                $password_confirmation = $request['password_confirmation'];
                $weight = $request['weight'];
                $height = $request['height'];
                $birthdate = $request['birthdate'];
                $genre = $request['genre'];
                $psychical_activity = $request['psychical_activity'];
                $waist_size = $request['waist_size'];
                $legs_size = $request['legs_size'];
                $wrist_size = $request['wrist_size'];
                if( $request['automatic_calculation'] == 1) {
                    $caloric_requirement = $this->getCaloricRequirement($weight, $height, $birthdate, $genre, $psychical_activity);
                } else if( $request['automatic_calculation'] == 0){
                    $caloric_requirement = $request['caloric_requirement'];
                }

                if( $password != $password_confirmation ) {
                    return response()->json( ['status' => 'error', 'message' => __('Las contraseñas no coinciden, verifica la información')] );
                }
                /* token to activate account */
                $token = bin2hex(random_bytes(70));
                try {
                    DB::beginTransaction();
                    DB::table('pending_users')->insert([
                        'name' => $name,
                        'last_name' => $last_name,
                        'birthdate' => $birthdate,
                        'identificator' => $identificator,
                        'email' => $email,
                        'password' => bcrypt($password),
                        'account_type' => 3,
                        'nutritionist_id' => Auth::user()->id,
                        'weight' => $weight,
                        'height' => $height,
                        'genre' => $genre,
                        'psychical_activity' => $psychical_activity,
                        'caloric_requirement' => $caloric_requirement,
                        'waist_size' => $waist_size,
                        'legs_size' => $legs_size,
                        'wrist_size' => $wrist_size,
                        'token' => $token,
                    ]);
                    /* email to activate account */
                    $registerObj = new \StdClass();
                    $registerObj->token = $token;
                    $registerObj->name = $name." ".$last_name;
                    $registerObj->password = $password;
                    Mail::to($email)->send(new RegisterMail($registerObj));
                    DB::commit();
                    return response()->json(['status' => 'success', 'message' => __('El paciente debe activar la cuenta para poder visualizar su perfil en el sistema')]);
                }catch(\Illuminate\Database\QueryException $ex){
                    DB::rollback();
                    $message = __('Ocurrió un error, vuelve a intentarlo');
                    dd($ex);
                    return response()->json(['status' => 'error', 'message' => $message, 'exception' => $ex->getMessage()]);
                }
                catch(\Exception $ex){
                    DB::rollback();
                    $message = __('Ocurrió un error, vuelve a intentarlo');
                    dd($ex);
                    return response()->json(['status' => 'error', 'message' => $message, 'exception' => $ex->getMessage()]);
                }
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if( Auth::user()->hasRole('nutritionist')) {
            $patient = User::where('users.id', $id)
                        ->join('patients as p', 'p.user_id', '=', 'users.id')
                        ->first();
                        if(!$patient) {
                            abort(404);
                        }
            $role_id = 2;
            return view('users.edit', ['patient' => $patient, 'role_id' => $role_id]);
        }
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        if(Auth::user()->hasRole('nutritionist') || Auth::user()->hasRole('patient')){
            $patient_id = $request['patient_id'];
            $name = $request['name'];
            $last_name = $request['last_name'];
            $identificator = $request['identificator'];
            $email = $request['email'];
            $password = $request['password'];
            $password_confirmation = $request['password_confirmation'];
            $weight = $request['weight'];
            $height = $request['height'];
            $birthdate = $request['birthdate'];
            $genre = $request['genre'];
            $psychical_activity = $request['psychical_activity'];
            $waist_size = $request['waist_size'];
            $legs_size = $request['legs_size'];
            $wrist_size = $request['wrist_size'];

            /* validate changes in password */
            if( $request['automatic_calculation'] == 1) {
                $caloric_requirement = $this->getCaloricRequirement($weight, $height, $birthdate, $genre, $psychical_activity);
            } else if( $request['automatic_calculation'] == 0){
                $caloric_requirement = $request['caloric_requirement'];
            }

            if( $password != $password_confirmation ) {
                return response()->json( ['status' => 'error', 'message' => __('Las contraseñas no coinciden, verifica la información')] );
            }

            try {
                DB::beginTransaction();
                $user = User::where('id', $patient_id)->first();
                $user->name = $name;
                $user->last_name = $last_name;
                $user->identificator = $identificator;
                $user->email = $email;
                if($password){
                    $user->password = bcrypt($password);
                }
                $user->save();

                Patient::where('user_id', $patient_id)
                ->update([
                    'weight' => $weight,
                    'height' => $height,
                    'birthdate' => $birthdate,
                    'genre' => $genre,
                    'psychical_activity' => $psychical_activity,
                    'caloric_requirement' => $caloric_requirement,
                    'waist_size' => $waist_size,
                    'legs_size' => $legs_size,
                    'wrist_size' => $wrist_size
                ]);
                DB::commit();
                return response()->json(['status' => 'success', 'message' => __('Datos actualizados correctamente, la página se actualizará automáticamente')]);
            }catch(\Illuminate\Database\QueryException $ex){
                DB::rollback();
                $message = __('Ocurrió un error, vuelve a intentarlo');
                return response()->json(['status' => 'error', 'message' => $message, 'exception' => $ex->getMessage()]);
            }
            catch(\Exception $ex){
                DB::rollback();
                $message = __('Ocurrió un error, vuelve a intentarlo');
                //dd($ex);
                return response()->json(['status' => 'error', 'message' => $message, 'exception' => $ex->getMessage()]);
            }
        }

    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if( Auth::user() ){
            try {
                DB::beginTransaction();
                User::where('id', $id)->delete();
                DB::commit();
                return redirect()->route('user.index')->with('success', __('Usuario borrado con éxito'));
            }catch(\Illuminate\Database\QueryException $ex){
                DB::rollback();
                return redirect()->route('user.index')->with('error', __('Ocurrió un error, vuelve a intentarlo'));
            }
            catch(\Exception $ex){
                DB::rollback();
                return redirect()->route('user.index')->with('error', __('Ocurrió un error, vuelve a intentarlo'));
            }

        }
    }

    /**
     * Update avatar image profile
     *
     */
    public function updateAvatar(Request $request, $id) {
        if(Auth::user()->hasRole('nutritionist') || Auth::user()->hasRole('patient')){
            /* validate image width, height */
            $val = $this->validate($request, [
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,dimensions:max_width:700,max_height:500'
            ]);
            // if($request->hasFile('avatar')){
            //     dd($request['patient_id']);
            // }
            if(!$val){
                return response()->json(['status' => 'error', 'message' => __('El archivo seleccionado no es válido, prueba con una imagen de 700x500 pixeles máximo')]);
            }
            $user = User::find($id);
            $avatarName = $user->id.'_avatar.'.request()->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('img/avatar', $avatarName);
            try {
                DB::beginTransaction();
                $user->avatar = $avatarName;
                $user->save();
                DB::commit();
                return response()->json(['status' => 'success', 'message' => __('Foto de perfil actualizada correctamente')]);
            }catch(\Illuminate\Database\QueryException $ex){
                DB::rollback();
                $message = __('Ocurrió un error, vuelve a intentarlo');
                return response()->json(['status' => 'error', 'message' => $message, 'exception' => $ex->getMessage()]);
            }
            catch(\Exception $ex){
                DB::rollback();
                $message = __('Ocurrió un error, vuelve a intentarlo2');
                return response()->json(['status' => 'error', 'message' => $message, 'exception' => $ex->getMessage()]);
            }

        }
    }

    /**
     * Calculate caloric requirement
     * genre: 0 = man, 1 = woman
     * psychical activity: 0 = rest, 1 = light, 2 = moderate, 3 = intense
     *
     * Gasto Energético Basal (GEB):
     * GEB_mujeres = (10 * peso) + (6.25 * estatura) - (5 * edad) - 161
     * GEB_hombres = (10 * peso) + (6.25 * estatura) - (5 * edad) + 5
     * Efecto termógeno de los alimentos (ETA):
     *    ETA = GEB * 0.10
     * factor de actividad física (FAF):
     * Actividad física | FAF(Femenino) | FAF(Masculino)
     *           Sedentario  |    0          |     0
     *      Actividad ligera|    0.12       |    0.14
     *  Actividad moderada  |    0.27       |    0.27
     *  Actividad intensa   |    0.54       |    0.54
     *
     * gasto por actividad física (GAF):
     * GAF = GEB * FAF
     * GAST ENERGÉTICO TOTAL (GET):
     * GET = ETA + GAF;
     */
    public function getCaloricRequirement($weight, $height, $birthdate, $genre, $psychical_activity) {
        /* calculate age with birthdate */
        $age = Carbon::parse($birthdate)->age;
        /* genre: WOMAN = 1, MAN = 0*/
        if( $genre == 1) $dif = -161;
        else $dif = 5;
        //$dif = ($genre == 1) : -161 ? 5;
        $GEB = (10 * $weight) + (6.25 * $height) - (5 * $age) + $dif;
        $ETA = $GEB * 0.10;
        switch ( $psychical_activity ) {
            case '0':
                $FAF = 0;
                break;
            case '1':
                if($genre == 0){
                    $FAF = 0.14;
                } else if($genre == 1){
                    $FAF = 0.12;
                }
                break;
            case '2':
                $FAF = 0.27;
                break;
            case '3':
                $FAF = 0.54;
                break;

            default:
                $FAF = 0;
                break;
        }
        $GAF = $GEB * $FAF;
        $GET = $GEB + $ETA + $GAF;

        return $GET;
    }
}
