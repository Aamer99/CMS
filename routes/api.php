<?php


use App\Http\Controllers\UserContoller;
use App\Http\Controllers\V1\AdminContoller;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\CustomerController;
use App\Http\Controllers\V1\DepartmentContoller;
use App\Http\Controllers\V1\EmployeeContoller;
use App\Http\Controllers\V1\ManagerContoller;
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\RequestController as V1RequestController;
use App\Http\Controllers\V1\UserRequestsController;
use App\Http\Middleware\VerifyToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;





Route::post("v1/auth/login",[AuthController::class,"login"]);
Route::post("v1/user/setPassword/{user_id}",[UserController::class,'setPassword']);
Route::post("v1/auth/verifyOtp",[AuthController::class,"verifyOtp"]); 


Route::prefix('/')->middleware("auth:api")->group(function(){

    //admin 

    Route::group(["prefix"=> "v1/admin","middleware"=>"App\Http\Middleware\AdminAuth"],function(){

        Route::get("/requests/AddEmployee/getOne/{user_id}",[AdminContoller::class,"getAddEmployeeRequest"]);
        Route::get("/requests/AddEmployee/getAll",[AdminContoller::class,"getAllAddEmployeeRequests"]);
        Route::post("/requests/approved",[AdminContoller::class,"approvedManagerRequests"]);
        Route::get('/requests/manager/getOne/{request_id}',[UserRequestsController::class,"getOneRequest"]);
        Route::post("/addNewManager",[AdminContoller::class,"addNewManager"]);
        Route::post("/department/createOne",[DepartmentContoller::class,"createNewDepartment"]);
        Route::get("/department/getOne/{department_id}",[DepartmentContoller::class,"getOneDepartment"]);
        Route::get("/department/all",[DepartmentContoller::class,"getAllDepartments"]);
        Route::get("/department/requests/{department_id}",[DepartmentContoller::class,"getAlldepartmentRequests"]);

    });

    Route::group(["prefix"=> "v1/manager","middleware"=>"App\Http\Middleware\ManagerAuth"],function(){

          Route::post("/request/addNewEmployee",[ManagerContoller::class,"requestAddEmployee"]);
          Route::post("/request/approved/{request_id}",[ManagerContoller::class,"approvedEmployeeRequest"]);

    });

    Route::group(["prefix"=>"v1/user/"],function(){

        Route::put("/editProfile/{user_id}",[UserController::class,"editProfile"]);
        Route::post("/sendMessage/{user_id}",[UserController::class,"notifyUser"]);
        Route::post("/logout",[AuthController::class,"logout"]);

    });

    Route::group(["prefix"=> "v1/request/"],function(){

        Route::get("/data/{request_id}",[UserRequestsController::class,"getOneRequest"]);
        Route::get("/data/userRequests/{user_id}",[UserRequestsController::class,"getUserRequestsByID"]);
        Route::get("/data/departmentRequests/{department_request}",[UserRequestsController::class,"getDepartmentRequests"]);
        Route::delete("/deny/{request_id}",[UserRequestsController::class,"denyRequest"]);
        Route::post("/createOne/{user_id}",[UserRequestsController::class,"createRequest"]);
        
    });
});