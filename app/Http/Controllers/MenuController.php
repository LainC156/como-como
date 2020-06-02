<?php

namespace App\Http\Controllers;

use App\Menu;
use App\User;
use App\Patient;
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if(Auth::user()->hasRole('nutritionist')) {
            $role_id = 2;
            $patient = User::where('users.id', $id)
                    ->join('patients', 'patients.id', '=', 'users.id')
                    ->first();
            $age = Carbon::parse($patient->birthdate)->age;
            /* checking if user has all atributes required to generate results
            height, weight, age, kind of psychical activity and genre( to calculate micronutrients results)
            */
            if($patient->caloric_requirement){
                $data_validation = 1;
            } else {
                if(!$age || $patient->weight == NULL || $patient->height == NULL  || $patient->genre == NULL || $patient->psychical_activity == NULL){
                    $data_validation = 0;
                }
            }
            /* check if menu without save exists, if not, then create a new menu */
            $menu = Menu::where('kind_of_menu', 0)
                    ->where('user_id', $id)
                    ->where('status', 1)
                    ->first();
            if($menu == null){
                $menu = new Menu;
                $menu->user_id= $id;
                $menu->kind_of_menu = 0;
                $menu->save();
            }
            return view('menus.create', ['patient' => $patient, 'required' => $data_validation, 'menu' => $menu, 'role_id' => $role_id]);
        }
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
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function list($menu_id)
    {
        /* list all elements of menu
        id = user_id
        $data->id = id of component
        */
        if(request()->ajax()){
            $data = DB::table('menus')
                ->select('foods.*',
                 'menus.id as menu_id', 'menus.name as menuname', 'menus.description', 'menus.user_id', 'menus.kind_of_menu', 'menus.status',
                 'components.food_id', 'components.menu_id', 'components.food_weight', 'components.kind_of_food'
                  )
                ->join('components', 'components.menu_id', '=', 'menus.id')
                ->join('foods', 'foods.id', '=', 'components.food_id')
                ->where('menus.status', 1)
                //->where('menus.kind_of_menu', 0)
                ->where('menus.id', $menu_id)
                ->get();
                return DataTables::of($data)
                ->addColumn('action',function($row) {
                    return  '<button class="btn btn-primary btn-sm text-center"><i class="far fa-edit"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function editMenuSaved($id, $menu_id)
    {
        if( Auth::user()->hasRole('nutritionist') ) {
            $role_id = 2;
            if( request()->ajax() ) {
                $data = DB::table('menus')
                ->join('components', 'components.menu_id', '=', 'menus.id')
                ->join('foods', 'foods.id', '=', 'components.food_id')
                ->where('menus.id', $menu_id)
                ->get();
                return DataTables::of($data)
                ->make(true);
            }
            $patient = DB::table('users')
                    ->join('patients', 'patients.id', '=', 'users.id')
                    ->where('users.id', $id)->first();
            $foods = DB::table('menus')
                    ->join('components', 'components.menu_id', '=', 'menus.id')
                    ->join('foods', 'foods.id', '=', 'components.food_id')
                    ->where('menus.id', $menu_id)
                    ->get();
            $menu = Menu::where('id', $menu_id)->first();
            /* check if user has no required properties like age, weight, height, kind of psychical activity and caloric requirement */
            if( $patient->weight == NULL|| $patient->height == NULL || $patient->age == NULL || $patient->genre == NULL || $patient->psychical_activity == NULL || $patient->caloric_requirement == NULL )
                $userdata_validation = 0;
            else $userdata_validation = 1;
            return view('menus.create', ['patient' => $patient, 'foods' => $foods, 'required' => $userdata_validation, 'menu' => $menu, 'kind_of_menu' => 1, 'role_id' => $role_id]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
