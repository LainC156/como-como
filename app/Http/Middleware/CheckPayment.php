<?php

namespace App\Http\Middleware;

use App\Payment;
use App\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\DB;

class CheckPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if ($user->hasRole('patient') || $user->hasRole('nutritionist')) {
            /* check if trial status is not valid */
            if ($user->trial_version_status === true && !Carbon::parse($user->created_at)->lessThan(Carbon::now())) {
                try {
                    DB::beginTransaction();
                    $user->trial_version_status = 0;
                    $user->updated_at = Carbon::now();
                    $user->save();
                    DB::commit();
                    return redirect()->route('payment.index')->with('error', __('Tu versión de prueba ha caducado, te recomendamos hacer el pago correspondiente para poder seguir disfrutando del sistema'));
                } catch (\Illuminate\Database\QueryException $ex) {
                    DB::rollback();
                    $message = __('Ocurrió un error, contacta al administrador para mayor información');
                    return redirect()->route('payment.index')->with('error', $message);
                } catch (\Exception $ex) {
                    DB::rollback();
                    $message = __('Ocurrió un error, contacta al administrador para mayor información');
                    return redirect()->route('payment.index')->with('error', $message);
                }
            }
            /* check if subscription status is not valid */
            $data = User::where('users.id', $user->id)
                ->leftJoin('payments as p', 'p.user_id', '=', 'users.id')
            //->select('p.trial_status', 'p.active', 'p.id', 'users.id as user_id', 'p.expiration_date')
                ->where('active', 1)
                ->orderBy('p.id', 'desc')->first();
            if ($user->subscription_status === true && Carbon::now()->greaterThan(Carbon::parse($data->expiration_date))) {
                /* check if user has role patient */
                /* check if patient was not created by some nutritionist(patients created by nutritionist has no check payment middleware) */
                $patient = User::where('users.id', $user->id)
                    ->join('patients as p', 'p.user_id', '=', 'users.id')
                    ->first();
                if ($patient && !$patient->nutritionist_id) {
                    try {
                        DB::beginTransaction();
                        /* update user subscription status */
                        $user->subscription_status = 0;
                        $user->updated_at = Carbon::now();
                        $user->save();
                        /* update user payment status */
                        Payment::where('expiration_date', $data->expiration_date)
                            ->where('user_id', $user->id)
                            ->update([
                                'active' => 0,
                                'updated_at' => Carbon::now(),
                            ]);
                        DB::commit();
                        return redirect()->route('payment.index')->with('error', __('Tu suscripción mensual ha caducado, te recomendamos hacer el pago correspondiente para poder seguir disfrutando del sistema'));
                    } catch (\Illuminate\Database\QueryException $ex) {
                        DB::rollback();
                        $message = __('Ocurrió un error, contacta al administrador para mayor información');
                        return redirect()->route('payment.index')->with('error', $message);
                    } catch (\Exception $ex) {
                        DB::rollback();
                        $message = __('Ocurrió un error, contacta al administrador para mayor información');
                        return redirect()->route('payment.index')->with('error', $message);
                    }
                }
                $nutritionist = User::where('users.id', $user->id)
                    ->join('nutritionists as n', 'n.user_id', '=', 'users.id')
                    ->first();
                /* check if account belongs to an nutritionist */
                if ($nutritionist) {
                    try {
                        DB::beginTransaction();
                        /* update user subscription status */
                        $user->subscription_status = 0;
                        $user->updated_at = Carbon::now();
                        $user->save();
                        /* update user payment status */
                        Payment::where('expiration_date', $data->expiration_date)
                            ->where('user_id', $user->id)
                            ->update([
                                'active' => 0,
                                'updated_at' => Carbon::now(),
                            ]);
                        DB::commit();
                        return redirect()->route('payment.index')->with('error', __('Tu suscripción mensual ha caducado, te recomendamos hacer el pago correspondiente para poder seguir disfrutando del sistema'));
                    } catch (\Illuminate\Database\QueryException $ex) {
                        DB::rollback();
                        $message = __('Ocurrió un error, contacta al administrador para mayor información');
                        return redirect()->route('payment.index')->with('error', $message);
                    } catch (\Exception $ex) {
                        DB::rollback();
                        $message = __('Ocurrió un error, contacta al administrador para mayor información');
                        return redirect()->route('payment.index')->with('error', $message);
                    }
                }
            }
        }
        return $next($request);
    }
}
