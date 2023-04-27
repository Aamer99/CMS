<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\Department;
use App\Models\User;
use Error;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ManagerContoller extends Controller
{
   
    
    public function requestAddEmployee(StoreUserRequest $request,string $department_id)
    {
       try{

        $department = Department::find($department_id);

        if($department){

        $newEmployee = new User();
        $employeePassowrd = Str::random(10); 

        $newEmployee-> name = $request-> name ;
        $newEmployee-> email = $request-> email;
        $newEmployee-> password = Crypt::encrypt($employeePassowrd);
        $newEmployee-> type = 2; 
        $newEmployee-> phoneNumber = $request-> phoneNumber; 
        $newEmployee-> department_id = $department-> id;
        $newEmployee-> is_validate = false;
        $newEmployee-> approved = false;
        $newEmployee-> save();  

        return response()->json(['message'=> "the request send to admin successfully"],200);
        } 
        return response()-> json(["message"=> "the department not exist!!"],404);
       } catch(Error $err){
        return response()->json(["message"=>$err],400);
       }
    }

    
}
