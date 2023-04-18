<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\otpRequest;
use App\Mail\otpMail;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\NewAccessToken;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');  

        if (Auth::attempt($credentials)) {
        
            
            if(!auth()->user()-> is_validate){
                 return response()->json(['message'=> "you need to reset your password"],403);
            } else {
            // create token 

            $token = Str::random(40); 

            // otp 
            $otp = Otp::firstWhere('user_id',auth()->user()-> id); 

            $otpCode = sprintf("%06d", mt_rand(1, 999999)); 
          

            if($otp == null){
              
            $newOtp = new Otp();
            $newOtp-> user_id= auth()->user()-> id; 
            $newOtp-> otp = $otpCode; 
            $newOtp-> token = $token;
            $newOtp-> expired_at = now()->addMinutes(5);
            $newOtp->save();
         

            } else {

                $newOtp = $otp;
                $newOtp-> token = $token;
                $newOtp-> otp = $otpCode;
                $newOtp-> expired_at = now()->addMinutes(5);
                $newOtp-> save();
              
            }

             Mail::to(auth()->user()-> email)->send(new otpMail(auth()->user()-> email,$otpCode));

            return response()->json([
                'expired_at'=> $otp-> expired_at,
                'token'=> $token,
            ],200);

        }
        } else{
            return response()->json(['success'=> false, 'message'=>"invalid email or password, please try again!",],401);
        }
    
    }

    
    public function verifyOtp(otpRequest $request)
    {
        
        // dd($userID);
        $otp = Otp::where('token',$request-> token)->first(); 
          
        if(!$otp){

            return response()-> json(['message'=> "unauthorized"],401);

        // } else if($otp-> token == $request-> token){

        }else if($otp-> otp == $request-> otp){
                
            
                $currentDate = strtotime(now());
                $expiredDate = strtotime($otp-> expired_at);
                
                if($currentDate < $expiredDate){ 
                    //get user information  
                    $user = User::find($otp-> user_id);

                    //Generate access token 

                    // 
                    return response()-> json([
                        'message'=> 'successfull login',
                        'token'=> $otp-> token,
                        'user'=> $user
                    ],200);
                } else {
                    return response()->json(['message'=> 'the otp code is expired'],400);
                }
                
            } else {
                return response()-> json(['message'=> 'invalid code'],400);
            }

    }
 
}
