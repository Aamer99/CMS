<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Mail\notifyMail;
use App\Mail\welcomeMail;
use App\Models\Department;
use App\Models\User;
use Error;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminContoller extends Controller
{
    
    
    public function getAddEmployeeRequests()
    {
         try{ 

           $users = User::where("approved",false)->get(); 

           return response()->json(["users"=>$users],200);

         }catch(Error $err){
            return response()-> json(["message"=> $err],400);
         }
    }

    

    public function getAddEmployeeRequest(Request $request,string $user_id)
    {
        try{

        $user = User::find($user_id);
        return response()->json(['user'=> $user],200);

        } catch(Error $err){
            return response()->json(["message"=> $err],400);
        }
    }

  
    public function approvedAddEmployeeRequest(string $user_id)
    {
        try{ 
            
            $employee = User::find($user_id);
            $department = Department::find($employee-> department_id);
            $employee -> approved = true; 
            $employeePassword = Crypt::decrypt($employee-> password);
            $employee-> password = Hash::make($employeePassword);
            $employee -> save();
               
             Mail::to($employee-> email)->send(new welcomeMail($employee-> email,$employee-> name,$employeePassword,$employee-> type));
             Mail::to($employee-> email)->send(new notifyMail($department -> name." Department"," ","Welcome! We’re thrilled to have you with us. We had a lot of applicants, and we chose you because we believe that your skills, experience and creativity will have a real impact on our team. We're so excited to have you be part of our team, and we can’t wait to see what you do!"));

            return response()-> json(['messsage'=> "the employee successfully approved "],200);

        }catch(Error $err){
            return response()-> json(['message'=> $err],400);
        }
    }

    public function addNewManager(StoreUserRequest $request){
        try{

            $newManager = new User();
            $newManager-> name = $request-> name; 
            $newManager-> email = $request-> email;
            $managerPassowrd = Str::random(10);
            $newManager-> password = Hash::make($managerPassowrd);
            $newManager-> type = 1;
            $newManager-> phoneNumber = $request-> phoneNumber; 
            $newManager-> department_id = $request-> department_id;
            $newManager-> is_validate = false;
            $newManager-> approved = true;
            $newManager-> save();  

            Mail::to($newManager-> email)->send(new welcomeMail($newManager-> email,$newManager-> name,$managerPassowrd,$newManager-> type));

            return response()-> json(["message"=> "the manager created successfully"],200);

        }catch(Error $err){
            return response()->json(["message"=> $err],400);
        }
    }   
}
