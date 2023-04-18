<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
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

        $newEmployee = new User();
        $employeePassowrd = Str::random(10); 

        $newEmployee-> name = $request-> name ;
        $newEmployee-> email = $request-> email;
        $newEmployee-> password = Crypt::encrypt($employeePassowrd);
        $newEmployee-> type = 2; 
        $newEmployee-> phoneNumber = $request-> phoneNumber; 
        $newEmployee-> department_id = $department_id;
        $newEmployee-> is_validate = false;
        $newEmployee-> approved = false;
        $newEmployee-> save();  

        return response()->json(['message'=> "the request send to admin successfully"],200);
       } catch(Error $err){
        return response()->json(["message"=>$err],400);
       }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
