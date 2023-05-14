<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Mail\requestNotifyMail;
use App\Models\Department;
use App\Models\Request as UserRequest;
use App\Models\UnapprovedUser;
use App\Models\User;
use App\Traits\HttpResponses;
use Error;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ManagerController extends Controller
{

   
    
    public function requestAddEmployee(StoreUserRequest $request)
    {
       try{

        $department = Department::findOrFail($request-> department_id);

        $newEmployee = new UnapprovedUser();
        $employeePassword = Str::random(10); 

        $newEmployee-> name = $request-> name ;
        $newEmployee-> email = $request-> email;
        $newEmployee-> password = Crypt::encrypt($employeePassword);
        $newEmployee-> type = 3; 
        $newEmployee-> phoneNumber = $request-> phoneNumber; 
        $newEmployee-> department_id = $department-> id;
        $newEmployee-> is_validate = false;
        $newEmployee-> save();  

        return $this->success("the request send to admin successfully",200);
      
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
