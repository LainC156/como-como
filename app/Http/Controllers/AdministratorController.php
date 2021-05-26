<?php

namespace App\Http\Controllers;

use App\Administrator;
use App\Payment;
use App\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patients()
    {
        if (Auth::user()->hasRole('admin')) {
            if (request()->ajax()) {
                $patients = User::join('patients as p', 'p.user_id', '=', 'users.id')
                    ->leftJoin('payments as pa', 'pa.user_id', '=', 'users.id')
                    //->where('pa.active', 1)
                    ->select('users.*', 'pa.current_date', 'pa.expiration_date')
                    ->where('p.nutritionist_id', null)
                    ->get();
                return DataTables::of($patients)
                    ->addColumn('action', function ($row) {
                        return '<button class="btn btn-success btn-sm text-center" data-toggle="modal" data-target="#editUserModal"><i class="far fa-edit"></i></button>
                            <button class="btn btn-warning btn-sm text-center" data-toggle="modal" data-target="#deleteUserModal"><i class="far fa-trash-alt"></i></button>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.index', ['patients' => true, 'role_id' => 1]);
        } else {
            abort(403);
        }
    }

    public function nutritionists()
    {
        if (Auth::user()->hasRole('admin')) {
            if (request()->ajax()) {
                $nutritionists = User::join('nutritionists as n', 'n.user_id', '=', 'users.id')
                    ->leftJoin('payments as pa', 'pa.user_id', '=', 'users.id')
                    ->select('users.*', 'pa.current_date', 'pa.expiration_date')
                    ->get();
                return DataTables::of($nutritionists)
                    ->addColumn('action', function ($row) {
                        return '<button class="btn btn-success btn-sm text-center" data-toggle="modal" data-target="#editUserModal"><i class="far fa-edit"></i></button>
                            <button class="btn btn-warning btn-sm text-center" data-toggle="modal" data-target="#deleteUserModal"><i class="far fa-trash-alt"></i></button>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('admin.index', ['nutritionists' => true, 'role_id' => 1]);
        } else {
            abort(403);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function show(Administrator $administrator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function edit(Administrator $administrator)
    {
        //
    }

    /**
     * Update as admin the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $trial_version_status = $request['trial_version_status'];
        if ($trial_version_status) {
            try {
                DB::beginTransaction();
                /* first we need disable all payments */
                Payment::where('active', 1)
                    ->where('user_id', $request['user_id'])
                    ->update([
                        'active' => 0,
                        'payment_status' => 'disabled by admin',
                        'updated_at' => Carbon::now(),
                    ]);
                /* then update user trial_version_status */
                User::where('id', $request['user_id'])
                    ->update([
                        'trial_version_status' => true,
                        'subscription_status' => false,
                        'created_at' => Carbon::now()
                    ]);
                DB::commit();
                $msg = ['status' => 'success', 'message' => __('Se actualizó a la versión de prueba del usuario')];
                return response()->json($msg);
            } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollback();
                $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage()];
                return response()->json($msg, 400);
            } catch (\Exception $ex) {
                DB::rollback();
                $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage()];
                return response()->json($msg, 400);
            }
        } else {
            try {
                DB::beginTransaction();
                /* first we need create new payment, 
                if active payment exists only update dates  
                else we need to create new payment
                */
                $payment = Payment::where('active', 1)
                    ->where('user_id', $request['user_id'])
                    ->first();
                if($payment) {
                    $payment->current_date = $request['current_date'];
                    $payment->expiration_date = $request['expiration_date'];
                    $payment->payment_status = 'updated by admin';
                    $payment->payment_method = 'updated by admin';
                    $payment->update();
                    User::where('id', $request['user_id'])
                        ->update([
                            'trial_version_status' => false,
                            'subscription_status' => true
                        ]);
                } else {
                    $new_payment = new Payment();
                    $new_payment->user_id = $request['user_id'];
                    $new_payment->active = 1;
                    $new_payment->payment_status = 'created by admin';
                    $new_payment->payment_method = 'created by admin';
                    $new_payment->current_date = $request['current_date'];
                    $new_payment->expiration_date = $request['expiration_date'];
                    $new_payment->created_at = Carbon::now();
                    $new_payment->updated_at = Carbon::now();
                    $new_payment->save();
                    User::where('id', $request['user_id'])
                    ->update([
                        'trial_version_status' => false,
                        'subscription_status' => true,
                        'updated_at' => Carbon::now()
                    ]);
                }
                /* then update user trial_version_status */
                DB::commit();
                $msg = ['status' => 'success', 'message' => __('Se actualizó a la versión de pago del usuario')];
                return response()->json($msg);
            } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollback();
                $msg = ['status' => 'error', 'message' => __('Ocurrió un error, las fechas deben tener un formato válido'), 'exception' => $ex->getMessage()];
                return response()->json($msg, 400);
            } catch (\Exception $ex) {
                DB::rollback();
                $msg = ['status' => 'error', 'message' => __('Ocurrió un error, las fechas deben tener un formato válido'), 'exception' => $ex->getMessage()];
                return response()->json($msg, 400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Administrator $administrator)
    {
        //
    }
}
