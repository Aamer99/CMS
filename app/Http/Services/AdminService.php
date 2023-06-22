<?php

namespace App\Http\Services;

use App\Http\Requests\ApprovedManagerRequests;
use App\Http\Requests\StoreUserRequest;
use App\Mail\welcomeMail;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Support\Str;
use App\Models\unapprovedUser as UnapprovedUserModel;
use App\Models\UnapprovedUser;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminService

{

    public static function createEmployee(ApprovedManagerRequests $request, Response $userData)
    {

        $employeePassword = Str::random(10);
        $employeeDataArr = json_decode($userData->body(), true);
        $requestInfo = UnapprovedUserModel::where('user_id', $request->user_id)->get();

        if ($requestInfo) {

            $newEmployee = new User();
            $newEmployee->name = $employeeDataArr['name'];
            $newEmployee->email = $employeeDataArr['email'];
            $newEmployee->password = Hash::make($employeePassword);
            $newEmployee->phoneNumber = $employeeDataArr["phone_number"];
            $newEmployee->is_validate = false;

            $newEmployee->save();

            // assigned department 
            $employeeDepartment = Department::find($employeeDataArr["department_id"]);
            $newEmployee->department()->attach($employeeDepartment);

            // assign Role 
            $employeeRole = Role::find(3);
            $newEmployee->role()->attach($employeeRole);

            UnapprovedUser::destroy($requestInfo[0]["id"]);
            //  Mail::to($employee-> email)->queue(new welcomeMail($employee-> email,$employee-> name,$employeePassword,$employee-> type));
            //  Mail::to($employee-> email)->queue(new notifyMail($department -> name." Department"," ","Welcome! We’re thrilled to have you with us. We had a lot of applicants, and we chose you because we believe that your skills, experience and creativity will have a real impact on our team. We're so excited to have you be part of our team, and we can’t wait to see what you do!"))

            return ["data" => $newEmployee, "status" => true];
        } else {
            return ["data" => "user not found", "status" => false];
        }
    }

    public static function createManager(StoreUserRequest $request)
    {

        $managerDepartment = Department::find($request->department_id);
        $managerPassword = Str::random(10);
        $managerRole = Role::find(2);

        if ($managerDepartment) {

            $newManager = new User();
            $newManager->name = $request->name;
            $newManager->email = $request->email;
            $newManager->password = Hash::make($managerPassword);
            $newManager->phoneNumber = $request->phoneNumber;
            $newManager->is_validate = false;
            $newManager->save();

            $newManager->role()->attach($managerRole);
            $newManager->department()->attach($managerDepartment);

            Mail::to($newManager-> email)->queue(new welcomeMail($newManager-> email,$newManager-> name,$managerPassword,$newManager-> type));


            return ["data" => $newManager, "status" => true];
        } else {
            return ["data" => "department not found", "status" => false];
        }
    }
}
