<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function setLanguage($lang){
        if(array_key_exists($lang, config('language'))){
            session()->put('applocale', $lang);
        }
        return back();
    }
}
