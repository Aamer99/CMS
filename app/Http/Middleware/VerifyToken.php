<?php

namespace App\Http\Middleware;

use App\Models\AccessToken;
use App\Models\TemporallyToken;
use App\Traits\HttpResponses;
use Closure;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyToken
{


  use HttpResponses;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param string $token
     */
    public function handle(Request $request, Closure $next): Response
    { 

        
        if(Auth::check()){

        
            $token = $request->token; 

            if($token){
              $accessToken = auth()->user()->temporallyToken; 
              

              if($accessToken){

                $currentDate = strtotime(now());
                $expiredDate = strtotime($accessToken-> expires_at); 

                if($currentDate < $expiredDate){ 
           
                  // return response()->json(["message"=> $accessToken]);
                  return $next($request);
      
                } else {
                  
                  return $this->error("Unauthorized",401);
                }


              }

            }
        
            return $this->error("Unauthorized",401);
        
        } else{

          return $this->error("Unauthorized",401);
        }
        
    }
}
