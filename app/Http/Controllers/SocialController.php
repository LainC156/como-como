<?php

namespace App\Http\Controllers;

use App\Menu;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('nutritionist')) {
            $data = User::select(
                'users.id AS user_id', 'menus.id AS menu_id', 'users.name AS username', 'users.last_name', 'users.avatar', 'menus.name', 'menus.times_downloaded',
                'menus.description', 'menus.kind_of_menu', 'menus.created_at', 'menus.ideal', 'menus.updated_at',
                'patients.weight', 'patients.height', 'patients.genre', 'patients.psychical_activity',
                'patients.caloric_requirement', DB::raw('COUNT(social.like) as likes')
            )
            /* postgresql */
                ->selectRaw("EXTRACT(year FROM age(patients.birthdate) ) AS age")
            /* mysql */
            //->selectRaw("TIMESTAMPDIFF(YEAR, DATE(patients.birthdate), current_date) AS age")
                ->leftJoin('menus', 'menus.user_id', '=', 'users.id')
                ->leftJoin('patients', 'patients.user_id', '=', 'users.id')
                ->leftJoin('social', 'social.menu_id', '=', 'menus.id')
                ->where('menus.status', 1)
                ->where('menus.kind_of_menu', '<>', 0)
                ->groupBy('users.id', 'menus.id', 'patients.weight', 'patients.height', 'patients.birthdate', 'patients.genre', 'patients.psychical_activity', 'patients.caloric_requirement')
                ->orderBy('menus.updated_at')
                ->paginate(6);

            return view('social.index', ['activities' => $data, 'role_id' => 2]);
        } else if (Auth::user()->hasRole('patient')) {
            $user = Auth::user();
            $userData = User::where('users.id', $user->id)->join('patients as p', 'p.user_id', '=', 'users.id')->first();
            if ($userData->nutritionist_id) {
                return redirect()->route('home')->with('error', __('No tienes privilegios necesarios para acceder a Social'));
            }
            $data = User::select(
                'users.id AS user_id', 'menus.id AS menu_id', 'users.name AS username', 'users.last_name', 'users.avatar', 'menus.name', 'menus.times_downloaded',
                'menus.description', 'menus.kind_of_menu', 'menus.created_at', 'menus.ideal', 'menus.updated_at',
                'patients.weight', 'patients.height', 'patients.genre', 'patients.psychical_activity',
                'patients.caloric_requirement', DB::raw('COUNT(social.like) as likes')
            )
            /* postgresql */
                ->selectRaw("EXTRACT(year FROM age(patients.birthdate) ) AS age")
            /* mysql */
            //->selectRaw("TIMESTAMPDIFF(YEAR, DATE(patients.birthdate), current_date) AS age")
                ->leftJoin('menus', 'menus.user_id', '=', 'users.id')
                ->leftJoin('patients', 'patients.user_id', '=', 'users.id')
                ->leftJoin('social', 'social.menu_id', '=', 'menus.id')
            //->join('payments as p', 'p.user_id', '=', 'users.id')
                ->where('menus.status', 1)
                ->where('menus.kind_of_menu', '<>', 0)
                ->groupBy('users.id', 'menus.id', 'patients.weight', 'patients.height', 'patients.birthdate', 'patients.genre', 'patients.psychical_activity', 'patients.caloric_requirement')
                ->orderBy('menus.updated_at')
                ->paginate(6);
            return view('social.index', ['activities' => $data, 'role_id' => 3]);
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
    public function show($menu_id)
    {
        if (Auth::user()->hasRole('nutritionist')) {
            $menu = Menu::where('id', $menu_id)->first();
            if(!$menu) {
                abort(404);
            }
            $patient = User::join('patients', 'patients.user_id', '=', 'users.id')
                ->join('menus', 'menus.user_id', '=', 'users.id')
                ->where('users.id', $menu->user_id)
                ->select('users.*', 'patients.*', 'menus.ideal')
            /* postgresql */
                ->selectRaw("EXTRACT(year FROM age(patients.birthdate) ) AS age")
            /* mysql */
            //->selectRaw("TIMESTAMPDIFF(YEAR, DATE(patients.birthdate), current_date) AS age")
                ->first();
            $validation = DB::table('social')
                ->where('owner_id', $patient->id)
                ->where('menu_id', $menu_id)
                ->where('user_id', Auth::user()->id)
                ->first();
            $like_validation = !$validation ? $like_validation = -1 : $validation->like;
            //dd($like_validation);
            $like_count = DB::table('social')
                ->where('menu_id', $menu_id)
                ->where('like', 1)
                ->count();

            $comment_count = DB::table('social_comments as sc')
                ->join('social as s', 's.id', '=', 'sc.social_id')
                ->where('s.menu_id', $menu_id)
                ->count();

            /* how to manage likes and comments? */
            $activities = User::join('social', 'social.user_id', '=', 'users.id')
                ->join('social_comments', 'social_comments.social_id', '=', 'social.id')
                ->join('menus', 'menus.id', '=', 'social.menu_id')
                ->where('social.owner_id', $patient->id)
                ->where('social.menu_id', $menu_id)
                ->select('users.name', 'users.last_name', 'users.avatar', 'social.created_at', 'social.updated_at', 'social_comments.comment')
            //->groupBy('users.name', 'social.updated_at', 'social_comments.comment')
                ->get();

            return view('social.show', ['patient' => $patient, 'menu' => $menu, 'like_validation' => $like_validation, 'activities' => $activities, 'like_count' => $like_count, 'comment_count' => $comment_count, 'role_id' => 2]);
        } else if (Auth::user()->hasRole('patient')) {
            $user = Auth::user();
            $userData = User::where('users.id', $user->id)->join('patients as p', 'p.user_id', '=', 'users.id')->first();
            if ($userData->nutritionist_id) {
                return redirect()->route('home')->with('error', __('No tienes privilegios necesarios para acceder a Social'));
            }
            $menu = Menu::where('id', $menu_id)->first();
            if(!$menu) {
                abort(404);
            }
            $patient = User::join('patients', 'patients.user_id', '=', 'users.id')
                ->join('menus', 'menus.user_id', '=', 'users.id')
                ->where('users.id', $menu->user_id)
                ->select('users.*', 'patients.*', 'menus.ideal')
            /* postgresql */
                ->selectRaw("EXTRACT(year FROM age(patients.birthdate) ) AS age")
            /* mysql */
            //->selectRaw("TIMESTAMPDIFF(YEAR, DATE(patients.birthdate), current_date) AS age")
                ->first();
            $validation = DB::table('social')
                ->where('owner_id', $patient->id)
                ->where('menu_id', $menu_id)
                ->where('user_id', Auth::user()->id)
                ->first();
            $like_validation = !$validation ? $like_validation = -1 : $validation->like;
            //dd($like_validation);
            $like_count = DB::table('social')
                ->where('menu_id', $menu_id)
                ->where('like', 1)
                ->count();

            $comment_count = DB::table('social_comments as sc')
                ->join('social as s', 's.id', '=', 'sc.social_id')
                ->where('s.menu_id', $menu_id)
                ->count();

            /* how to manage likes and comments? */
            $activities = DB::table('users')
            //->join('patients', 'patients.user_id', '=', 'users.id')
                ->join('social', 'social.user_id', '=', 'users.id')
                ->join('social_comments', 'social_comments.social_id', '=', 'social.id')
                ->join('menus', 'menus.id', '=', 'social.menu_id')
                ->where('social.owner_id', $patient->id)
                ->where('social.menu_id', $menu_id)
                ->select('users.name', 'users.last_name', 'users.avatar', 'social.created_at', 'social.updated_at', 'social_comments.comment')
            //->groupBy('users.name', 'social.updated_at', 'social_comments.comment')
                ->get();
            return view('social.show', ['patient' => $patient, 'menu' => $menu, 'like_validation' => $like_validation, 'activities' => $activities, 'like_count' => $like_count, 'comment_count' => $comment_count, 'role_id' => 3]);
        }
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

    /**
     * Like or unlike menus
     *
     */
    public function like(Request $request)
    {
        if (Auth::user()->hasRole('nutritionist') || Auth::user()->hasRole('patient')) {
            $menu_id = $request['menu_id'];
            $like = $request['like'];
            $menu = Menu::where('id', $menu_id)->first();
            $user = Auth::user();
            /* check if user likes or not this menu */
            $like_validation = DB::table('social')
                ->where('owner_id', $menu->user_id)
                ->where('menu_id', $menu_id)
                ->where('user_id', $user->id)
                ->first();
            /* $no_like_validation = DB::table('social')
            ->where('owner_id', $patient_id)
            ->where('menu_id', $menu_id)
            ->where('user_id', Auth::user()->id)
            ->where('like', 0)
            ->first(); */

            if (!$like_validation) {
                DB::beginTransaction();
                try {
                    DB::table('social')
                        ->insert([
                            'owner_id' => $menu->user_id,
                            'menu_id' => $menu_id,
                            'user_id' => $user->id,
                            'like' => $like,
                        ]);
                    $msg = ['status' => 'success', 'message' => __('Has1 indicado que te gusta este menú')];
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
            } else if ($like_validation) {
                if ($like == 1) {
                    DB::beginTransaction();
                    try {
                        DB::table('social')
                            ->where('menu_id', $menu_id)
                            ->where('owner_id', $menu->user_id)
                            ->where('user_id', $user->id)
                            ->where('like', 1)
                            ->update([
                                'like' => 0,
                            ]);
                        $msg = ['status' => 'success', 'message' => __('Has indicado que ya no te gusta este menú')];
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
                } else if ($like == 0) {
                    DB::beginTransaction();
                    try {
                        DB::table('social')
                            ->where('menu_id', $menu_id)
                            ->where('owner_id', $menu->user_id)
                            ->where('user_id', $user->id)
                            ->where('like', 0)
                            ->update([
                                'like' => 1,
                            ]);
                        $msg = ['status' => 'success', 'message' => __('Has indicado que te gusta este menú')];
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
            }
        }
    }

    /**
     * comments in certain social menu activity
     *
     */
    public function comment(Request $request)
    {
        if (Auth::user()->hasRole('nutritionist') || Auth::user()->hasRole('patient')) {
            $menu_id = $request['menu_id'];
            $menu = Menu::where('id', $menu_id)->first();
            $comment = $request['comment'];
            $user = Auth::user();
            $validation = DB::table('social')
                ->where('owner_id', $menu->user_id)
                ->where('menu_id', $menu_id)
                ->where('user_id', $user->id)
                ->first();
            /* insert new comment in this social menu */
            try {
                DB::beginTransaction();
                if (!$validation) {
                    $id = DB::table('social')
                        ->insertGetId([
                            'owner_id' => $menu->user_id,
                            'menu_id' => $menu_id,
                            'user_id' => $user->id,
                            'created_at' => Carbon::now(),
                        ]);
                    DB::table('social_comments')
                        ->insert([
                            'social_id' => $id,
                            'comment' => $comment,
                            'created_at' => Carbon::now(),
                        ]);
                    $msg = ['status' => 'success', 'message' => __('Has comentado este menú'), 'user_name' => $user->name, 'last_name' => $user->last_name, 'avatar' => $user->avatar, 'date' => Carbon::now(), 'comment' => $comment, 'kind_of_comment' => 'new'];
                } else {
                    DB::table('social_comments')
                        ->insert([
                            'social_id' => $validation->id,
                            'comment' => $comment,
                            'created_at' => Carbon::now(),
                        ]);
                    $msg = ['status' => 'success', 'message' => __('Has comentado este menú'), 'user_name' => $user->name, 'last_name' => $user->last_name, 'avatar' => $user->avatar, 'date' => Carbon::now(), 'comment' => $comment, 'kind_of_comment' => 'updated'];
                }
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
            } finally {
            }
        }
    }

}
