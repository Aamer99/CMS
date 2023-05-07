<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\otpRequest;
use App\Jobs\sendOtpMail;
use App\Mail\otpMail;
use App\Models\AccessToken;
use App\Models\Otp;
use App\Models\OtpToken;
use App\Models\Role;
use App\Models\TemporallyToken;
use App\Models\User;
use App\Traits\HttpResponses;
use Error;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\NewAccessToken;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request)
    {
        try{

        $credentials = $request->only('email', 'password');  

        if (Auth::attempt($credentials)) {
        
            
            if(!auth()->user()-> is_validate){

                 return response()->json(['message'=> "you need to reset your password",],201);

            } else {

            // create token 

          $token = $this->generateToken();

        //    return response()->json(["message"=> auth()->user()->otp_token],202);
           $otpExpiredDate = $this->generateOTP();
         
            //   Mail::to(auth()->user()-> email)-> queue(new otpMail($otpCode));

           return $this->success(auth()->user(),['token'=> $token,'OTP_expired_at'=> $otpExpiredDate],200);

        }
        } else{
            return $this->error("invalid email or password, please try again!",401);
        }

    }catch(Error $err){
        $this->error($err,400);
      }
    }


    
    public function verifyOtp(otpRequest $request)
    {
        try{
        $otp = Otp::where('token',$request-> token)->first(); 
          
        if(!$otp){

            return $this->error("Unauthorized!",401);

        }else if($otp-> otp == $request-> otp){
                
            
                $currentDate = strtotime(now());
                $expiredDate = strtotime($otp-> expired_at);
                
                if($currentDate < $expiredDate){ 
                    

                    //Generate  token 
                    $token = auth()->user()->createToken('token')->accessToken; 

                    return $this->success([
                        'token'=> $token,
                        'user'=> $otp->user
                    ],"successfull login",200);
                } else {
                    return $this->error('the otp code is expired',400);
                }
                
            } else {
                return $this->error('invalid code',400);
            }
        }catch(Error $err){
            return $this->error($err,400);
        }
    } 

    public function logout()
    {
        try{

             auth()->user()->token()->revoke(); 
            
            return $this->success(null,"logged out successfully",200);

        }catch(Error $err){
            return $this->error($err,400);
        }

    }


    public function generateOTP(){

            $otp = auth()->user()->otp;
            $token= auth()->user()-> otp_token;

            $otpCode = sprintf("%06d", mt_rand(1, 999999)); 
            $otpExpiredDate = now()->addMinutes(5);

            if($otp){
              
                $newOtp = $otp;
                $newOtp-> token = $token-> token;
                $newOtp-> otp = $otpCode;
                $newOtp-> expired_at = $otpExpiredDate;
                $newOtp-> save();
         
            } else {

            $newOtp = new Otp();
            $newOtp-> user_id= auth()->user()-> id; 
            $newOtp-> otp = $otpCode; 
            $newOtp-> token = $token-> token;
            $newOtp-> expired_at = $otpExpiredDate;
            $newOtp->save();
              
            } 

            return $otpExpiredDate;
    }

    public function generateToken(){

         $existToken = auth()->user()->otp_token;
        $token =  Str::random(100);  
   
        if($existToken){
           
            $existToken-> token = $token;
            $existToken-> expires_at = now()->addMinutes(10);
            $existToken-> save();
       

        } else{
         
            $newToken = new OtpToken();
            $newToken-> token = $token;
            $newToken-> expires_at = now()->addMinutes(10);
            $newToken-> user_id = auth()->user()-> id; 
            $newToken-> save();  
          
         
        }

        return $token;
    }

    public function details(){
        
        $role = Role::find(1);
        $user = $role->user;

        return response()->json(["user"=> $user]);
    }
    
 
}
