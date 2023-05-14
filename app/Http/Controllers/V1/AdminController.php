<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\RequestsResource;
use App\Http\Resources\UserResource;
use App\Mail\notifyMail;
use App\Mail\requestNotifyMail;
use App\Mail\welcomeMail;
use App\Models\Department;
use App\Models\Role;
use App\Models\UnapprovedUser;
use App\Models\User;
use App\Traits\HttpResponses;
use Error;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Request as UserRequest;

class AdminController extends Controller
{
    
    
    public function getAllAddEmployeeRequests()
    {
         try{ 

           $users = UnapprovedUser::all();

           return $this->successWithData($users,"successful",200);

         }catch(Error $err){
            return $this->error($err,400);
         }
    }

    

    public function getAddEmployeeRequest($id)
    {
        try{

            $user =new UserResource (UnapprovedUser::findOrFail($id));

        
        return $this->successWithData(new UserResource($user),"successful",200);

        } catch(ModelNotFoundException $err){
            return $this->error($err->getMessage(),404);
        }
    }

  
    public function approvedManagerRequests(Request $request)
    {
        try{ 

            $request->validate([
             'request_type'=> ['required', 'integer'],
             'user_id'=> ['integer',"required_if:request_type,1"],
             'request_id'=> ['integer',"required_if:request_type,2"],

            ]);

            if($request-> request_type == 1){ 

                $userRole = Role::find(3);  

                $employee = $userRole->unapprovedUsers->find($request-> user_id);

                if($employee){

                 $newEmployee = $this->approveAddNewEmployee($employee);

                return $this->successWithData($newEmployee,"the request approved successfully",200);

                }else{
                    return $this->error("the user not exist",404);
                }

            }else{

            $request =UserRequest::findOrFail($request->request_id);

            $request->status = 2;
            $request-> save();

            $user = $request->owner;
          
            // Mail::to($user-> email)->queue(new requestNotifyMail($request-> request_number, $user-> name));

            return $this->successWithData(new RequestsResource($request),"the request approved successfully!",200);
        }

        }catch(Error $err){
            return response()-> json(['message'=> $err],400);

        } catch(ModelNotFoundException $e){

            return response()-> json(['message'=> $e->getMessage()],404);
        }
    }

    public function addNewManager(StoreUserRequest $request){
        try{

            $department = Department::findOrFail($request-> department_id);

                $newManager = new User();
                $newManager-> name = $request-> name; 
                $newManager-> email = $request-> email;
                $managerPassword = Str::random(10);
                $newManager-> password = Hash::make($managerPassword);
                $newManager-> type = 1;
                $newManager-> phoneNumber = $request-> phoneNumber; 
                $newManager-> department_id = $department-> id;
                $newManager-> is_validate = false;
                $newManager-> save();  
    
                // Mail::to($newManager-> email)->queue(new welcomeMail($newManager-> email,$newManager-> name,$managerPassword,$newManager-> type));
    
                return $this->success("the manager created successfully",200); 

        }catch(Error $err){
            return response()->json(["message"=> $err],400);
        } 
        catch(ModelNotFoundException $e){
            return $this->error($e->getMessage(),404);
        }

    }   


    public function approveAddNewEmployee(UnapprovedUser $employee){

        $newEmployee = new User();
        $newEmployee-> name = $employee-> name;
        $newEmployee-> email = $employee-> email;
        $newEmployee-> password = $employee-> password;
        $newEmployee-> phoneNumber = $employee->phoneNumber;
        $newEmployee-> type = $employee->type;
        $newEmployee-> department_id = $employee->department_id;
        $newEmployee-> is_validate = $employee->is_validate;
        $newEmployee-> save(); 
        $employee->delete();
//  Mail::to($employee-> email)->queue(new welcomeMail($employee-> email,$employee-> name,$employeePassword,$employee-> type));
//  Mail::to($employee-> email)->queue(new notifyMail($department -> name." Department"," ","Welcome! We’re thrilled to have you with us. We had a lot of applicants, and we chose you because we believe that your skills, experience and creativity will have a real impact on our team. We're so excited to have you be part of our team, and we can’t wait to see what you do!"))

      return true;
    }
}
