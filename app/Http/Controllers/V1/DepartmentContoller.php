<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Traits\HttpResponses;
use Error;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DepartmentContoller extends Controller
{

    use HttpResponses;

   
    public function createNewDepartment(Request $request)
    {
        try{

            $request->validate([
                "name"=> ["required","unique:departments"]
            ]);

        $newDepartment = new Department();
        $newDepartment-> name = $request-> name;
        $newDepartment-> save();

        return $this->success($newDepartment,"Department created successfully",200);
        
        } catch(Error $err){
            return $this->error($err,400);
        }
    } 

    public function getOneDepartment($id){
        try{

            $department = Department::findOrFail($id);

                 return $this->success($department,"successful",200);

        }catch(Error $err){
            return $this->error($err,400);
        }
        catch(ModelNotFoundException $e){
            return $this->error($e,404);
        }
    }

    public function getAllDepartments(){
        try{ 

            $departments = Department::all();
            return $this->success($departments,"successful",200);
           

        }catch(Error $err){
            return $this->error($err,400);
        }
    }

    public function getAlldepartmentRequests($id){
        try{

            $departmentRequests = Department::findOrFail($id)-> requests;

            return $this->success($departmentRequests,"successfull",200);


        }catch(Error $err){
            return $this->error($err,400);
        } catch(ModelNotFoundException $e){
            return $this->error("the department not exist",404);
        }
    }
   
}
