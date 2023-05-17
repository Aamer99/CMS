<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditProfileRequest;
use App\Mail\notifyMail;
use App\Mail\welcomeMail;
use App\Models\Notify;
use App\Traits\HttpResponses;
use Error;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
   use HttpResponses;



   public function getAllUsers(){

    try{
        $users = User::all();

        return $this->successWithData([
            'users' => $users
        ],"successful",200);
    }catch(Error $e){
         return $this->error($e->getMessage(),400);
    }
   }

    public function editProfile($id,EditProfileRequest $request)
    {
        try{

        $user = User::findOrFail($id);
         
     

        $user-> name = $request-> name == null ? $user-> name : $request-> name;
        $user-> email =  $request-> email == null ? $user-> email: $request-> email; 
        $user-> password = $request-> password == null ? $user-> password : Hash::make($request-> password);
        $user-> phoneNumber = $request-> phoneNumber == null ? $user-> phoneNumber : $request-> phoneNumber; 
        $user-> save(); 

         return $this->successWithData($user,"successful",200);

     } catch(Error $err){

        return $this->error($err,400);
      }
      catch(ModelNotFoundException $e){

        return $this->error("the user not exist",404);
      }
    }

   
    public function setPassword(Request $request,$id)
    {
        try{ 

            $request-> validate([
                'password' => ['required','min:6','confirmed']
            ]);

            $user = User::findOrFail($id);
          

                $user-> password = Hash::make($request-> password); 
                $user-> is_validate = true;
                $user-> save(); 
                Auth::logout();
                
                return $this->success("password reset successfully",200);

        }catch(Error $err){

            return $this->error($err,400);

        } catch(ModelNotFoundException $e){

            return $this->error($e,404);
        }
    }

    public function notifyUser(Request $request)
    {
        try{
           
            $request->validate([
                "message"=> ['required'],
                "received_id" => ['required']
            ]); 

            $sender = auth()->user();
            $received = User::findOrFail($request-> received_id);

            if($sender-> type == 1 || $sender-> type == 2){
        
                    if($received-> id != $sender-> id){
                        
                       $newNotify = new Notify();
                       $newNotify-> sender_id = $sender-> id;
                       $newNotify-> received_id = $received-> id; 
                       $newNotify-> message = $request-> message; 
                       $newNotify-> save() ; 

                    //    Mail::to($received-> email)->queue(new notifyMail($sender-> name,$sender-> email,$request-> message));

                       return $this->success("the message send successfully",200);

                       
                    } else{

                        return $this->error("you can't send message to your self",400);
                    }

              
            } else{
                return $this->error("unauthorized",401);
            }
       
        }catch(Error $err){

            return $this->error($err,400);

        } catch(ModelNotFoundException $err){

            return $this->error("the user that you want to send him the message is not exist ",404);

        }
    }

    
}
