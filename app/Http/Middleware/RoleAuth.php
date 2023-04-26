<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::check()){ 
            $currentUser = auth()->user();
            if($currentUser-> type == 0 || $currentUser-> type == 1){
                return $next($request);
            } else {
                return response()->json(["message"=> " you don't have access"],403);
            }
            
        } 

        return response()->json(["message"=> "Unauthorized"],401);
       
    }
}
