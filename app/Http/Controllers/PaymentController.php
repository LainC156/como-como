<?php

namespace App\Http\Controllers;

use App\Payment as PM;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment as Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaymentController extends Controller
{

    private $apiContext;

    public function __construct()
    {
        $payPalConfig = Config::get('paypal');

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $payPalConfig['client_id'],
                $payPalConfig['secret']
            )
        );

        $this->apiContext->setConfig($payPalConfig['settings']);
    }

    /**
     * Payment with Paypal
     *
     */
    public function payWithPayPal()
    {
        $auth = Auth::user();
        $user = User::join('payments as p', 'p.user_id', '=', 'users.id')
            ->where('users.id', $auth->id)->first();
        if (Auth::user()->hasRole('nutritionist')) {
            $total_patients = DB::table('patients')
                ->where('nutritionist_id', $auth->id)->count();
            if ($total_patients >= 1 && $total_patients <= 50) {
                $amount_to_pay = $total_patients * 25;
            } else if ($total_patients > 50 && $total_patients <= 100) {
                $amount_to_pay = $total_patients * 23;
            } else if ($total_patients > 100 && $total_patients <= 150) {
                $amount_to_pay = $total_patients * 21;
            } else if ($total_patients > 150 && $total_patients <= 200) {
                $amount_to_pay = $total_patients * 19;
            }

        } else if (Auth::user()->hasRole('patient')) {
            $amount_to_pay = 20;
        }
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($amount_to_pay);
        $amount->setCurrency('MXN');

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $callbackUrl = url('/status');
        $redirectUrls = new redirectUrls();
        $redirectUrls->setReturnUrl($callbackUrl)
            ->setCancelUrl($callbackUrl);

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            /* saving transaction in DB */
            try {
                DB::beginTransaction();
                $data = new PM();
                $data->user_id = $auth->id;
                $data->trial_status = 0;
                $data->active = 0;
                $data->payment_status = 'pending';
                $data->payment_method = 'PayPal';
                $data->amount = $amount_to_pay;
                $data->save();
            } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollback();
                $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage()];
                return response()->json($msg, 400);
            } catch (\Exception $ex) {
                DB::rollback();
                $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage()];
                return response()->json($msg, 400);
            } finally {
                DB::commit();
            }
            return redirect()->away($payment->getApprovalLink());
            //echo"\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // exception printed for detailed information
            echo $ex->getData();
        }
    }

    /**
     * status before trying to connect to PayPal
     *
     */

    public function payPalStatus(Request $request)
    {
        $user = Auth::user();
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');
        $token = $request->input('token');

        if (!$paymentId || !$payerId || !$token) {
            return redirect('subscription')->with('error', __('Algo1 salió mal con Paypal, recarga la página e intenta de nuevo'));
        }

        $pymnt = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        /** execute the payment **/
        $result = $pymnt->execute($execution, $this->apiContext);

        if ($result->getState() === 'approved') {
            /* update transaction in DB */
            $p = PM::where('user_id', $user->id)->where('payment_status', 'pending')->orderBy('id', 'asc')->first();
            try {
                DB::beginTransaction();
                //dd($invoice);
                $p->active = 1;
                $p->payment_status = 'approved';
                $p->payment_method = 'PayPal';
                $p->current_date = Carbon::now();
                $p->updated_at = Carbon::now();
                $p->expiration_date = Carbon::now()->addMonths(1);
                $p->update();
                $user->trial_version_status = 0;
                $user->subscription_status = 1;
                $user->save();
            } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollback();
                $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage()];
                return response()->json($msg, 400);
            } catch (\Exception $ex) {
                DB::rollback();
                $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage()];
                return response()->json($msg, 400);
            } finally {
                DB::commit();
                return redirect('/subscription')->with('success', __('Pago procesado correctamente'));
            }
        }
        return redirect('/subscription')->with('error', __('Algo salió mal con Paypal, recarga la página e intenta de nuevo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('nutritionist')) {
            $auth = Auth::user();
            $user = User::join('payments as p', 'p.user_id', '=', 'users.id')
                    ->where('users.id', $auth->id)->orderBy('p.id', 'desc')->first();
            $total_patients = DB::table('patients')
                ->where('nutritionist_id', $auth->id)->count();
            if ($total_patients >= 1 && $total_patients <= 50) {
                $amount_to_pay = $total_patients * 25;
            } else if ($total_patients > 50 && $total_patients <= 100) {
                $amount_to_pay = $total_patients * 13;
            } else if ($total_patients > 100 && $total_patients <= 150) {
                $amount_to_pay = $total_patients * 21;
            } else if ($total_patients > 150 && $total_patients <= 200) {
                $amount_to_pay = $total_patients * 19;
            }

            return view('payments.index', ['user' => $user, 'role_id' => 2, 'total_patients' => $total_patients, 'amount_to_pay' => $amount_to_pay]);
        } else if (Auth::user()->hasRole('patient')) {
            $auth = Auth::user();
            $user = User::join('payments as p', 'p.user_id', '=', 'users.id')
                ->where('users.id', $auth->id)->orderBy('p.id', 'desc')->first();
            if (!$user) {
                return redirect()->route('home')->with('error', __('No tienes privilegios necesarios para acceder a Suscripción'));
            }
            $amount_to_pay = 20;
            return view('payments.index', ['user' => $user, 'role_id' => 3, 'amount_to_pay' => $amount_to_pay]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
