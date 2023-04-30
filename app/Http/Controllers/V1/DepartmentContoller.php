<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Error;
use Illuminate\Http\Request;

class DepartmentContoller extends Controller
{
   
    public function createNewDepartment(Request $request)
    {
        try{

            $request->validate([
                "name"=> ["required","unique:departments"]
            ]);
        $newDepartment = new Department();
        $newDepartment-> name = $request-> name;
        $newDepartment-> save();

        return response("Department created successfully",200);
        
        } catch(Error $err){
            return response($err,400);
        }
    } 

    public function getOneDepartment(string $department_id){
        try{

            $department = Department::find($department_id);

            if($department){

                 return response()->json(["department"=> $department],200);

             }else{

                 return response()->json(["message"=> "department not found"],404);
             }

        }catch(Error $err){
            return response()->json(["message"=> $err],400);
        }
    }

    public function getAllDepartments(){
        try{ 

            $departments = Department::all();
            return response()->json(["departments"=>$departments],200);

        }catch(Error $err){
            return response()-> json(["message"=> $err]);
        }
    }

   
}
