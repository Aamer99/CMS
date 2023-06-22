<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\departmentEmployeeCollection;
use App\Http\Resources\DepartmentEmployeeResource;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\EmployeeRequestsResource;
use App\Http\Resources\RequestsResource;
use App\Http\Resources\UserResource;
use App\Mail\requestNotifyMail;
use App\Models\Department;
use App\Models\DepartmentUser;
use App\Models\Request as UserRequest;
use App\Models\unapprovedUser;
use App\Models\User;
use App\Traits\HttpResponses;
use Error;
use Exception;
use Faker\Extension\Extension;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;


class ManagerController extends Controller
{


  public function requestAddEmployee(StoreUserRequest $request)
  {
    try {

      $response = Http::post("http://127.0.0.1:3000/draftDB/unapproved-users/", [
        'name' => $request->name,
        'email' => $request->email,
        'phone_number' => $request->phoneNumber,
        'department' => Department::find($request->department_id)
      ]);

      if ($response->successful()) {

        $newRequest = new unapprovedUser();
        $newRequest->user_id = $response->json();
        $newRequest->manager_id = auth()->user()->id;
        $newRequest->save();


        return $this->success(['message' => "the request send to admin successfully"], 200);
      } else {

        $status = json_decode($response->body(), true);

        if ($status["error"]["code"] == 11000) {
          return $this->error("the email address is already exist", 400);
        }

        return $this->error($status, 400);
      }
    } catch (Extension $err) {

      return $this->error($err, 400);
    } catch (ModelNotFoundException $e) {

      return $this->error($e->getMessage(), 404);
    }
  }

  public function approvedEmployeeRequest($id)
  {
    try {

      return response()->json(["request" => "aaa"],200);
      $request = UserRequest::findOrFail($id);
        
      if ($request->type = !3) {

        if ($request->department->id == auth()->user()->department->id) {

          $user = $request->owner;
          $request->status = 2;
          $request->save();

          //    Mail::to($user-> email)->queue(new requestNotifyMail($request-> request_number,$user-> name));

          return $this->success("the requests approved successfully", 200);
        } else {
          return $this->error("you don't have permission to do this", 403);
        }
      }

      return $this->error("you don't have access to this request", 401);
    } catch (Error $err) {

      return $this->error($err, 400);
    } catch (ModelNotFoundException $e) {

      return $this->error($e->getMessage(), 404);
    }
  }

  public function getMyDepartments($id)
  {

    try {

      $user = User::findOrFail($id);

      // return $this->successWithData($user->department,"success",200);



      $users = [];
      // foreach ($departments_id as $department,$index){
      //   // $users->array_push($users,$department);

      //   return $this->success($department->users,200);
      // }



      return $this->successWithData(DepartmentResource::collection($user->department), "success", 200);
    } catch (Exception $error) {
      return $this->error($error->getMessage(), 400);
    } catch (ModelNotFoundException $error) {
      return $this->error($error->getMessage(), 400);
    }
  }


  public function getEmployee($id)
  {

    try {

      $user = User::findOrFail($id);
      // dd(Department::find(2)->users()->with('role')->where('id',3)->get());

      // $employees = Department::find(2)->users()->whereHas('role', function($query) {
      //   $query->where('role', '=',3);
      // })->get();


      //    $employees = $user-> department()->users()->with(["role" => function($q){
      //     $q->where('id',3);
      // }])->get();
      $departments = collect($user->department()->with("users")->get());

      $departmentEmployees = $departments->map(function($department){

        $employees = $department->users->reject(function ($user) {
                
          return $user->role[0]->id == 2;
       });

       return ["name"=>$department->name , "employees"=> UserResource::collection($employees)] ;
          
      });
      //  $employees =  $departments->filter(function($department,$index){
      //     return $department->users->reject(function($user,$index){

      //        return $user->id > 4;
      //     });
      //   });

      // $employee = $departments->filter(function($value,$index){

      //   $users = collect($value->users[0]);
      //   dd($users->where("id","=",3));
      //   // $employee = $users->filter(function($user){
      //   //   dd($user->id);
      //   //   return $user->id == 2;
      //   // });
      //   $employee = $users->where("role","=",3);
      //   // dd($employee);
      //   return $employee;
      // });

      // $employees = $departments->filter(function ($employee, $index) {
      //   return $employee->users[$index]-> id != 2;
      // });

      // return $this->successWithData(departmentEmployeeResource::collection($departments), "success", 200);
      return $this->successWithData($departmentEmployees,"successful",200);
    } catch (Exception $error) {
      return $this->error($error->getMessage(), 400);
    }
  }




  public function  getEmployeeRequest($id)
  {
    try {

      $user = User::findOrFail($id);
     
       $requests = collect($user->department()->with("requests")->get());
    
      $employeeRequests = $requests->map(function($department,$index){


       $requests = $department->requests->reject(function ($item, $index) {
                
          return $item->type == 2 || $item->status == 2 ;
       });

       return ["name"=> $department->name , "requests"=> RequestsResource::collection($requests)];
      });
      
   


    


     

       return $this->successWithData($employeeRequests, "success", 200);
     // return $this->success($employeeRequests,200);
    } catch (Exception $error) {
      return $this->error($error->getMessage(), 400);
    }
  }
}
