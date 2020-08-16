<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\ExpressCheckout;

class PaymentController extends Controller
{
    protected $provider;
    public function __construct() {
        $this->provider = new ExpressCheckout();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('nutritionist')){
            $auth = Auth::user();
            $user = User::join('payments as p', 'p.user_id', '=', 'users.id')
                    ->where('users.id', $auth->id)->first();
            $total_patients = DB::table('patients')
                    ->where('nutritionist_id', $auth->id)->count();
            if( $total_patients >= 1 && $total_patients<= 50)
                $amount_to_pay = $total_patients * 25;
            else if( $total_patients > 50 && $total_patients<= 100)
                $amount_to_pay = $total_patients * 13;
            else if( $total_patients > 100 && $total_patients<= 150)
                $amount_to_pay = $total_patients * 21;
            else if( $total_patients > 150 && $total_patients<= 200)
                $amount_to_pay = $total_patients * 19;

                return view('payments.index', ['user' => $user, 'role_id' => 2, 'total_patients' => $total_patients, 'amount_to_pay' => $amount_to_pay]);
        } else if(Auth::user()->hasRole('patient')){
            $auth = Auth::user();
            $user = User::join('payments as p', 'p.user_id', '=', 'users.id')
                    ->where('users.id', $auth->id)->first();
            $total_patients = DB::table('patients')
                    ->where('nutritionist_id', $auth->id)->count();
            $amount_to_pay = 20;
                    return view('payments.index', ['user' => $user, 'role_id' => 3, 'total_patients' => $total_patients, 'amount_to_pay' => $amount_to_pay]);
        }
    }

        /**
         * Paypal wants to make a payment
         *
         *  */
        public function getCart($recurring, $invoice_id, $price) {
            if( $recurring ) {
                return [
                    // if payment is recurring cart needs only one item
                    // with name, price and quantity
                    'items' => [
                        [
                            'name' => 'Monthly subscription (only patients)' . config('paypal.invoice_prefix') . ' # ' . $invoice_id,
                            'price' => $price,
                            'qty' => 1
                        ],
                    ],
                    // return url is the url where PayPal returns after user confirmed the payment
                    'return_url' => url('/paypal/express-checkout-success?recurring=1'),
                    'subscription_desc' => 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $invoice_id,
                    // every invoice id must be unique, else you'll get an error from paypal
                    'invoice_id' => config('paypal.invoice_prefix') . '_' . $invoice_id,
                    'invoice_description' => "Order #". $invoice_id ." Invoice",
                    'cancel_url' => url('/'),
                    // total is calculated by multiplying price with quantity of all cart items and then adding them up
                    // in this case total is 20 because price is 20 and quantity is 1
                    'total' => $price, // Total price of the cart
                ];
            }
            return [
                // if payment is not recurring cart can have many items
                // with name, price and quantity
                'items' => [
                    [
                        'name' => 'Monthly payment ',
                        'price' => $price,
                        'qty' => 1,
                    ],
                ],

                // return url is the url where PayPal returns after user confirmed the payment
                'return_url' => url('/paypal/express-checkout-success'),
                // every invoice id must be unique, else you'll get an error from paypal
                'invoice_id' => config('paypal.invoice_prefix') . '_' . $invoice_id,
                'invoice_description' => "Order #" . $invoice_id . " Invoice",
                'cancel_url' => url('/'),
                // total is calculated by multiplying price with quantity of all cart items and then adding them up
                // in this case total is 20 because Product 1 costs 10 (price 10 * quantity 1) and Product 2 costs 10 (price 5 * quantity 2)
                'total' => $price,
            ];
        }

        public function expressCheckout(Request $request) {
            if( Auth::user()->hasRole('nutritionist')) {
                /* user data */
                $user = Auth::user();
                /* count of how many patients manage this user */
                $patients = DB::table('patients')
                            ->where('nutritionist_id', $user->id)->count();
                /* calculating amout to pay */
                if( $patients >= 1 && $patients<= 50)
                $amount_to_pay = $patients * 25;
                else if( $patients > 50 && $patients<= 100)
                $amount_to_pay = $patients * 13;
                else if( $patients > 100 && $patients<= 150)
                $amount_to_pay = $patients * 21;
                else if( $patients > 150 && $patients<= 200)
                $amount_to_pay = $patients * 19;
                /* recurring(subscription) = false */
                $recurring = false;
                /* set new id in payments table */
                $invoice_id = DB::table('payments')->count() + 1;
                //dd($invoice_id);
                // create new payment row
                $payment = DB::table('payments')->insert([
                            'user_id' => $user->id,
                            'trial_status' => 0,
                            'amount' => $amount_to_pay,
                            'created_at' => Carbon::now()
                ]);

                // Get the cart data
                $cart = $this->getCart($recurring, $invoice_id, $amount_to_pay);
                //dd($cart);
                // send a request to paypal
                // paypal should respond with an array of data
                // the array should contain a link to paypal's payment system
                $response = $this->provider->setExpressCheckout($cart, $recurring);
                //dd($response);
                // if there is no link(paypal's payment system) redirect back with error message
                if (!$response['paypal_link']) {
                    DB::table('payments')->where('id', $invoice_id)->delete();
                    return redirect()->back()->with('error', __('Algo salió mal con Paypal, intenta recargar la página e intenta de nuevo'));
                    // For the actual error message dump out $response and see what's in there
                }
                // redirect to paypal
                // after payment is done paypal
                // will redirect us back to $this->expressCheckoutSuccess
                return redirect($response['paypal_link']);
                /*
                try {
                    DB::beginTransaction();
                    DB::table('payments')
                        ->insert([
                            'user_id' => $user->id,
                            'trial_status' => 0,
                            'active' => 1,
                            'amount' => $amount_to_pay,
                            'payment_method' => 'Paypal',
                            'payment_date' => Carbon::now(),
                            'created_at' => Carbon::now()
                        ]);
                    $data = [];
                    $data['items'] = [
                        [
                            'name' => 'payment_subscription',
                            'price' => $amount_to_pay,
                            'desc'  => 'pago de mensualidad',
                            'qty' => 1
                        ]
                    ];

                    $data['invoice_id'] = 1;
                    $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
                    $data['return_url'] = route('payment.success');
                    $data['cancel_url'] = route('payment.cancel');
                    $data['total'] = 100;

                    $provider = new ExpressCheckout;

                    $response = $provider->setExpressCheckout($data);

                    $response = $provider->setExpressCheckout($data, true);

                    DB::commit();
                    dd($response);
                    return redirect($response['paypal_link']);

                }
                catch(\Illuminate\Database\QueryException $ex){
                    DB::rollback();
                    $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage() ];
                    return response()->json($msg, 400);
                }
                catch(\Exception $ex){
                    DB::rollback();;
                    $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage() ];
                    return response()->json($msg, 400);
                }
                */
            }
        }

        public function expressCheckoutSuccess(Request $request) {
            if( Auth::user()->hasRole('nutritionist') ) {
                /* user data */
                $user = Auth::user();
                /* count of how many patients manage this user */
                $patients = DB::table('patients')
                            ->where('nutritionist_id', $user->id)->count();
                /* calculating amout to pay */
                if( $patients >= 1 && $patients<= 50)
                $amount_to_pay = $patients * 25;
                else if( $patients > 50 && $patients<= 100)
                $amount_to_pay = $patients * 13;
                else if( $patients > 100 && $patients<= 150)
                $amount_to_pay = $patients * 21;
                else if( $patients > 150 && $patients<= 200)
                $amount_to_pay = $patients * 19;
                // check if payment is recurring
                $recurring = false;

                $token = $request->get('token');
                $PayerID = $request->get('PayerID');
                // initaly we paypal redirects us back with a token
                // but doesn't provice us any additional data
                // so we use getExpressCheckoutDetails($token)
                // to get the payment details
                $response = $this->provider->getExpressCheckoutDetails($token);

                // if response ACK value is not SUCCESS or SUCCESSWITHWARNING
                // we return back with error
                if (!in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
                    return redirect()->back()->with(['status' => 'error', 'message' => __('Algo salió mal con Paypal, recarga la página e intenta de nuevo')]);
                }

                // invoice id is stored in INVNUM
                // because we set our invoice to be xxxx_id
                // we need to explode the string and get the second element of array
                // witch will be the id of the invoice
                $invoice_id = explode('_', $response['INVNUM'])[1];
                $invoice_id++;


                // get cart data
                $cart = $this->getCart($recurring, $invoice_id, $amount_to_pay);

                // check if our payment is recurring
                if( $recurring == true ) {
                    // if recurring then we need to create the subscription
                    //you can create monthly o yearly subscriptions
                    $response = $this->provider->createMonthlySubscription( $response['TOKEN'], $response['AMT'], $cart['subscription_desc'] );

                    $status = 'Invalid';
                    // if after creating the subscription paypal responds with activeprofile or pendingprofile
                    // we are good to go and we can set the status to Processed, else status stays Invalid
                    if ( !empty($response['PROFILESTATUS']) && in_array($response['PROFILE_STATUS'], ['ActiveProfile', 'PendingProfile'] ) ) {
                        $status = 'Processed';
                    }
                } else {
                    // if payment is not recurring just perform transaction on Paypal
                    // and get the payment status
                    $payment_status = $this->provider->doExpressCheckoutPayment( $cart, $token, $PayerID);
                    //dd($payment_status);
                    $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
                }

                // find invoice by id
                //dd($invoice_id);
                $invoice = DB::table('payments')->where('id', $invoice_id)->first();
                //dd($status);
                $invoice->payment_status = $status;
                //dd($invoice->payment_status);
                // if payment is recurring lets set a recurring id for latter use
                if( $recurring === true ) {
                    $invoice->recurring_id = $response['PROFILEID'];
                }

                // save the invoice
                try {
                    DB::beginTransaction();
                    //dd($invoice);
                    $invoice->active = 1;
                    $invoice->payment_method = 'PayPal';
                    $invoice->current_date = Carbon::now();
                    $invoice->updated_at = Carbon::now();
                    $invoice->expiration_date = Carbon::now()->addMonths(1);
                    $invoice->update();
                }
                catch(\Illuminate\Database\QueryException $ex){
                    DB::rollback();
                    $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage() ];
                    return response()->json($msg, 400);
                }
                catch(\Exception $ex){
                    DB::rollback();
                    $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage() ];
                    return response()->json($msg, 400);
                }
                finally{
                    DB::commit();
                    // App\Invoice has a active attribute that returns true or false based on payment status
                    // so if active is false return with error, else return with success message
                    if ( $invoice->active == 1 ) {
                        return redirect()->route('payment.index')->with(['session' => 'success', 'message' => __('Orden ') . $invoice->id . __(' ha sido pagada satisfactoriamente')]);
                    }
                }
                return redirect()->route('payment.index')->with(['session' => 'error', 'message' => __('Error procesando pago de Paypal para la orden ') . $invoice->id . '!']);
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
