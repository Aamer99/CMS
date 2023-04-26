<?php

namespace App\Http\Middleware;

use App\Models\AccessToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param string $token
     */
    public function handle(Request $request, Closure $next): Response
    { 

        
        if(Auth::check()){

          $token = AccessToken::where("user_id",auth()-> user()-> id)->first(); 

          if($token){

             $currentDate = strtotime(now());
             $expiredDate = strtotime($token-> expired_at);

             if($currentDate < $expiredDate){ 
           
                return $next($request);
    
              } else {
                
                return response()-> json(["you need to login again"],401);
              }
          }else if(!auth()->user()-> is_validate){
            
            return $next($request);
          }
          

        return response()-> json(["message"=> "Unauthorized"],401);
        
        } else{
            return response()-> json(["message"=> "Unauthorized"],401);
        }
        
    }
}
