<?php

namespace App\Http\Controllers\V1;

use App\Classes\CustomUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApprovedManagerRequests;
use App\Http\Requests\StoreUserRequest;

use App\Http\Resources\RequestsResource;
use App\Http\Resources\UserCollection;
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
use App\Models\unapprovedUser as UnapprovedUserModel;

use Exception;
use Faker\Extension\Extension;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{


    public function getAllAddEmployeeRequests()
    {
        try {

            $response =  Http::get("http://127.0.0.1:3000/draftDB/unapproved-users");

            if ($response->successful()) {

                $users = $response->body();
                $usersArr = json_decode($users);

                $usersCollect =  collect($usersArr);
                // $customsData = new CustomUser();                         //seconde way but need to some work to make
                // $customizeUsers = $customsData->toArray($usersCollect);

                return $this->successWithData(new UserCollection($usersCollect), "successful", 200);
            } else {
                return $this->error("please try again later", 400);
            }
        } catch (Exception $err) {
            return $this->error($err, 400);
        }
    }



    public function getAddEmployeeRequest($id)
    {
        try {

            $response =  Http::get("http://127.0.0.1:3000/draftDB/unapproved-users/{$id}");

            if ($response->successful()) {

                $userInfo = json_decode($response->body(), true);

                //     $userInfoCollect = collect($userInfo)->map(function ($value, $key) {
                //         dd($value)
                // });


                Arr::forget($userInfo, ["__v"]);
                Arr::set($userInfo, "_id", 1);

                return $this->successWithData($userInfo, "successful", 200);
            } else {
                switch ($response->status()) {
                    case 404:
                        return $this->error("user not found", 404);
                    default:
                        return $this->error("please try again later", 400);
                }
            }
        } catch (Extension $err) {
            return $this->error($err, 400);
        }
    }


    public function approvedManagerRequests(ApprovedManagerRequests $request)
    {
        try {

            if ($request->request_type == 1) {

                $userData = Http::post("http://127.0.0.1:3000/draftDB/unapproved-users/approved/{$request->user_id}");


                if ($userData->successful()) {

                    $employeePassword = Str::random(10);
                    $employeeDataArr = json_decode($userData->body(), true);
                    $requestInfo = UnapprovedUserModel::where('user_id', $request->user_id)->get();


                    if ($requestInfo) {

                        $newEmployee = new User();
                        $newEmployee->name = $employeeDataArr['name'];
                        $newEmployee->email = $employeeDataArr['email'];
                        $newEmployee->password = Hash::make($employeePassword);
                        $newEmployee->phoneNumber = $employeeDataArr["phone_number"];
                        $newEmployee->department_id = $employeeDataArr["department_id"];
                        $newEmployee->is_validate = false;

                        $newEmployee->save();


                        UnapprovedUser::destroy($requestInfo[0]["id"]);
                        //  Mail::to($employee-> email)->queue(new welcomeMail($employee-> email,$employee-> name,$employeePassword,$employee-> type));
                        //  Mail::to($employee-> email)->queue(new notifyMail($department -> name." Department"," ","Welcome! We’re thrilled to have you with us. We had a lot of applicants, and we chose you because we believe that your skills, experience and creativity will have a real impact on our team. We're so excited to have you be part of our team, and we can’t wait to see what you do!"))

                        return $this->successWithData([$newEmployee], "successful", 200);
                    } else {
                        return $this->error("user not found", 404);
                    }
                } else {
                    switch ($userData->status()) {
                        case 404:
                            return $this->error("user not found", 404);
                        case 400:
                            return $this->error("please try again later", 400);
                        default:
                            return $this->error($userData->status(), 400);
                    }
                }
            } else {

                $request = UserRequest::findOrFail($request->request_id);

                $request->status = 2;
                $request->save();

                $user = $request->owner;

                // Mail::to($user-> email)->queue(new requestNotifyMail($request-> request_number, $user-> name));

                return $this->successWithData(new RequestsResource($request), "the request approved successfully!", 200);
            }
        } catch (Extension $err) {
            return response()->json(['message' => $err], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function addNewManager(StoreUserRequest $request)
    {
        try {

            $department = Department::findOrFail($request->department_id);

            $newManager = new User();
            $newManager->name = $request->name;
            $newManager->email = $request->email;
            $managerPassword = Str::random(10);
            $newManager->password = Hash::make($managerPassword);
            $newManager->phoneNumber = $request->phoneNumber;
            $newManager->department_id = $department->id;
            $newManager->is_validate = false;
            $newManager->save();
            $managerRole = Role::find(2);
            $newManager->role()->attach($managerRole);
            // Mail::to($newManager-> email)->queue(new welcomeMail($newManager-> email,$newManager-> name,$managerPassword,$newManager-> type));

            return $this->success("the manager created successfully", 200);
        } catch (Extension $err) {
            return response()->json(["message" => $err], 400);
        } catch (ModelNotFoundException $e) {
            return $this->error($e->getMessage(), 404);
        }
    }


}
