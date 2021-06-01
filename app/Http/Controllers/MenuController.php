<?php

namespace App\Http\Controllers;

use App\Menu;
use App\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    { /* ajax request to get menus data */
        if (request()->ajax()) {
            $menus = Menu::where('user_id', $user_id)
                ->where('status', 1)
                ->where('kind_of_menu', '<>', 0)
                ->select('id', 'name', 'description', 'kind_of_menu', 'created_at', 'updated_at')
                ->groupBy('name', 'description', 'id')
                ->get();
            $first = __("Ver");
            $second = __("Editar");
            $third = __("Eliminar");
            return DataTables::of($menus)
                ->addColumn('action', function ($row) use ($first, $second, $third) {
                    return '<button class="btn btn-info btn-sm text-center" data-toggle="modal" data-target="#showMenuModal"><i class="ni ni-folder-17"></i> ' . $first . '</button>
                            <button class="btn btn-success btn-sm text-center" data-toggle="modal" data-target="#saveMenuModal"><i class="far fa-edit"></i> ' . $second . '</button>
                            <button class="btn btn-warning btn-sm text-center" data-toggle="modal" data-target="#deleteMenuModal"><i class="far fa-trash-alt"></i> ' . $third . '</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $patient = User::where('users.id', $user_id)
            ->join('patients', 'patients.id', '=', 'users.id')
            ->first();

        if (Auth::user()->hasRole('nutritionist')) {
            return view('menus.index', ['patient' => $patient, 'role_id' => 2]);
        } else if (Auth::user()->hasRole('patient')) {
            return view('menus.index', ['patient' => $patient, 'role_id' => 3]);
        }
    }

    /**
     * Show menu details
     *
     * @return \Illuminate\Http\Response
     */
    public function show($menu_id)
    {
        if (Auth::user()->hasRole('nutritionist')) {
            $nutritionist = Auth::user();
            $menu = Menu::where('id', $menu_id)
                ->first();
            if (!$menu) {
                abort(404);
            }

            if (request()->ajax()) {
                return DataTables::of($menu)
                    ->addColumn('action', function ($row) {
                        return '<button class="btn btn-success btn-sm text-center" data-toggle="modal" data-target="#saveMenuModal"><i class="far fa-edit"></i></button>
                            <button class="btn btn-warning btn-sm text-center" data-toggle="modal" data-target="#deleteMenuModal"><i class="far fa-trash-alt"></i></button>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            /* menu owner */
            $patient = User::where('users.id', $menu->user_id)
                ->join('patients as p', 'p.user_id', '=', 'users.id')
                ->first();
            $patients = User::join('patients as p', 'p.user_id', '=', 'users.id')
                ->where('p.nutritionist_id', $nutritionist->id)
                ->get();
            /* menu validation: if nutritionist can edit this menu */
            $menu_validation = $patient->nutritionist_id == $nutritionist->id ? 1 : 0;
            return view('menus.show', ['patient' => $patient, 'patients' => $patients, 'role_id' => 2, 'menu' => $menu, 'menu_validation' => $menu_validation]);
        } else if (Auth::user()->hasRole('patient')) {
            $user = Auth::user();
            $menu = Menu::where('id', $menu_id)
                ->first();
            if (request()->ajax()) {
                return DataTables::of($menu)
                    ->addColumn('action', function ($row) {
                        return '<button class="btn btn-success btn-sm text-center" data-toggle="modal" data-target="#saveMenuModal"><i class="far fa-edit"></i></button>
                                <button class="btn btn-warning btn-sm text-center" data-toggle="modal" data-target="#deleteMenuModal"><i class="far fa-trash-alt"></i></button>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            if (!$menu) {
                abort(404);
            }
            /* menu owner */
            $patient = User::where('users.id', $menu->user_id)
                ->join('patients as p', 'p.user_id', '=', 'users.id')
                ->first();
            /* patient logged */
            $patient_logged = User::where('users.id', $user->id)
                ->join('patients as p', 'p.user_id', '=', 'users.id')
                ->first();
            /* check if menu belongs to patient logged(created by nutritionist) */
            if ($patient_logged->nutritionist_id && $menu->user_id !== $user->id) {
                abort(403);
            }
            $menu_validation = (!$patient_logged->nutritionist_id && $menu->user_id === $patient_logged->id) ? 1 : 0;
            return view('menus.show', ['patient' => $patient, 'role_id' => 3, 'menu' => $menu, 'menu_validation' => $menu_validation]);
        }
    }

    /**
     * Edit menu
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($menu_id)
    {
        if (Auth::user()->hasRole('nutritionist')) {
            $menu = Menu::where('id', $menu_id)->first();
            $patient = User::where('users.id', $menu->user_id)
                ->join('patients as p', 'p.user_id', '=', 'users.id')
                ->where('p.nutritionist_id', Auth::id())
                ->first();
            if (!$patient) {
                abort(403);
            }
            $age = Carbon::parse($patient->birthdate)->age;
            /* checking if user has all atributes required to generate results
            height, weight, age, kind of psychical activity and genre( to calculate micronutrients results)
             */
            if ($patient->caloric_requirement) {
                $data_validation = 1;
            } else {
                if (!$age || $patient->weight == null || $patient->height == null || $patient->genre == null || $patient->psychical_activity == null) {
                    $data_validation = 0;
                }
            }

            return view('menus.create', ['patient' => $patient, 'menu' => $menu, 'required' => $data_validation, 'role_id' => 2]);

        } else if (Auth::user()->hasRole('patient')) {
            $auth = Auth::user();
            $menu = Menu::where('id', $menu_id)->first();
            if (!$menu) {
                abort(404);
            }
            $patient = User::where('users.id', $menu->user_id)
                ->join('patients as p', 'p.user_id', '=', 'users.id')
                ->first();
            if ($patient->nutritionist_id != null) {
                return redirect()->route('home')->with('error', __('No tienes privilegios necesarios para acceder a Menú nuevo'));
            }
            if ($menu->user_id !== $auth->id) {
                abort(403);
            }

            $patient->age = Carbon::parse($patient->birthdate)->age;
            /* checking if user has all atributes required to generate results
            height, weight, age, kind of psychical activity and genre( to calculate micronutrients results)
             */
            if ($patient->caloric_requirement) {
                $data_validation = 1;
            } else {
                if (!$patient->age || $patient->weight == null || $patient->height == null || $patient->genre == null || $patient->psychical_activity == null) {
                    $data_validation = 0;
                }
            }

            return view('menus.create', ['patient' => $patient, 'menu' => $menu, 'required' => $data_validation, 'role_id' => 3]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        /* check if menu without save exists, if not, then create a new menu */
        $menu = Menu::where('kind_of_menu', 0)
            ->where('user_id', $id)
            ->where('status', true)
            ->first();
        if ($menu == null) {
            $menu = new Menu;
            $menu->user_id = $id;
            $menu->kind_of_menu = 0;
            $menu->save();
        }
        if (Auth::user()->hasRole('nutritionist')) {
            $patient = User::where('users.id', $id)
                ->join('patients', 'patients.id', '=', 'users.id')
                ->where('patients.nutritionist_id', Auth::id())
                ->first();
            $age = Carbon::parse($patient->birthdate)->age;
            /* checking if user has all atributes required to generate results
            height, weight, age, kind of psychical activity and genre( to calculate micronutrients results)
             */
            $patient->caloric_requirement ? $data_validation = 1 : $data_validation = 0;
            return view('menus.create', ['patient' => $patient, 'required' => $data_validation, 'menu' => $menu, 'role_id' => 2]);
        } else if (Auth::user()->hasRole('patient')) {
            //$auth = Auth::user();
            /* check if patient has no nutritionist */
            $patient = User::where('users.id', Auth::id())
                ->join('patients as p', 'p.user_id', '=', 'users.id')
                ->first();
            if ($patient->nutritionist_id) {
                return redirect()->route('home')->with('error', __('No tienes privilegios necesarios para acceder a Menú nuevo'));
            }
            $patient->caloric_requirement ? $data_validation = 1 : $data_validation = 0;
            return view('menus.create', ['patient' => $patient, 'required' => $data_validation, 'menu' => $menu, 'role_id' => 3]);
        }
    }

    /**
     * Store a newly created menu in storage.
     * kind_of:
     *          0 = menu without saving
     *          1 = saved menu, only the data is being updated
     *          2 = menu copied from another user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->hasRole('nutritionist')) {
            $menu_id = $request['menu_id'];
            $name = $request['name'];
            $description = $request['description'];
            $kind_of = $request['kind_of'];
            $patient_id = $request['patient_id'];
            $owner_id = $request['owner_id'];
            try {
                DB::beginTransaction();
                if ($kind_of == 2) {
                    /* update downloaded times in original menu */
                    $original_menu = Menu::where('id', $menu_id)->first();
                    $original_menu->times_downloaded = $original_menu->times_downloaded + 1;
                    $original_menu->updated_at = Carbon::now();
                    $original_menu->update();

                    $menu = Menu::insertGetId(array('name' => $name, 'description' => $description, 'user_id' => $patient_id, 'kind_of_menu' => 2, 'ideal' => $original_menu->ideal, 'original_owner' => $owner_id, 'status' => 1, 'created_at' => Carbon::now()));
                    $components = DB::table('components')
                        ->where('menu_id', $menu_id)
                        ->get();
                    if (!$components->isEmpty()) {
                        foreach ($components as $c) {
                            DB::table('components')
                                ->insert([
                                    'food_id' => $c->food_id, 'menu_id' => $menu,
                                    'food_weight' => $c->food_weight, 'kind_of_food' => $c->kind_of_food,
                                ]);
                        }
                    }
                    $msg = ['status' => 'success', 'message' => __('Menú de otro usuario guardado correctamente')];
                } else {
                    Menu::where('id', $menu_id)
                        ->update([
                            'name' => $name,
                            'description' => $description,
                            'kind_of_menu' => $kind_of,
                        ]);
                    $msg = ['status' => 'success', 'message' => __('Menú guardado correctamente. A continuación será redireccionado a sus menús')];
                }
                DB::commit();
                return response()->json($msg);

            } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollback();
                $message = __('Ocurrió un error, vuelve a intentarlo');
                return response()->json(['status' => 'error', 'message' => $message, 'exception' => $ex->getMessage()]);
            } catch (\Exception $ex) {
                DB::rollback();
                $message = __('Ocurrió un error, vuelve a intentarlo');
                return response()->json(['status' => 'error', 'message' => $message, 'exception' => $ex->getMessage()]);
            }
        } else if (Auth::user()->hasRole('patient')) {
            $user = Auth::user();
            $menu_id = $request['menu_id'];
            $name = $request['name'];
            $description = $request['description'];
            $kind_of = $request['kind_of'];
            $owner_id = $request['owner_id'];
            try {
                DB::beginTransaction();
                if ($kind_of == 2) {
                    /* update downloaded times in original menu */
                    $original_menu = Menu::where('id', $menu_id)->first();
                    $original_menu->times_downloaded = $original_menu->times_downloaded + 1;
                    $original_menu->update();
                    $menu = Menu::insertGetId(array('name' => $name, 'description' => $description, 'user_id' => $user->id, 'kind_of_menu' => 2, 'ideal' => $original_menu->ideal, 'original_owner' => $owner_id, 'status' => 1, 'created_at' => Carbon::now()));
                    $components = DB::table('components')
                        ->where('menu_id', $menu_id)
                        ->get();
                    if (!$components->isEmpty()) {
                        foreach ($components as $c) {
                            DB::table('components')
                                ->insert([
                                    'food_id' => $c->food_id, 'menu_id' => $menu,
                                    'food_weight' => $c->food_weight, 'kind_of_food' => $c->kind_of_food,
                                ]);
                        }
                    }
                    $msg = ['status' => 'success', 'message' => __('Menú de otro usuario guardado correctamente')];
                } else {
                    Menu::where('id', $menu_id)
                        ->update([
                            'name' => $name,
                            'description' => $description,
                            'kind_of_menu' => $kind_of,
                        ]);
                    $msg = ['status' => 'success', 'message' => __('Menú guardado correctamente. A continuación será redireccionado a sus menús')];
                }
                DB::commit();
                return response()->json($msg);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $menu_id = $request['menu_id'];
        $name = $request['menu_name'];
        $description = $request['menu_description'];
        try {
            DB::beginTransaction();
            Menu::where('id', $menu_id)
                ->update([
                    'name' => $name,
                    'description' => $description,
                    'updated_at' => Carbon::now(),
                ]);
            DB::commit();
            return response()->json(['status' => 'success', 'message' => __('Menú actualizado correctamente')]);

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

    /**
     * Calculate macronutrients status
     *  0: deficient
     *  1: ideal
     *  2: surplus
     */
    public function calculateMacronutrientsStatus($total, $min, $max)
    {
        if ($total < $min) {
            return 0;
        } else if ($total > $max) {
            return 2;
        } else {
            return 1;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function results($menu_id)
    {
        $menu = Menu::where('id', $menu_id)->first();
        if (!$menu) {
            abort(404);
        }
        $patient = User::where('users.id', $menu->user_id)
            ->join('patients as p', 'p.user_id', '=', 'users.id')
            ->first();
        $sum = DB::table('menus')
            ->join('components', 'components.menu_id', '=', 'menus.id')
            ->join('foods', 'foods.id', '=', 'components.food_id')
            ->where('menus.id', $menu_id)
            ->select(
                DB::raw("SUM((foods.proteins * components.food_weight)/100) as proteins"),
                DB::raw("SUM((foods.carbohydrates * components.food_weight)/100) as carbohydrates"),
                DB::raw("SUM((foods.total_lipids * components.food_weight)/100) as lipids"),
                DB::raw("SUM((foods.calcium * components.food_weight)/100) as calcium"),
                DB::raw("SUM((foods.phosphorus * components.food_weight)/100) as phosphorus "),
                DB::raw("SUM((foods.iron * components.food_weight)/100) as iron"),
                DB::raw("SUM((foods.magnesium * components.food_weight)/100) as magnesium"),
                DB::raw("SUM((foods.sodium * components.food_weight)/100) as sodium"),
                DB::raw("SUM((foods.potassium * components.food_weight)/100) as potassium"),
                DB::raw("SUM((foods.zinc * components.food_weight)/100) as zinc"),
                DB::raw("SUM((foods.vitamin_a * components.food_weight)/100) as vitamin_a"),
                DB::raw("SUM((foods.thiamin * components.food_weight)/100) as thiamin"),
                DB::raw("SUM((foods.rivoflavin * components.food_weight)/100) as rivoflavin"),
                DB::raw("SUM((foods.niacin * components.food_weight)/100) as niacin"),
                DB::raw("SUM((foods.pyridoxine * components.food_weight)/100) as pyridoxine"),
                DB::raw("SUM((foods.folic_acid * components.food_weight)/100) as folic_acid"),
                DB::raw("SUM((foods.cobalamin * components.food_weight)/100) as cobalamin"),
                DB::raw("SUM((foods.ascorbic_acid * components.food_weight)/100) as ascorbic_acid"),
                DB::raw("SUM((foods.kcal * components.food_weight)/100) as kcal"),
                DB::raw("SUM((foods.kj * components.food_weight)/100) as kj"),
                DB::raw("SUM((foods.water * components.food_weight)/100) as water"),
                DB::raw("SUM((foods.dietary_fiber * components.food_weight)/100) as dietary_fiber"),
                DB::raw("SUM((foods.cholesterol * components.food_weight)/100) as cholesterol"),
            )->get();
        /* MACRONUTRIENTS */
        /* PROTEINS */
        $caloriesinProteins = $sum[0]->proteins * 4;
        $minCaloriesInProteins = $patient->caloric_requirement * 0.2;
        $maxCaloriesInProteins = $patient->caloric_requirement * 0.35;
        $proteinsStatus = $this->calculateMacronutrientsStatus($caloriesinProteins, $minCaloriesInProteins, $maxCaloriesInProteins);
        /* CARBOHYDRATES (amount * carbohidrates in food) then /100) then * 4 */
        $caloriesinCarbohydrates = $sum[0]->carbohydrates * 4;
        $minCaloriesInCarbohydrates = $patient->caloric_requirement * 0.5;
        $maxCaloriesInCarbohydrates = $patient->caloric_requirement * 0.7;
        $carbohydratesStatus = $this->calculateMacronutrientsStatus($caloriesinCarbohydrates, $minCaloriesInCarbohydrates, $maxCaloriesInCarbohydrates);
        /* LIPIDS */
        $caloriesinLipids = $sum[0]->lipids * 9;
        $minCaloriesInLipids = $patient->caloric_requirement * 0.2;
        $maxCaloriesInLipids = $patient->caloric_requirement * 0.3;
        $lipidsStatus = $this->calculateMacronutrientsStatus($caloriesinLipids, $minCaloriesInLipids, $maxCaloriesInLipids);
        /* MICRONUTRIENTS */
        /* calcium*/
        $minCalcium = 1000;
        $totalCalcium = $sum[0]->calcium;
        $calciumStatus = ($totalCalcium < $minCalcium) ? 0 : 1;
        /* phosphorus */
        $minPhosphorus = 700;
        $totalPhosphorus = $sum[0]->phosphorus;
        $phosphorusStatus = ($totalPhosphorus < $minPhosphorus) ? 0 : 1;
        /* sodium */
        $minSodium = 500;
        $totalSodium = $sum[0]->sodium;
        $sodiumStatus = ($totalSodium < $minSodium) ? 0 : 1;
        /* potassium */
        $minPotassium = 2000;
        $totalPotassium = $sum[0]->potassium;
        $potassiumStatus = ($totalPotassium < $minPotassium) ? 0 : 1;
        /* vitamin B6 pyridoxine */
        $minVitaminB6 = 1.3;
        $totalVitaminB6 = $sum[0]->pyridoxine;
        $vitaminB6Status = ($totalVitaminB6 < $minVitaminB6) ? 0 : 1;
        /* vitamin b9 folic_acid */
        $minVitaminB9 = 400;
        $totalVitaminB9 = $sum[0]->folic_acid;
        $vitaminB9Status = ($totalVitaminB9 < $minVitaminB9) ? 0 : 1;
        /* vitamin b12 cobalamin*/
        $minVitaminB12 = 2.4;
        $totalVitaminB12 = $sum[0]->cobalamin;
        $vitaminB12Status = ($totalVitaminB12 < $minVitaminB12) ? 0 : 1;
        /* certain micronutrients requires a special calculation depending on the gender */
        /* genre = 0 : man, genre = 1: woman */
        /* iron */
        $minIron = $patient->genre == 0 ? 8 : 18;
        $totalIron = $sum[0]->iron;
        $ironStatus = ($totalIron < $minIron) ? 0 : 1;
        /* magnesium */
        $minMagnesium = $patient->genre == 0 ? 420 : 320;
        $totalMagnesium = $sum[0]->magnesium;
        $magnesiumStatus = ($totalMagnesium < $minMagnesium) ? 0 : 1;
        /* zinc */
        $minZinc = $patient->genre == 0 ? 11 : 8;
        $totalZinc = $sum[0]->zinc;
        $zincStatus = ($totalZinc < $minZinc) ? 0 : 1;
        /* vitamin A */
        $minVitaminA = $patient->genre == 0 ? 900 : 700;
        $totalVitaminA = $sum[0]->vitamin_a;
        $vitaminAStatus = ($totalVitaminA < $minVitaminA) ? 0 : 1;
        /* vitamin B1 */
        $minVitaminB1 = $patient->genre == 0 ? 1.2 : 1.1;
        $totalVitaminB1 = $sum[0]->thiamin;
        $vitaminB1Status = ($totalVitaminB1 < $minVitaminB1) ? 0 : 1;
        /* vitamin B2 */
        $minVitaminB2 = $patient->genre == 0 ? 1.3 : 1.1;
        $totalVitaminB2 = $sum[0]->rivoflavin;
        $vitaminB2Status = ($totalVitaminB2 < $minVitaminB2) ? 0 : 1;
        /* vitamin B3 */
        $minVitaminB3 = $patient->genre == 0 ? 16 : 14;
        $totalVitaminB3 = $sum[0]->niacin;
        $vitaminB3Status = ($totalVitaminB3 < $minVitaminB3) ? 0 : 1;
        /* vitamin C */
        $minVitaminC = $patient->genre == 0 ? 90 : 75;
        $totalVitaminC = $sum[0]->ascorbic_acid;
        $vitaminCStatus = ($totalVitaminC < $minVitaminC) ? 0 : 1;
        /* define whether the menu is ideal or not */
        if ($proteinsStatus != 1 || $carbohydratesStatus != 1 || $lipidsStatus != 1 || $calciumStatus != 1 || $phosphorusStatus != 1 ||
            $sodiumStatus != 1 || $potassiumStatus != 1 || $vitaminB6Status != 1 || $vitaminB9Status != 1 ||
            $vitaminB12Status != 1 || $ironStatus != 1 || $magnesiumStatus != 1 || $zincStatus != 1 ||
            $vitaminAStatus != 1 || $vitaminB1Status != 1 || $vitaminB2Status != 1 || $vitaminB3Status != 1 || $vitaminCStatus != 1) {
            $ideal = 0;
        } else { $ideal = 1;}
        /* update ideal field in menu table if necessary */
        if ($ideal != $menu->ideal) {
            $menu->ideal = $ideal;
            $menu->update();
        }
        /* SAVE RESULTS FROM MENU */
        /* first check if results row exists in results table */
        $results_data = DB::table('results')
            ->where('id', $menu_id)
            ->first();
        if ($results_data) {
            try {
                DB::beginTransaction();
                DB::table('results')
                    ->where('id', $menu_id)
                    ->update([
                        'carbohydrates' => $caloriesinCarbohydrates,
                        'carbohydratesStatus' => $carbohydratesStatus,
                        'proteins' => $caloriesinProteins,
                        'proteinsStatus' => $proteinsStatus,
                        'lipids' => $caloriesinLipids,
                        'lipidsStatus' => $lipidsStatus,
                        'calcium' => $totalCalcium,
                        'calciumStatus' => $calciumStatus,
                        'phosphorus' => $totalPhosphorus,
                        'phosphorusStatus' => $phosphorusStatus,
                        'iron' => $totalIron,
                        'ironStatus' => $ironStatus,
                        'magnesium' => $totalMagnesium,
                        'magnesiumStatus' => $magnesiumStatus,
                        'sodium' => $totalSodium,
                        'sodiumStatus' => $sodiumStatus,
                        'potassium' => $totalPotassium,
                        'potassiumStatus' => $potassiumStatus,
                        'zinc' => $totalZinc,
                        'zincStatus' => $zincStatus,
                        'vitaminA' => $totalVitaminA,
                        'vitaminAStatus' => $vitaminAStatus,
                        'vitaminB1' => $totalVitaminB1,
                        'vitaminB1Status' => $vitaminB1Status,
                        'vitaminB2' => $totalVitaminB2,
                        'vitaminB2Status' => $vitaminB2Status,
                        'vitaminB3' => $totalVitaminB3,
                        'vitaminB3Status' => $vitaminB3Status,
                        'vitaminB6' => $totalVitaminB6,
                        'vitaminB6Status' => $vitaminB6Status,
                        'vitaminB9' => $totalVitaminB9,
                        'vitaminB9Status' => $vitaminB9Status,
                        'vitaminB12' => $totalVitaminB12,
                        'vitaminB12Status' => $vitaminB12Status,
                        'vitaminC' => $totalVitaminC,
                        'vitaminCStatus' => $vitaminCStatus,
                        'updated_at' => Carbon::now(),
                    ]);
            } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollback();
            } catch (\Exception $ex) {
                DB::rollback();
            } finally {
                DB::commit();
            }
        } else {
            try {
                DB::beginTransaction();
                DB::table('results')
                    ->insert([
                        'id' => $menu_id,
                        'carbohydrates' => $caloriesinCarbohydrates,
                        'carbohydratesStatus' => $carbohydratesStatus,
                        'proteins' => $caloriesinProteins,
                        'proteinsStatus' => $proteinsStatus,
                        'lipids' => $caloriesinLipids,
                        'lipidsStatus' => $lipidsStatus,
                        'calcium' => $totalCalcium,
                        'calciumStatus' => $calciumStatus,
                        'phosphorus' => $totalPhosphorus,
                        'phosphorusStatus' => $phosphorusStatus,
                        'iron' => $totalIron,
                        'ironStatus' => $ironStatus,
                        'magnesium' => $totalMagnesium,
                        'magnesiumStatus' => $magnesiumStatus,
                        'sodium' => $totalSodium,
                        'sodiumStatus' => $sodiumStatus,
                        'potassium' => $totalPotassium,
                        'potassiumStatus' => $potassiumStatus,
                        'zinc' => $totalZinc,
                        'zincStatus' => $zincStatus,
                        'vitaminA' => $totalVitaminA,
                        'vitaminAStatus' => $vitaminAStatus,
                        'vitaminB1' => $totalVitaminB1,
                        'vitaminB1Status' => $vitaminB1Status,
                        'vitaminB2' => $totalVitaminB2,
                        'vitaminB2Status' => $vitaminB2Status,
                        'vitaminB3' => $totalVitaminB3,
                        'vitaminB3Status' => $vitaminB3Status,
                        'vitaminB6' => $totalVitaminB6,
                        'vitaminB6Status' => $vitaminB6Status,
                        'vitaminB9' => $totalVitaminB9,
                        'vitaminB9Status' => $vitaminB9Status,
                        'vitaminB12' => $totalVitaminB12,
                        'vitaminB12Status' => $vitaminB12Status,
                        'vitaminC' => $totalVitaminC,
                        'vitaminCStatus' => $vitaminCStatus,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                DB::commit();
            } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollback();
                //dd($ex);
                $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage()];
                //return response()->json($msg, 400);
            } catch (\Exception $ex) {
                DB::rollback();
                $msg = ['status' => 'error', 'message' => __('Ocurrió un error, vuelve a intentarlo'), 'exception' => $ex->getMessage()];
                //return response()->json($msg, 400);
            }
        }
        /* data to display on blade */
        $results = DB::table('results')
            ->where('id', $menu_id)
            ->get();
        /* check user role */
        if (Auth::user()->hasRole('nutritionist')) {
            $role_id = 2;
        } else if (Auth::user()->hasRole('patient')) {
            $role_id = 3;
        }
        return view('menus.results', [
            'menu_data' => $menu, 'patient' => $patient,
            'results' => $results,
            'minCaloriesInCarbohydrates' => $minCaloriesInCarbohydrates, 'maxCaloriesInCarbohydrates' => $maxCaloriesInCarbohydrates,
            'minCaloriesInProteins' => $minCaloriesInProteins, 'maxCaloriesInProteins' => $maxCaloriesInProteins,
            'minCaloriesInLipids' => $minCaloriesInLipids, 'maxCaloriesInLipids' => $maxCaloriesInLipids,
            'minCalcium' => $minCalcium,
            'minPhosphorus' => $minPhosphorus,
            'minIron' => $minIron,
            'minMagnesium' => $minMagnesium,
            'minSodium' => $minSodium,
            'minPotassium' => $minPotassium,
            'minZinc' => $minZinc,
            'minVitaminA' => $minVitaminA,
            'minVitaminB1' => $minVitaminB1,
            'minVitaminB2' => $minVitaminB2,
            'minVitaminB3' => $minVitaminB3,
            'minVitaminB6' => $minVitaminB6,
            'minVitaminB9' => $minVitaminB9,
            'minVitaminB12' => $minVitaminB12,
            'minVitaminC' => $minVitaminC,
            'kcal' => $sum[0]->kcal,
            'kj' => $sum[0]->kj,
            'water' => $sum[0]->water,
            'cholesterol' => $sum[0]->cholesterol,
            'dietary_fiber' => $sum[0]->dietary_fiber,
            'minWater' => 2100,
            'minFiber' => 25,
            'maxCholesterol' => 300,
            'minKcal' => $patient->caloric_requirement - ($patient->caloric_requirement * 0.1),
            'maxKcal' => $patient->caloric_requirement + ($patient->caloric_requirement * 0.1),
            'minKj' => ($patient->caloric_requirement - ($patient->caloric_requirement * 0.1)) * 4.1868,
            'maxKj' => ($patient->caloric_requirement + ($patient->caloric_requirement * 0.1)) * 4.1868,
            'role_id' => $role_id,
        ]);
    }
    /**
     * List menu items
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    function list($menu_id) {
        if (request()->ajax()) {
            $data = DB::table('menus')
                ->select('foods.*',
                    'menus.id as menu_id', 'menus.name as menuname', 'menus.description', 'menus.user_id', 'menus.kind_of_menu', 'menus.status',
                    'components.id', 'components.food_id', 'components.menu_id', 'components.food_weight', 'components.kind_of_food'
                )
                ->join('components', 'components.menu_id', '=', 'menus.id')
                ->join('foods', 'foods.id', '=', 'components.food_id')
                ->where('menus.status', 1)
            //->where('menus.kind_of_menu', 0)
                ->where('menus.id', $menu_id)
                ->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-primary btn-sm text-center"><i class="far fa-edit"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    /**
     * Delete menu items
     */
    function empty(Request $request) {
        $menu_id = $request['menu_id'];
        try {
            DB::beginTransaction();
            DB::table('components')
                ->where('menu_id', $menu_id)
                ->delete();
            $msg = ['status' => 'success', 'message' => __('Los elementos del menú han sido borrados correctamente')];
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
            return response()->json($msg);
        }
    }

    /***
     * Delete menu(only update status row to 0)
     *
     */
    public function destroy(Request $request)
    {
        $menu_id = $request['menu_id'];
        try {
            DB::beginTransaction();
            Menu::where('id', $menu_id)
                ->update([
                    'status' => 0,
                ]);
            $msg = ['status' => 'success', 'message' => __('Menú borrado correctamente')];
            DB::commit();
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
    }

    /**
     * Search menus with specific parameter
     *
     */
    public function search()
    {
        if (Auth::user()->hasRole('nutritionist')) {
            return view('menus.search', ['role_id' => 2]);
        } else if (Auth::user()->hasRole('patient')) {
            $user = Auth::user();
            $userData = User::where('users.id', $user->id)->join('patients as p', 'p.user_id', '=', 'users.id')->first();
            if ($userData->nutritionist_id) {
                return redirect()->route('home')->with('error', __('No tienes privilegios necesarios para acceder a Buscar menús'));
            }
            return view('menus.search', ['role_id' => 3]);
        }
    }

    public function searchResults(Request $request)
    {
        if (Auth::user()->hasRole('nutritionist')) {
            $nutritionist = Auth::user();
            $query = strtolower($request['search_menu']);
            // split on 1+ whitespace & ignore empty (eg. trailing space)
            $search = preg_split('/\s+/', $query, -1, PREG_SPLIT_NO_EMPTY);
            $usernames = User::join('patients', 'patients.id', '=', 'users.id')
                ->where(function ($q) use ($search) {
                    foreach ($search as $s) {
                        //$q->orWhere('name', 'like', "%{$s}%");
                        $q->orWhere(DB::raw('lower(users.name)'), 'like', "%{$s}%");
                    }
                })
                ->orWhere(function ($q) use ($search) {
                    foreach ($search as $s) {
                        $q->orWhere(DB::raw('lower(users.last_name)'), 'like', "%{$s}%");
                    }
                })
                ->select('users.*', 'patients.*')
            /* postgresql */
                ->selectRaw("EXTRACT(year FROM age(patients.birthdate) ) AS age")
            /* mysql
            //->selectRaw("TIMESTAMPDIFF(YEAR, DATE(patients.birthdate), current_date) AS age")*/
                ->paginate(6);
            $patients = User::join('patients', 'patients.user_id', '=', 'users.id')
                ->where('patients.nutritionist_id', $nutritionist->id)
                ->where(function ($q) use ($search) {
                    foreach ($search as $s) {
                        $q->orWhere(DB::raw('lower(users.last_name)'), 'like', "%{$s}%");
                    }
                })
            //->where('name', 'like', "%{$search}%")
                ->orWhere(function ($q) use ($search) {
                    foreach ($search as $s) {
                        $q->orWhere(DB::raw('lower(users.last_name)'), 'like', "%{$s}%");
                    }
                })
            //->orWhere('last_name', 'like', "%{$search}%")
                ->select('users.*', 'patients.*')
            /* postgresql */
                ->selectRaw("EXTRACT(year FROM age(patients.birthdate) ) AS age")
            /* mysql */
            //->selectRaw("TIMESTAMPDIFF(YEAR, DATE(patients.birthdate), current_date) AS age")
                ->paginate(6);
            $foods = User::join('menus', 'menus.user_id', '=', 'users.id')
                ->join('patients as p', 'p.user_id', '=', 'users.id')
                ->join('components', 'components.menu_id', '=', 'menus.id')
                ->join('foods', 'foods.id', '=', 'components.food_id')
                ->where(function ($q) use ($search) {
                    foreach ($search as $s) {
                        $q->orWhere(DB::raw('lower(foods.name)'), 'like', "%{$s}%");
                    }
                })
            //->where('foods.name', 'like', '%'.$search.'%' )
                ->where('menus.status', '=', '1')
                ->where('menus.kind_of_menu', '<>', 0)
                ->select(
                    'menus.id as menu_id', 'menus.name as menu_name', 'menus.description', 'users.name', 'users.avatar', 'users.last_name', 'menus.ideal',
                    'menus.id AS menu_id', 'users.id AS user_id', 'menus.created_at', 'menus.updated_at', 'menus.kind_of_menu',
                    'p.birthdate', 'p.genre', 'p.caloric_requirement', 'p.weight', 'p.height', 'p.psychical_activity'
                )
            /* postgresql */
                ->selectRaw("EXTRACT(year FROM age(p.birthdate) ) AS age")
            /* mysql */
            //->selectRaw("TIMESTAMPDIFF(YEAR, DATE(p.birthdate), current_date) AS age")
                ->distinct()
                ->paginate(6);
            $menusByName = Menu::join('users', 'users.id', '=', 'menus.user_id')
                ->join('patients as p', 'p.user_id', '=', 'users.id')
                ->select(
                    'menus.id as menu_id', 'menus.name AS menu_name', 'menus.description', 'users.name', 'users.last_name', 'users.avatar', 'menus.id AS menu_id', 'users.id AS user_id',
                    'menus.created_at', 'menus.updated_at', 'menus.kind_of_menu', 'menus.ideal',
                    'p.birthdate', 'p.weight', 'p.height', 'p.genre', 'p.psychical_activity', 'p.caloric_requirement'
                )
            /* postgresql */
                ->selectRaw("EXTRACT(year FROM age(p.birthdate) ) AS age")
            /* mysql */
            //->selectRaw("TIMESTAMPDIFF(YEAR, DATE(p.birthdate), current_date) AS age")
                ->where('menus.status', 1)
                ->where('menus.kind_of_menu', '<>', 0)
            //->where('menus.kind_of_menu', 2)
                ->where(function ($q) use ($search) {
                    foreach ($search as $s) {
                        $q->orWhere(DB::raw('lower(menus.name)'), 'like', "%{$s}%");
                    }
                })
            //->where('menus.name', 'like', '%'.$search.'%' )
                ->paginate(6);
            $menusByDescription = Menu::where('menus.status', 1)
                ->where('menus.kind_of_menu', '<>', 0)
                ->where(function ($q) use ($search) {
                    foreach ($search as $s) {
                        $q->orWhere(DB::raw('lower(menus.description)'), 'like', "%{$s}%");
                    }
                })
            //->where('menus.description', 'like', '%'.$search.'%' )
                ->join('users', 'users.id', '=', 'menus.user_id')
                ->join('patients as p', 'p.user_id', '=', 'users.id')
                ->select(
                    'menus.id as menu_id', 'menus.name as menu_name', 'menus.description', 'users.name', 'users.last_name', 'users.avatar', 'menus.id AS menu_id', 'users.id AS user_id',
                    'menus.created_at', 'menus.updated_at', 'menus.kind_of_menu', 'menus.ideal',
                    'p.birthdate', 'p.weight', 'p.height', 'p.genre', 'p.psychical_activity', 'p.caloric_requirement'
                )
            /* postgresql */
                ->selectRaw("EXTRACT(year FROM age(p.birthdate) ) AS age")
            /* mysql */
            //->selectRaw("TIMESTAMPDIFF(YEAR, DATE(p.birthdate), current_date) AS age")
                ->paginate(6);
            return view('menus.search', ['search' => $query, 'usernames' => $usernames, 'patients' => $patients, 'foods' => $foods, 'menusByName' => $menusByName, 'menusByDescription' => $menusByDescription, 'role_id' => 2]);
        } else if (Auth::user()->hasRole('patient')) {
            $query = strtolower($request['search_menu']);
            // split on 1+ whitespace & ignore empty (eg. trailing space)
            $search = preg_split('/\s+/', $query, -1, PREG_SPLIT_NO_EMPTY);
            //dd($search);
            $usernames = User::join('patients', 'patients.id', '=', 'users.id')
                ->where(function ($q) use ($search) {
                    foreach ($search as $s) {
                        $q->orWhere(DB::raw('lower(users.name)'), 'like', "%{$s}%");
                    }
                })
            //->where('name', 'like', "%{$search}%")
                ->orWhere(function ($q) use ($search) {
                    foreach ($search as $s) {
                        $q->orWhere(DB::raw('lower(users.last_name)'), 'like', "%{$s}%");
                    }
                })
            //->orWhere('last_name', 'like', "%{$search}%")
                ->select('users.*', 'patients.*')
            /* postgresql */
                ->selectRaw("EXTRACT(year FROM age(patients.birthdate) ) AS age")
            /* mysql
            ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(patients.birthdate), current_date) AS age")*/
                ->paginate(6);
            $foods = User::join('menus', 'menus.user_id', '=', 'users.id')
                ->join('patients as p', 'p.user_id', '=', 'users.id')
                ->join('components', 'components.menu_id', '=', 'menus.id')
                ->join('foods', 'foods.id', '=', 'components.food_id')
                ->where(function ($q) use ($search) {
                    foreach ($search as $s) {
                        $q->orWhere(DB::raw('lower(foods.name)'), 'like', "%{$s}%");
                    }
                })
            //->where('foods.name', 'like', '%'.$search.'%' )
                ->where('menus.status', '=', '1')
                ->where('menus.kind_of_menu', '<>', 0)
                ->select(
                    'menus.id as menu_id', 'menus.name as menu_name', 'menus.description', 'users.name', 'users.last_name', 'users.avatar',
                    'menus.id AS menu_id', 'users.id AS user_id', 'menus.created_at', 'menus.updated_at', 'menus.kind_of_menu', 'menus.ideal',
                    'p.birthdate', 'p.genre', 'p.caloric_requirement', 'p.weight', 'p.height', 'p.psychical_activity'
                )
            /* postgresql */
                ->selectRaw("EXTRACT(year FROM age(p.birthdate) ) AS age")
            /* mysql
            ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(p.birthdate), current_date) AS age")*/
                ->distinct()
                ->paginate(6);
            $menusByName = User::join('menus', 'menus.user_id', '=', 'users.id')
                ->join('patients as p', 'p.user_id', '=', 'users.id')
                ->select(
                    'menus.id as menu_id', 'menus.name AS menu_name', 'menus.description', 'users.name', 'users.last_name', 'users.avatar', 'menus.id AS menu_id', 'users.id AS user_id',
                    'menus.created_at', 'menus.updated_at', 'menus.kind_of_menu', 'menus.ideal',
                    'p.birthdate', 'p.weight', 'p.height', 'p.genre', 'p.psychical_activity', 'p.caloric_requirement'
                )
            /* postgresql */
                ->selectRaw("EXTRACT(year FROM age(p.birthdate) ) AS age")
            /* mysql
            ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(p.birthdate), current_date) AS age")*/
                ->where('menus.status', 1)
                ->where('menus.kind_of_menu', '<>', 0)
            //->where('menus.kind_of_menu', 2)
                ->where(function ($q) use ($search) {
                    foreach ($search as $s) {
                        $q->orWhere(DB::raw('lower(menus.name)'), 'like', "%{$s}%");
                    }
                })
            //->where('menus.name', 'like', '%'.$search.'%' )
                ->paginate(6);
            $menusByDescription = User::where('menus.status', 1)
                ->where('menus.kind_of_menu', '<>', 0)
                ->where(function ($q) use ($search) {
                    foreach ($search as $s) {
                        $q->orWhere(DB::raw('lower(menus.description)'), 'like', "%{$s}%");
                    }
                })
            //->where('menus.description', 'like', '%'.$search.'%' )
                ->join('menus', 'menus.user_id', '=', 'users.id')
                ->join('patients as p', 'p.user_id', '=', 'users.id')
                ->select(
                    'menus.id as menu_id', 'menus.name as menu_name', 'menus.description', 'users.name', 'users.last_name', 'users.avatar', 'menus.id AS menu_id', 'users.id AS user_id',
                    'menus.created_at', 'menus.updated_at', 'menus.kind_of_menu', 'menus.ideal',
                    'p.birthdate', 'p.weight', 'p.height', 'p.genre', 'p.psychical_activity', 'p.caloric_requirement'
                )
            /* postgresql */
                ->selectRaw("EXTRACT(year FROM age(p.birthdate) ) AS age")
            /* mysql
            ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(p.birthdate), current_date) AS age")*/
                ->paginate(6);
            return view('menus.search', ['search' => $query, 'usernames' => $usernames, 'foods' => $foods, 'menusByName' => $menusByName, 'menusByDescription' => $menusByDescription, 'role_id' => 3]);
        }
    }
}
