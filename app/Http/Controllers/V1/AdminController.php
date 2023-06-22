<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;

use App\Classes\CustomUser;
use Illuminate\Http\Request;

use App\Http\Requests\ApprovedManagerRequests;
use App\Http\Requests\StoreUserRequest;

use App\Http\Resources\RequestsResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Services\AdminService;
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
use App\Models\RoleUser;
use App\Models\unapprovedUser as UnapprovedUserModel;
use App\Models\usersRoles;
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
                return $this->successWithData($usersArr, "successful", 200);
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


                    $created = AdminService::createEmployee($request,$userData); 

                    if ($created['status'] == true) {

                        return $this->successWithData($created["data"], "success", 200);
                    } else {
                        return $this->error($created["data"], 404);
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

            
            // return response()->json(['created' => $request]);
            $adminService = new AdminService();
            $created = $adminService->createManager($request); 
          

            if ($created["status"] == true) {
                return $this->successWithData(new UserResource($created["data"]), "success", 200);
            } else {
                return $this->error($created["data"], 404);
            }
        } catch (Extension $err) {
            return response()->json(["message" => $err], 400);
        }
    }


    public function getManagers(){
         
        $manager = Role::find(2)->users;

        return response()-> json(["managers" => UserResource::collection($manager),200]);
    }

    public function getManagerRequests(){

        $request = UserRequest::where([["type","=",2],["status","=",1]])->with("owner")->get();

        return response()->json(["request" => RequestsResource::collection($request), 200]);

    }

    public function denyAddEmployeeRequest($id){
        try{

            $deniedUser = Http::delete("http://127.0.0.1:3000/draftDB/unapproved-users/deny/{$id}");

            if($deniedUser->successful()){
                return $this->success("user denied successfully",200);
            } else {
                switch ($deniedUser->status()) {
                    case 404:
                        return $this->error("user not found", 404);
                    default:
                        return $this->error("please try again later", 400);
                }
            }
            
        }catch(Exception $e){
            return $this->error($e->getMessage(),400);
        }
       

    }
}
