<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Mail\requestNotifyMail;
use App\Models\Department;
use App\Models\Request as UserRequest;
use App\Models\unapprovedUser;
use App\Models\User;
use App\Traits\HttpResponses;
use Error;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ManagerController extends Controller
{

   
    
    public function requestAddEmployee(StoreUserRequest $request)
    {
       try{

      $response = Http::post("http://127.0.0.1:3000/draftDB/unapproved-users/",[
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phoneNumber,
            'department_id' => 3
        ]); 

        if($response->successful()){

          $newRequest = new unapprovedUser();
          $newRequest-> user_id = $response->json();
          $newRequest-> manager_id = auth()->user()->id;
          $newRequest->save();
                

        return $this->success(['message' => "the request send to admin successfully"],200);

        }else{

          $status = json_decode($response->body(),true);

            if($status["error"]["code"]==11000){
              return $this->error("the email address is already exist",400);
            } 

          
          return $this->error($status,400);
        }
        
       } catch(Error $err){

            return $this->error($err,400);

       }catch(ModelNotFoundException $e){

            return $this->error($e,404);

       }
    }

    public function approvedEmployeeRequest($id){
        try{

            //  $request = UserRequest::where(["id"=> $request_id,"type"=> 2,"status"=> 0])->first();  

            $request = UserRequest::findOrFail($id);

            

            if($request-> type =! 3){

              if($request-> department_id == auth()->user()-> department_id){

                $user = $request-> owner; 
                $request-> status = 2; 
                $request-> save(); 
 
             //    Mail::to($user-> email)->queue(new requestNotifyMail($request-> request_number,$user-> name));
 
                return $this->success("the requests approved successfully",200); 
              } 
 
            }
             
               return $this->error("you don't have access to this request",401);
             
            


        }catch(Error $err){

            return $this->error($err,400);

        } catch(ModelNotFoundException $e){
            
            return $this->error($e->getMessage(),404);

        }
    }

    
}
