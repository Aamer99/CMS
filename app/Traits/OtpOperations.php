<?php 
namespace App\Traits;

use App\Http\Requests\otpRequest;
use App\Http\Resources\AdminResource;
use App\Http\Resources\UserResource;
use App\Models\Otp;
use Illuminate\Support\Str;
use App\Models\OtpToken;

trait OtpOperations{

    protected function generateOTP(){

        
        $token=  Str::random(100); 
        $otpCode = sprintf("%05d", mt_rand(1, 99999)); 
        $otpExpiredDate= now()->addMinutes(5);

        OtpToken::updateOrCreate(
            ['user_id' => auth()->user()->id],
           [ 'token' => $token,
            'user_id' => auth()->user()->id,
            'expires_at' => now()->addMinutes(10)
        ]); 


        Otp::updateOrCreate(
            [ 'user_id' => auth()->user()->id,]
            ,[
           'user_id' => auth()->user()->id,
           'token' => $token,
           'otp' => $otpCode,
           'expired_at' => $otpExpiredDate,
        ]);

        // if($otp){
          
        //     $newOtp = $otp;
        //     $newOtp-> token = $token-> token;
        //     $newOtp-> otp = $otpCode;
        //     $newOtp-> expired_at = $otpExpiredDate;
        //     $newOtp-> save();
     
        // } else {

        // $newOtp = new Otp();
        // $newOtp-> user_id= auth()->user()-> id; 
        // $newOtp-> otp = $otpCode; 
        // $newOtp-> token = $token-> token;
        // $newOtp-> expired_at = $otpExpiredDate;
        // $newOtp->save();
          
        // } 

        return ["otp_expired_date"=>$otpExpiredDate,"token"=>$token];

    }

    protected function check(otpRequest $request , Otp $otp){

        if (!$otp) {

            return ["message"=> "Unauthorized!", "data"=>null ,"status"=>false,"code"=> 401];

        } else if ($otp->otp == $request->otp) {


            $currentDate = strtotime(now());
            $expiredDate = strtotime($otp->expired_at);

            if ($currentDate < $expiredDate) {


                //get the user   
                $user = $otp->user;

               //Generate  token
                 $token =$user->createToken("token")->accessToken;


                   if($user->role[0]->id != 1){

           return [
                   "data"=> ['token' => $token,'user' => new UserResource($user)],
                   "message"=>"successful login",
                   "code"=> 200,
                   "status"=>true];

            }else {

                return [
                   "data"=>[ 'token' => $token,"user" => new AdminResource($user)],
                   "message"=> "successful login", 
                   "code"=>200,
                   "status"=>true];

            }
            } else {

                return ["data"=> null,"message"=> 'the otp code is expired', "code"=>400,"status"=>false];
            }
        } else {
            
            return ["data"=> null,"message"=> 'invalid code', "code"=>400,"status"=>false];
        }
    }


}
