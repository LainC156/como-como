<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('index');

Auth::routes();

    /* about */
//Route::get('about', )
    /* language */
Route::get('/set_language/{lang}', 'AppController@setLanguage')->name('set_language');
    /* confirm register */
Route::get('/signup/{token}', 'Auth\RegisterController@confirmRegister')->name('signup.token');
    /* about */
    Route::get('about', 'Auth\LoginController@about')->name('about');
Route::get('home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
        /* users routes */
    Route::get('/user/index', 'UserController@index')->name('user.index');
    Route::get('/user/create', 'UserController@create')->name('user.create');
    Route::post('/user/store', 'UserController@store')->name('user.store');
    Route::get('/user/{id}/edit/', 'UserController@edit')->name('user.edit');
    Route::post('/user/update', 'UserController@update')->name('user.update');
    Route::post('/user/{id}/delete', 'UserController@destroy')->name('user.destroy');
    Route::post('/avatar/{id}/update', 'UserController@updateAvatar')->name('avatar.update');

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
        /* menus routes */
    Route::get('/menu/{id}/create', 'MenuController@create')->name('menu.create');
    Route::post('menu/store', 'MenuController@store')->name('menu.store');
    Route::post('/updatemenu', 'MenuController@update')->name('menu.update');
    Route::post('deletemenu','MenuController@delete')->name('menu.delete');
    Route::get('/user/{id}/menus', 'MenuController@index')->name('menu.index');
    Route::get('/menu/{id}/list', 'MenuController@list')->name('menu.list');
    Route::get('/user/{id}/menu/{menu_id}/edit', 'MenuController@editMenuSaved')->name('menu.edit');
    Route::post('emptymenu', 'MenuController@empty')->name('empty.menu');
    Route::get('user/{id}/menu/{menu_id}/results', 'MenuController@results')->name('menu.results');
        /* foods routes */
    Route::post('/addfood', 'FoodController@addFood')->name('food.add');
    Route::get('listfood', 'FoodController@foodList')->name('food.list');
        /* components routes */
    Route::post('/updatecomponent', 'FoodController@update')->name('component.update');
    Route::post('/deletecomponent', 'FoodController@destroy')->name('component.destroy');

});

