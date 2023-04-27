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

        $newDepartment = new Department();
        $newDepartment-> name = $request-> name;
        $newDepartment-> save();

        return response("Department created successfully",200);
        
        } catch(Error $err){
            return response($err,400);
        }
    }

   
}
