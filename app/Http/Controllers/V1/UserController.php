<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditProfileRequest;
use App\Http\Resources\UserResource;
use App\Mail\notifyMail;
use App\Mail\welcomeMail;
use App\Models\Notify;
use Faker\Extension\Extension;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    

    public function getAllUsers()
    {

        try {
            $users = User::all();

            return $this->successWithData([
                'users' => $users
            ], "successful", 200);
        } catch (Extension $error) {
            return $this->error($error, 400);
        }
    }

    public function editProfile(EditProfileRequest $request)
    {
        try {

            $user = auth()->user();

            $checkPassword = Hash::check($request->current_password, $user->password);
            if ($request->password != null) {
                if ($checkPassword) {
                    $user->password = $request->password;
                } else {
                    return $this->error("password is incorrect", 400);
                }
            }


            $user->name = $request->name == null ? $user->name : $request->name;
            $user->email =  $request->email == null ? $user->email : $request->email;
            $user->phoneNumber = $request->phoneNumber == null ? $user->phoneNumber : $request->phoneNumber;
            $user->save();



            return $this->successWithData(new UserResource($user), "successful", 200);
        } catch (Extension $err) {

            return $this->error($err, 400);

        } catch (ModelNotFoundException $e) {

            return $this->error("the user not exist", 404);
        }
    }

    public function notifyUser(Request $request)
    {
        try {

            $request->validate([
                "message" => ['required'],
                "received_id" => ['required']
            ]);

            $sender = auth()->user();
            $received = User::findOrFail($request->received_id);

            if ($sender->role[0]->id == 1 || $sender->role[0]->id == 2) {

                if ($received->id != $sender->id) {

                    $newNotify = new Notify();
                    $newNotify->sender_id = $sender->id;
                    $newNotify->received_id = $received->id;
                    $newNotify->message = $request->message;
                    $newNotify->save();

                    //    Mail::to($received-> email)->queue(new notifyMail($sender-> name,$sender-> email,$request-> message));

                    return $this->success("the message send successfully", 200);
                } else {

                    return $this->error("you can't send message to your self", 400);
                }
            } else {
                return $this->error("unauthorized", 401);
            }
        } catch (Extension $err) {

            return $this->error($err, 400);

        } catch (ModelNotFoundException $err) {

            return $this->error("the user that you want to send him the message is not exist ", 404);
        }
    }
}
