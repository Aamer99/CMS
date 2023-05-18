<?php



use App\Http\Controllers\V1\AdminController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\DepartmentController;
use App\Http\Controllers\V1\ManagerController;
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\UserRequestsController;
use Illuminate\Support\Facades\Route;




Route::post("v1/auth/login",[AuthController::class,"login"]);
Route::post("v1/auth/reset-password",[AuthController::class,'setPassword']);
Route::post("v1/auth/otp",[AuthController::class,"verifyOtp"]); 

Route::get("v1/getAllUsers",[UserController::class,"getAllUsers"]);




Route::prefix('/')->middleware("auth:api")->group(function(){


    Route::post("v1/auth/logout",[AuthController::class,"logout"]);
    

    //admin 

    Route::group(["prefix"=> "v1/admin","middleware"=>"App\Http\Middleware\AdminAuth"],function(){
        Route::post("/requests/approved",[AdminController::class,"approvedManagerRequests"]);
        Route::get("/requests/employees/{user_id}",[AdminController::class,"getAddEmployeeRequest"]);
        Route::get("requests/employees",[AdminController::class,"getAllAddEmployeeRequests"]);
        Route::get('/requests/managers/{request_id}',[UserRequestsController::class,"getOneRequest"]);
        Route::post("/managers",[AdminController::class,"addNewManager"]);
        Route::post("/departments",[DepartmentController::class,"createNewDepartment"]);
        Route::get("/departments/{id}",[DepartmentController::class,"getOneDepartment"]);
        Route::get("/departments",[DepartmentController::class,"getAllDepartments"]);
        Route::get("/departments/requests/{id}",[DepartmentController::class,"getAllDepartmentRequests"]);

    });

    // manager 

    Route::group(["prefix"=> "v1/manager","middleware"=>"App\Http\Middleware\ManagerAuth"],function(){

          Route::post("/requests/employees",[ManagerController::class,"requestAddEmployee"]);
          Route::post("/employees/requests/approved/{id}",[ManagerController::class,"approvedEmployeeRequest"]);

    });

    //manager and employee 

    Route::group(["prefix"=> "v1/users/"],function(){

        Route::get("requests/{id}",[UserRequestsController::class,"getOneRequest"]);
        Route::get("my-requests/{user_id}",[UserRequestsController::class,"getUserRequests"]);
        Route::delete("requests/deny/{id}",[UserRequestsController::class,"denyRequest"]);
        Route::post("requests",[UserRequestsController::class,"createRequest"]);
        Route::put("/edit-profile",[UserController::class,"editProfile"]);
        Route::post("/send-message",[UserController::class,"notifyUser"]);
        
    });


  

});