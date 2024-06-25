<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if(auth()->user()->getRole->name == "Administrator"){
                    return redirect()->route('listMahasiswa');
                } else if(auth()->user()->getRole->name == "Mahasiswa"){
                    return redirect()->route('mahasiswa/home');
                }else if(auth()->user()->getRole->name == "Dekan"){
                    return redirect()->route('dekan/review');
                }else if(auth()->user()->role_id == 4){
                    return redirect()->route('program-studi/review');
                }
                // return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
