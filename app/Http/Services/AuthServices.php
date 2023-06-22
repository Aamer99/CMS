<?php
namespace App\Http\Services;

use App\Models\User;
use App\Models\ValidationToken;
use App\Traits\OtpOperations;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthServices{

    use OtpOperations;
    public  function check(User $user){

        if (!$user->is_validate) {

            
            $token=  Str::random(100);  
            ValidationToken::updateOrCreate(
                ['user_id' => $user->id],
                ['token' => $token,'user_id' => $user->id]);


            return["data"=> $token, "message" => "you need to reset your password","status"=> false ,"code"=>  201];
        } else {

            // create otp 

            $otp = $this->generateOTP();

            //   Mail::to(auth()->user()-> email)-> queue(new otpMail($otpCode));

            return["data"=> $otp, "message" => "successful login","status"=> true ,"code"=>  200];
        }

    }

    public function resetPassword(User $user, Request $request){

        $checkPassword = Hash::check($request->current_password, $user->password);

        if ($checkPassword) {

            $user->password = Hash::make($request->password);
            $user->is_validate = true;
            $user->save();
            

            return["message"=>"password reset successfully","code"=> 200,"status"=> true ];
        } else {

            return["message"=>"password is wrong","code"=> 400,"status"=> false ];
        }

    }
}