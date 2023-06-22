<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\otpRequest;
use App\Http\Requests\ReSetPasswordRequest;
use App\Http\Resources\AdminResource;
use App\Http\Resources\UserResource;
use App\Http\Services\AuthServices;
use App\Mail\otpMail;
use App\Models\Otp;
use App\Models\User;
use App\Models\ValidationToken;
use App\Traits\OtpOperations;
use Faker\Extension\Extension;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\Bridge\AccessToken;
use Laravel\Passport\Passport;

class AuthController extends Controller
{
    use OtpOperations;


    public function login(Request $request)
    {
        try {

            $this->validate($request, [
                'email' => 'required|email',
                'password'=> 'required',
            ]);


            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {

                $currentUser = User::where('email', $request->email)->first();

                $authService = new AuthServices();

                $check = $authService->check($currentUser);

                if($check["status"] == true){
                    Mail::to($request->email)-> queue(new otpMail($check["code"]));
                    
                    return $this->successWithData($check["data"], $check["message"], $check["code"]);
                } else {
                    return $this->successWithData($check["data"],$check["message"], $check["code"]);
                }
              
            } else {
                return $this->error("invalid email or password, please try again!", 401);
            }
        } catch (Extension $err) {
            $this->error($err, 400);
        }
    }



    public function verifyOtp(otpRequest $request)
    {
        try {

            $otp = Otp::where('token', $request->token)->first();

            $check = $this->check($request, $otp);



            if ($check["status"] == true) {
                return $this->successWithData($check["data"], $check["message"], $check["code"]);
            } else {
                return $this->error($check["message"], $check["code"]);
            }
        } catch (Extension $err) {
            return $this->error($err, 400);
        }
    }



    public function logout()
    {
        try {

            auth()->user()->token()->revoke();

            return $this->success("logged out successfully", 200);
        } catch (Extension $err) {
            return $this->error($err, 400);
        }
    }

    

    public function setPassword(ReSetPasswordRequest $request)
    {
        try {

           

            $checkToken = ValidationToken::where('token',$request->token)->first();

            if($checkToken){

                $currentUser = $checkToken->user;
                $authService = new AuthServices();
               $resetPassword = $authService->resetPassword($currentUser,$request);

               if($resetPassword["status"] == true){
                   return $this->success($resetPassword["message"],$resetPassword["code"]);
               }else {
                return $this->error($resetPassword["message"],$resetPassword["code"]);
               }
                
            } else {

                return $this->error("unauthorized", 401);
            }

        } catch (Extension $err) {

            return $this->error($err, 400);
        }
    }

    public function reSetPassword(ReSetPasswordRequest $request)
    {
        try {

                $currentUser = auth()->user();
                $authService = new AuthServices();
                $resetPassword = $authService->resetPassword($currentUser,$request);

               if($resetPassword["status"] == true){
                Auth::user()->token()->revoke();
                   return $this->success($resetPassword["message"],$resetPassword["code"]);
               }else {
                return $this->error($resetPassword["message"],$resetPassword["code"]);
               }
                
            

        } catch (Extension $err) {

            return $this->error($err, 400);
        }
    }
}
