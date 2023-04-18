<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Mail\welcomeMail;
use App\Models\User;
use Error;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmployeeContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createNewEmployee(StoreUserRequest $request,string $departmentID)
    {
        try{

        
        $newEmployee = new User();
        $employeePassowrd = Str::random(10); 

        $newEmployee-> name = $request-> name ;
        $newEmployee-> email = $request-> email;
        $newEmployee-> password = Hash::make($employeePassowrd);
        $newEmployee-> type = 1; 
        $newEmployee-> phoneNumber = $request-> phoneNumber; 
        $newEmployee-> department_id = $departmentID;
        $newEmployee-> is_validate = false;
        $newEmployee-> save(); 

        Mail::to($newEmployee-> email)->send(new welcomeMail($newEmployee-> email,$newEmployee-> name,$employeePassowrd,$newEmployee-> type));

        return response("Employee Created successfully",200);

        } catch(Error $err){
            return response($err,400);
        }
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
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
