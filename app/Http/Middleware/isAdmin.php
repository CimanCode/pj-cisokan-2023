<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!session()->start())
            session()->start();
        if(!session()->has('logged','id_role_admin')){
            Alert::error('Oops','Anda Bukan Admin Terdaftar');
            return redirect()->back();}
        return $next($request);
    }
}
