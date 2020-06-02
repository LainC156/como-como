<?php

namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    /**
     * List all foods in database
     *
     */
    public function foodList(){
        /* request to get all foods elements */
        if(request()->ajax())
        {
            //$data = Food::all();
            $data = DB::table('foods')->get();
            return DataTables::of($data)->make(true);
        }
    }

    /**
     * Add food to menu
     *
     */

    public function addFood(Request $request){
            $menu_id = $request['menu_id'];
            $food_id = $request['food_id'];
            $weight = $request['food_amount'];
            $kindoffood = $request['food_time_id'];
            $food_id_verification = Food::where('id', $food_id)->first();

            if(!$food_id_verification){
                $msg = ['status' => 'error', __('Este alimento no está registrado')];
                return response()->json($msg);
            }
            if($weight <= 0)    	{
                $msg= ['status' => 'error', __('La cantidad ingresada debe ser mayor que 0')];
                return response()->json($msg);
            }
            if($kindoffood == null)    	{
                $msg = ['status' => 'error', __('Debes seleccionar el tiempo')];
                return response()->json($msg);
            }
            try{
                DB::beginTransaction();
                DB::table('components')
                    ->insert(['food_id' => $food_id_verification->id, 'menu_id' => $menu_id,
                    'food_weight' => $weight, 'kind_of_food' => $kindoffood,
                    ]);
                $msg = ['status' => 'success', 'message' => __('Comida agregada correctamente')];
            }
            catch(\Illuminate\Database\QueryException $ex){
            DB::commit();
            $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage() ];
            return response()->json($msg, 400);
            }
            catch(\Exception $ex){
                DB::commit();
                $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage() ];
                return response()->json($msg, 400);
            }
            finally{
                DB::commit();
                return response()->json($msg);
            }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function edit(Food $food)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
            $component_id = $request['component_id'];
            $amount = $request['food_weight'];
            $id_food_time = $request['id_food_time'];
            try{
                DB::beginTransaction();
                DB::table('components')
                ->where('id', $component_id)
                ->update(['food_weight' => $amount,
                            'kind_of_food' => $id_food_time
                ]);
                $msg = ['status' => 'success', 'message' => __('Elemento actualizado correctamente')];
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
                return response()->json($msg);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        //
    }
}
