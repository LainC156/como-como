<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegisterMail as RegisterMail;
use App\Nutritionist;
use App\Patient;
use App\Providers\RouteServiceProvider;
use App\Role as Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new pendig_user instance before a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function register(Request $request)
    {
        if (request()->ajax()) {
            $message = '';
            $name = $request['name'];
            $last_name = $request['last_name'];
            $id = $request['id'];
            $email = $request['email'];
            $password = $request['password'];
            $password_confirmation = $request['password_confirmation'];
            $account_type = $request['account_type'];

            /* email */
            if (User::where('email', $email)->exists()) {
                $message = __('El correo proporcionado ya está en nuestros registros');
                return response()->json(['status' => 'error', 'message' => $message]);
            }
            /* curp */
            if ($id && User::where('identificator', $id)->exists()) {
                $message = __('CURP/ID proporcionada ya está en nuestros registros');
                return response()->json(['status' => 'error', 'message' => $message]);
            }
            /* password and password confirmation */
            if (strlen($password) <= 7) {
                $message = __('La contraseña debe tener al menos 8 caracteres');
                return response()->json(['status' => 'error', 'message' => $message]);
            }
            if (strlen($password_confirmation) <= 7) {
                $message = __('La confirmación de contraseña debe tener al menos 8 caracteres');
                return response()->json(['status' => 'error', 'message' => $message]);
            }
            if ($password !== $password_confirmation) {
                $message = __('Las contraseñas no coinciden, verifica tu información');
                return response()->json(['status' => 'error', 'message' => $message]);
            }
            /* name */
            if (strlen($name) === '') {
                $message = __('El campo nombre es requerido');
                return response()->json(['status' => 'error', 'message' => $message]);
            }
            /* last name */
            if (strlen($last_name) === '') {
                $message = __('El campo apellidos es requerido');
                return response()->json(['status' => 'error', 'message' => $message]);
            }
            /* token to activate account */
            $token = bin2hex(random_bytes(70));
            /* save in pending_users table */
            try {
                DB::beginTransaction();
                DB::table('pending_users')->insert([
                    'name' => $name,
                    'last_name' => $last_name,
                    'identificator' => $id,
                    'email' => $email,
                    'password' => bcrypt($password),
                    'account_type' => $account_type,
                    'token' => $token,
                ]);
                /* email to activate account */
                $registerObj = new \StdClass();
                $registerObj->token = $token;
                $registerObj->name = $name . " " . $last_name;
                $registerObj->password = $password;
                Mail::to($email)->send(new RegisterMail($registerObj));
                DB::commit();
                $message = __('Cuenta creada correctamente, verifica tu cuenta de correo para activar tu cuenta');
                return response()->json(['status' => 'success', 'message' => $message]);
            } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollback();
                $message = __('Ocurrió un error, vuelve a intentarlo recargando la página');
                return response()->json(['status' => 'error', 'message' => $message, 'exception' => $ex->getMessage()]);
            } catch (\Exception $ex) {
                DB::rollback();
                $message = __('Ocurrió un error, vuelve a intentarlo recargando la página');
                return response()->json(['status' => 'error', 'message' => $message, 'exception' => $ex->getMessage()]);
            }
        }
    }
    /**
     * Create a new user instance after a valid activation.
     * account_type: 3 = patient, 2 = nutritionist
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function confirmRegister($token)
    {
        $pending_user = DB::table('pending_users')
            ->where('token', $token)
            ->where('status', 0)
            ->first();

        if (!$pending_user) {
            return redirect()->route('login')->with('error', __('Esta cuenta ya ha sido activada anteriormente'));
        }
        $patient_role = Role::findOrFail(3);
        $nutritionist_role = Role::findOrFail(2);
        $message = '';
        try {
            DB::beginTransaction();
            $user = new User;
            $user->name = $pending_user->name;
            $user->last_name = $pending_user->last_name;
            $user->identificator = $pending_user->identificator;
            $user->email = $pending_user->email;
            $user->email_verified_at = Carbon::now();
            $user->password = $pending_user->password;
            $user->account_type = $pending_user->account_type;
            /* patient created by nutritionist */
            if ($pending_user->nutritionist_id) {
                $user->subscription_status = 1;
                $user->trial_version_status = 0;
            }
            $user->save();
            /* create relation user-patient */
            if ($pending_user->account_type == 3) {
                $patient = new Patient;
                $patient->id = $user->id;
                $patient->user_id = $user->id;
                $patient->height = $pending_user->height;
                $patient->weight = $pending_user->weight;
                $patient->birthdate = $pending_user->birthdate;
                $patient->nutritionist_id = $pending_user->nutritionist_id;
                $patient->genre = $pending_user->genre;
                $patient->psychical_activity = $pending_user->psychical_activity;
                $patient->caloric_requirement = $pending_user->caloric_requirement;
                $patient->waist_size = $user->pending_waist_size;
                $patient->legs_size = $user->pending_legs_size;
                $patient->wrist_size = $user->pending_wrist_size;
                $patient->save();
                $user->roles()->attach($patient_role);
                $user->update();
            }
            /* create relation user-nutritionist */
            if ($pending_user->account_type == 2) {
                $nutritionist = new Nutritionist;
                $nutritionist->id = $user->id;
                $nutritionist->user_id = $user->id;
                $nutritionist->save();
                $user->roles()->attach($nutritionist_role);
                $user->update();
            }
            /* updating info un pending_users table status = true (activated account) */
            DB::table('pending_users')
                ->where('token', '=', $pending_user->token)
                ->update(['status' => true,
                    'email_verified_at' => Carbon::now(),
                ]);

            DB::commit();

            return redirect()->route('login')->with('success', __('Cuenta activada correctamente'));

        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return redirect()->route('login')->with('error', __('Ocurrió un error, vuelve a intentarlo'));
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('login')->with('error', __('Ocurrió un error, vuelve a intentarlo'));
        }
    }
}
