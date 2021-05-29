<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Patient;
use App\Payment;
use App\User;
use Auth;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            if (request()->ajax()) {
                $coupons = Coupon::all();
                return DataTables::of($coupons)
                    ->make(true);
            }
            $coupons = Coupon::where('user_id', null)->where('used', false)
                ->select('name', 'description', 'identificator', DB::raw('count(*) as total'))
                ->groupBy('name', 'description', 'identificator')
                ->get();
            $nutritionists = User::join('nutritionists as n', 'n.user_id', '=', 'users.id')
                ->get();
            $patients = User::where('nutritionist_id', null)
                ->join('patients as p', 'p.user_id', '=', 'users.id')
                ->get();
            //dd($coupons);
            return view('coupons.index', ['role_id' => 1, 'coupons' => $coupons, 'nutritionists' => $nutritionists, 'patients' => $patients]);
        } else if (Auth::user()->hasRole('nutritionist')) {
            return view('coupons.index', ['role_id' => 2]);
        } else if (Auth::user()->hasRole('patient')) {
            $patient = Patient::where('user_id', auth()->user()->id)->first();
            if ($patient->nutritionist_id !== null) {
                return redirect()->route('home')->with('error', __('No tienes privilegios necesarios para acceder a Cupones'));
            }
            return view('coupons.index', ['role_id' => 3]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request['name'];
        $description = $request['description'];
        $amount = $request['amount'];
        $days = $request['days'];
        $identificator = (string) Str::random(7);
        try {
            DB::beginTransaction();
            for ($i = 0; $i < $amount; $i++) {
                Coupon::create([
                    'name' => $name,
                    'description' => $description,
                    'code' => (string) Str::random(7),
                    'days' => $days,
                    'identificator' => $identificator,
                ]);
            }
            DB::commit();
            $msg = ['status' => 'success', 'message' => __('Cupones creados correctamente')];
            return response()->json($msg);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            //$msg = ;
            return response()->json(['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage()], 400);
        } catch (\Exception $ex) {
            DB::rollback();
            //$msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage()];
            return response()->json(['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        //
    }

    /**
     * Send coupon via email
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $i = 0;
        $coupon = (object) $request['coupon'];
        $coupons = Coupon::where('identificator', $coupon->id)->get();
        $users = $request['users'];
        /* send coupon to user */
        try {
            DB::beginTransaction();
            foreach ($users as $user) {
                $user = (object) $user;
                Mail::send('emails.sendCoupon', ['user' => $user, 'coupon' => $coupons[$i]], function ($mail) use ($user) {
                    $mail->from('comocomo@mail.com');
                    $mail->to($user->email);
                    $mail->subject(__('Cupón de promoción'));
                });
                Coupon::where('id', $coupons[$i]->id)->update([
                    'user_id' => $user->id,
                    'updated_at' => Carbon::now(),
                ]);
                $i++;
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $message = __('Ocurrió un error, vuelve a intentarlo recargando la página');
            return response()->json(['status' => 'error', 'message' => $message, 'exception' => $ex->getMessage()]);
        } catch (\Exception $ex) {
            DB::rollback();
            $message = __('Ocurrió un error, vuelve a intentarlo recargando la página');
            return response()->json(['status' => 'error', 'message' => $message, 'exception' => $ex->getMessage()]);
        } finally {
            DB::commit();
            $message = __('Cupones enviados correctamente, recarga la página actual para actualizar los datos');
            return response()->json(['status' => 'success', 'message' => $message]);
        }
    }

    public function activate($coupon_code)
    {
        try {
            $coupon = Coupon::where('code', $coupon_code)->where('user_id', auth()->user()->id)->first();
            if (!$coupon) {
                $message = __('Este cupón no existe, contacta al administrador para mayor información');
                return redirect()->route('home')->with('error', $message);
            }
            if ($coupon->used) {
                $message = __('Este cupón no es válido, ya ha sido activado anteriormente');
                return redirect()->route('home')->with('error', $message);
            }
            DB::beginTransaction();
            $coupon->used = true;
            $coupon->update();
            /* update user subscription */
            $user = User::where('id', auth()->user()->id)->first();
            $user->trial_version_status = false;
            $user->subscription_status = true;
            $user->update();
            /* check payments, disable actual payment(if exists), then create new payment */
            $p = Payment::where('user_id', auth()->user()->id)
                ->where('active', 1)->first();
            if ($p) {
                $p->active = 0;
                $p->payment_status = 'disabled by coupon';
                $p->update();
            }
            Payment::create([
                'user_id' => auth()->user()->id,
                'active' => 1,
                'payment_status' => 'approved',
                'amount' => 0,
                'payment_method' => 'promotional_code',
                'current_date' => Carbon::now(),
                'expiration_date' => Carbon::now()->addDays($coupon->days),
            ]);
            DB::commit();
            $message = __('Cupón activado correctamente');
            return redirect()->route('home')->with('success', $message);

        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $message = __('Ocurrió un error, vuelve a intentarlo');
            return redirect()->route('home')->with('error', $message);
        } catch (\Exception $ex) {
            DB::rollback();
            $message = __('Ocurrió un error, vuelve a intentarlo');
            return redirect()->route('home')->with('error', $message);
        }
    }
}
