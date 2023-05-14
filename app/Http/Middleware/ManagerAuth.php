<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManagerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
            $currentUserRole = auth()->user()->role;
            if($currentUserRole=== 2){
                return $next($request);
            } else {
                return response()->json(["message"=> " you don't have access"],403);
            }
            
        
    }
}
