<?php

namespace App\Http\Middleware;

use App;
use Carbon\Carbon;
use Closure;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( session('applocale') AND array_key_exists(session('applocale'), config('language')) ){
            $configLanguage = config('languages')[session('applocale')];
            setLocale(LC_TIME, $configLanguage[1] . '.utf8');
            Carbon::setLocale(session('applocale'));
            App::setLocale(session('applocale'));
        } else {
            session()->put('applocale', 'es');
            setlocale(LC_TIME, 'es_ES.utf8');
            Carbon::setLocale(session('applocale'));
            App::setLocale(config('app.fallback_locale'));
        }
        return $next($request);
    }
}
