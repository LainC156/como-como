<?php

namespace App\Http\Controllers;

use App\Food;
use Carbon\Carbon;
use DB;
use DataTables;
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
     * Update menu component(food in specified menu)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $component_id = $request['component_id'];
        $amount = $request['food_amount'];
        $id_food_time = $request['food_time_id'];
        try{
            DB::beginTransaction();
            DB::table('components')
            ->where('id', $component_id)
            ->update(['food_weight' => $amount,
                        'kind_of_food' => $id_food_time,
                        'updated_at' => Carbon::now()
            ]);
            $msg = ['status' => 'success', 'message' => __('Componente actualizado correctamente')];
            DB::commit();
            return response()->json($msg);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $component_id = $request['component_id'];
        try{
            DB::beginTransaction();
            DB::table('components')
                    ->where('id', $component_id)
                    ->delete();
            $msg = ['status' => 'success', 'message' => __('Elemento borrado correctamente')];
            DB::commit();
            return response()->json($msg);
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
    }
    public function sendData($msg, $foods) {
        $data = [$msg, $foods];
        return response()->json($data);
    }

    public function foodsWithMoreNutrients($id, $menu_id) {
        $exc = DB::table('menus as m')
                ->join('components as c', 'c.menu_id', '=', 'm.id')
                ->join('foods as f', 'f.id', '=', 'c.food_id')
                ->limit(10);
        switch ($id) {
            /* MACRONUTRIENTS */
            /* carbohydrates */
            case 'carbDef':
                $msg = __('Alimentos con mayor cantidad de carbohidratos');
                $foods = Food::select('name', 'carbohydrates as amount')->orderByDesc('carbohydrates')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            case 'carbExc':
                $msg = __('Alimentos con mayor cantidad de carbohidratos en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.carbohydrates as amount')->orderByDesc('f.carbohydrates')->get();
                return $this->sendData($msg, $foods);
            break;
            /* proteins */
            case 'protDef':
                $msg = __('Alimentos con mayor cantidad de proteínas');
                $foods = Food::select('name', 'proteins as amount')->orderByDesc('proteins')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            case 'protExc':
                $msg = __('Alimentos con mayor cantidad de proteínas en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.proteins as amount')->orderByDesc('f.proteins')->get();
                return $this->sendData($msg, $foods);
            break;
            /* lipids */
            case 'lipDef':
                $msg = __('Alimentos con mayor cantidad de lípidos');
                $foods = Food::select('name', 'total_lipids as amount')->orderByDesc('total_lipids')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            case 'lipExc':
                $msg = __('Alimentos con mayor cantidad de lípidos en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.total_lipids as amount')->orderByDesc('f.total_lipids')->get();
                return $this->sendData($msg, $foods);
            break;
            /* MICRONUTRIENTS */
            /* calcium */
            case 'calDef':
                $msg = __('Alimentos con mayor cantidad de calcio');
                $foods = Food::select('name', 'calcium as amount')->orderByDesc('calcium')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            /*
            case 'calExc':
                $msg = __('Alimentos con mayor cantidad de calcio en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.calcium as amount')->orderByDesc('f.calcium')->get();
                sendData($msg, $foods);
            break; */
            /* phosphorus */
            case 'phosDef':
                $msg = __('Alimentos con mayor cantidad de fósforo');
                $foods = Food::select('name', 'phosphorus as amount')->orderByDesc('phosphorus')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            /*
            case 'phosExc':
                $msg = __('Alimentos con mayor cantidad de fósforo en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.phosphorus as amount')->orderByDesc('f.phosphorus')->get();
                sendData($msg, $foods);
            break;
            */
            /* iron */
            case 'ironDef':
                $msg = __('Alimentos con mayor cantidad de hierro');
                $foods = Food::select('name', 'iron as amount')->orderByDesc('iron')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            /*
            case 'ironExc':
                $msg = __('Alimentos con mayor cantidad de hierro en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.iron as amount')->orderByDesc('f.iron')->get();
                sendData($msg, $foods);
            break;
            */
            /* magnesium */
            case 'magDef':
                $msg = __('Alimentos con mayor cantidad de magnesio');
                $foods = Food::select('name', 'magnesium as amount')->orderByDesc('magnesium')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            /*
            case 'magExc':
                $msg = __('Alimentos con mayor cantidad de magnesio en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.magnesium as amount')->orderByDesc('f.magnesium')->get();
                sendData($msg, $foods);
            break;
            */
            /* sodium */
            case 'sodDef':
                $msg = __('Alimentos con mayor cantidad de sodio');
                $foods = Food::select('name', 'sodium as amount')->orderByDesc('sodium')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            /*
            case 'sodExc':
                $msg = __('Alimentos con mayor cantidad de sodio en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.sodium as amount')->orderByDesc('f.sodium')->get();
                sendData($msg, $foods);
            break;
            */
            /* potassium */
            case 'potDef':
                $msg = __('Alimentos con mayor cantidad de potasio');
                $foods = Food::select('name', 'potassium as amount')->orderByDesc('potassium')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            /*
            case 'potExc':
                $msg = __('Alimentos con mayor cantidad de potasio en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.potasium as amount')->orderByDesc('f.potasium')->get();
                sendData($msg, $foods);
            break;
            */
            /* zinc */
            case 'zincDef':
                $msg = __('Alimentos con mayor cantidad de zinc');
                $foods = Food::select('name', 'zinc as amount')->orderByDesc('zinc')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            /*
            case 'zincExc':
                $msg = __('Alimentos con mayor cantidad de zinc en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.zinc as amount')->orderByDesc('f.zinc')->get();
                sendData($msg, $foods);
            break;
            */
            /* vitamin A */
            case 'vADef':
                $msg = __('Alimentos con mayor cantidad de vitamina A');
                $foods = Food::select('name', 'vitamin_a as amount')->orderByDesc('vitamin_a')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            /*
            case 'vAExc':
                $msg = __('Alimentos con mayor cantidad de vitamina A en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.vitamin_a as amount')->orderByDesc('f.vitamin_a')->get();
                sendData($msg, $foods);
            break;
            */
            /* vitamin B1 */
            case 'vB1Def':
                $msg = __('Alimentos con mayor cantidad de vitamina B1');
                $foods = Food::select('name', 'thiamin as amount')->orderByDesc('thiamin')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            /*
            case 'vB1Exc':
                $msg = __('Alimentos con mayor cantidad de vitamina B1 en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.thiamin as amount')->orderByDesc('f.thiamin')->get();
                sendData($msg, $foods);
            break;
            */
            /* vitamin B2 */
            case 'vB2Def':
                $msg = __('Alimentos con mayor cantidad de vitamina B2');
                $foods = Food::select('name', 'rivoflavin as amount')->orderByDesc('rivoflavin')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            /*
            case 'vB2Exc':
                $msg = __('Alimentos con mayor cantidad de vitamina B2 en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.rivoflavin as amount')->orderByDesc('f.rivoflavin')->get();
                sendData($msg, $foods);
            break;
            */
            /* vitamin B3 */
            case 'vB3Def':
                $msg = __('Alimentos con mayor cantidad de vitamina B3');
                $foods = Food::select('name', 'niacin as amount')->orderByDesc('niacin')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            /*
            case 'vB3Exc':
                $msg = __('Alimentos con mayor cantidad de vitamina B3 en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.niacin as amount')->orderByDesc('f.niacin')->get();
                sendData($msg, $foods);
            break;
            */
            /* vitamin B6 */
            case 'vB6Def':
                $msg = __('Alimentos con mayor cantidad de vitamina B6');
                $foods = Food::select('name', 'pyridoxine as amount')->orderByDesc('pyridoxine')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            /*
            case 'vB6Exc':
                $msg = __('Alimentos con mayor cantidad de vitamina B6 en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.pyridoxine as amount')->orderByDesc('f.pyridoxine')->get();
                sendData($msg, $foods);
            break;
            */
            /* vitamin B9 */
            case 'vB9Def':
                $msg = __('Alimentos con mayor cantidad de vitamina B9');
                $foods = Food::select('name', 'folic_acid as amount')->orderByDesc('folic_acid')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            /*
            case 'vB9Exc':
                $msg = __('Alimentos con mayor cantidad de vitamina B9 en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f.folic_acid as amount')->orderByDesc('f.folic_acid')->get();
                sendData($msg, $foods);
            break;
            */
            /* vitamin B12 */
            case 'vB12Def':
                $msg = __('Alimentos con mayor cantidad de vitamina B12');
                $foods = Food::select('name', 'cobalamin as amount')->orderByDesc('cobalamin')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            /*
            case '':
                $msg = __('Alimentos con mayor cantidad de  en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f. as amount')->orderByDesc('f.')->get();
                sendData($msg, $foods);
            break; */
            /* vitamin C */
            case 'vCDef':
                $msg = __('Alimentos con mayor cantidad de vitamina C');
                $foods = Food::select('name', 'ascorbic_acid as amount')->orderByDesc('ascorbic_acid')->limit(10)->get();
                return $this->sendData($msg, $foods);
            break;
            /*
            case '':
                $msg = __('Alimentos con mayor cantidad de  en el menú');
                $foods = $exc->where('m.id', $menu_id)->select('f.name', 'f. as amount')->orderByDesc('f.')->get();
                sendData($msg, $foods);
            break;
            */
            default:
                # code...
                break;
        }
    }
}
