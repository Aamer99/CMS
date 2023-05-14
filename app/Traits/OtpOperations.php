<?php 
namespace App\Traits;

use App\Models\Otp;
use Illuminate\Support\Str;
use App\Models\OtpToken;

trait OtpOperations{

    protected function generateOTP(){

        
        $token=  Str::random(100); 
        $otpCode = sprintf("%06d", mt_rand(1, 999999)); 
        $otpExpiredDate= now()->addMinutes(6);

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


}
?>