<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditProfileRequest;
use App\Mail\notifyMail;
use App\Mail\welcomeMail;
use App\Models\Notify;
use Error;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
   

    public function editProfile(string $user_id,EditProfileRequest $request)
    {
        try{
        $user = User::find($user_id);
         
        $user-> name = $request-> name ;
        $user-> email = $request-> email; 
        $user-> password = $request-> password;
        $user-> phoneNumber = $request-> phoneNumber; 
        $user-> save(); 

         return response()->json(["message"=> "successful"],200);

     } catch(Error $err){

        return response()->json(["message"=> $err],400);
      }
    }

   
    public function setPassword(Request $request,string $user_id)
    {
        try{ 

            $request-> validate([
                'password' => ['required','min:6','confirmed']
            ]);

            $user = User::find($user_id);
            $user-> password = Hash::make($request-> password); 
            $user-> is_validate = true;
            $user-> save();
            return response()-> json(["message"=> 'set password successfully'],200);

        }catch(Error $err){
            return response()-> json(["message"=> $err],400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function notifyUser(string $sender_id,Request $request)
    {
        try{
           
            $request->validate([
                "message"=> ['required'],
                "received_id" => ['required']
            ]); 

            $sender = User::find($sender_id);
            $received = User::find($request-> received_id);

            if($sender-> type == 0 || $sender-> type == 1){
                if($received){

                    if($received-> id != $sender-> id){
                        
                       $newNotify = new Notify();
                       $newNotify-> sender_id = $sender-> id;
                       $newNotify-> received_id = $received-> id; 
                       $newNotify-> message = $request-> message; 
                       $newNotify-> save() ; 

                       Mail::to($received-> email)->send(new notifyMail($sender-> name,$sender-> email,$request-> message));

                       return response()-> json(["message"=> "the message send successfully "],200);

                       
                    } else{
                        return response()-> json(["message"=> "you can't send message to your self"],400);
                    }
                } else{
                    return response()->json(["message"=> "the user not exis!t"],404);
                }
              
            } else{
                return response()->json(["message"=> "unauthorized"],401);
            }
        }catch(Error $err){
            return response()-> json(["message"=> $err],400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
