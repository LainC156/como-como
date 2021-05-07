<?php

namespace App\Http\Middleware;

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
        $data = User::where('users.id', $user->id)
            ->join('payments as p', 'p.user_id', '=', 'users.id')
            ->where('trial_status', 1)
            ->orWhere('active', 1)
            ->select('p.trial_status', 'p.active', 'p.id', 'users.id as user_id', 'p.expiration_date')
            ->orderBy('p.id', 'asc')->first();
        //dd($data);
        if ($user->hasRole('patient') || $user->hasRole('nutritionist')) {
            if ($data) {
                if ($data->trial_status == 1 || $data->active == 1) {
                    if (Carbon::parse($data->expiration_date)->lessThan(Carbon::now())) {
                        /* update database and the redirect to /subscription route */
                        try {
                            DB::beginTransaction();
                            DB::table('payments')
                                ->where('payments.id', $data->id)
                                ->update([
                                    'trial_status' => 0,
                                    'active' => 0,
                                ]);
                            DB::table('users')
                                ->where('id', $data->user_id)
                                ->update([
                                    'subscription_status' => 0,
                                    'trial_version_status' => 0,
                                ]);
                            DB::commit();
                            return redirect()->route('payment.index')->with('error', __('Tu suscripción ha caducado, te recomendamos hacer el pago correspondiente para poder seguir disfrutando del sistema'));
                        } catch (\Illuminate\Database\QueryException $ex) {
                            DB::rollback();
                            $message = __('Ocurrió un error, vuelve a intentarlo');
                            return response()->json(['status' => 'error', 'message' => $message, 'exception' => $ex->getMessage()]);
                        } catch (\Exception $ex) {
                            DB::rollback();
                            $message = __('Ocurrió un error, vuelve a intentarlo');
                            return response()->json(['status' => 'error', 'message' => $message, 'exception' => $ex->getMessage()]);
                        }
                    }
                }
            } else {
                $data = User::where('users.id', $user->id)
                    ->join('payments as p', 'p.user_id', '=', 'users.id')
                    ->where('trial_status', 0)
                    ->where('active', 0)
                    ->orderBy('p.id', 'asc')->first();
                if ($data) {
                    return redirect()->route('payment.index')->with('error', __('Tu suscripción ha caducado, te recomendamos hacer el pago correspondiente para poder seguir disfrutando del sistema'));
                }
            }
        }
        return $next($request);
    }
}
