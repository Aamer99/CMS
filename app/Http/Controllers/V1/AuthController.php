<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\otpRequest;
use App\Http\Resources\UserResource;
use App\Models\Otp;
use App\Traits\OtpOperations;
use Faker\Extension\Extension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    use OtpOperations;


    public function login(Request $request)
    {
        try {

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {


                if (!auth()->user()->is_validate) {

                    return response()->json(['message' => "you need to reset your password",], 201);
                } else {

                    // create otp 

                    $otp = $this->generateOTP();

                    //   Mail::to(auth()->user()-> email)-> queue(new otpMail($otpCode));

                    return $this->successWithData($otp, "successful", 200);
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

            if (!$otp) {

                return $this->error("Unauthorized!", 401);

            } else if ($otp->otp == $request->otp) {


                $currentDate = strtotime(now());
                $expiredDate = strtotime($otp->expired_at);

                if ($currentDate < $expiredDate) {


                    //Generate  token 
                    $token = auth()->user()->createToken('token')->accessToken;

                    return $this->successWithData([
                        'token' => $token,
                        'user' => new UserResource($otp->user),
                    ], "successful login", 200);
                } else {
                    return $this->error('the otp code is expired', 400);
                }
            } else {
                return $this->error('invalid code', 400);
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

    public function setPassword(Request $request)
    {
        try {

            $request->validate([
                'current_password' => ['required'],
                'password' => ['required', 'min:6', 'confirmed']
            ]);

            $currentUser = auth()->user();
            $checkPassword = Hash::check($request->current_password, $currentUser->password);




            if ($checkPassword) {

                $currentUser->password = Hash::make($request->password);
                $currentUser->is_validate = true;
                $currentUser->save();
                Auth::logout();

                return $this->success(["password reset successfully"], 200);

            } else {
                return $this->error("password is wrong", 400);
            }
        } catch (Extension $err) {

            return $this->error($err, 400);
        }
    }
}
