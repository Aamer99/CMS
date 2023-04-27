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
use Illuminate\Support\Facades\Route;



 Route::prefix('/')->middleware(VerifyToken::class)->group(function(){

    //manager 

     Route::group(['prefix'=>'v1','middleware'=>'App\Http\Middleware\ManagerAuth'],function(){
   
        Route::post("/manager/requestAddEmployee/{department_id}",[ManagerContoller::class,"requestAddEmployee"]);
        
    });

    //admin 

    Route::group(['prefix'=>'v1','middleware'=>'App\Http\Middleware\AdminAuth'],function(){
   
        Route::get("/admin/getAlladdEmployeeRequests",[AdminContoller::class,"getAddEmployeeRequests"]);
        Route::get("/admin/getAddEmployeeRequest/{user_id}",[AdminContoller::class,"getAddEmployeeRequest"]);
        Route::post("/admin/approvedAddEmployeeRequest/{user_id}",[AdminContoller::class,"approvedAddEmployeeRequest"]);
        Route::post("/admin/addNewManager",[AdminContoller::class,"addNewManager"]);
        Route::post("/user/requests/approved/{request_id}",[UserRequestsController::class,"approvedRequest"]);
        Route::post("/department/createOne",[DepartmentContoller::class,"createNewDepartment"]);
        Route::delete("/user/requests/deny/{request_id}",[UserRequestsController::class,"denyRequest"]);
        
    });

    // manager and admin 

Route::group(['prefix'=>'v1','middleware'=>'App\Http\Middleware\RoleAuth'],function(){

    Route::post("/user/notifyUser/{sender_id}",[UserController::class,"notifyUser"]);
    
});

 // all users 
 Route::group(['prefix'=>'v1'],function(){

    Route::post("/user/requests/create/{user_id}",[UserRequestsController::class,"createRequest"]);
    Route::get("/user/requests/getOne/{request_id}",[UserRequestsController::class,"getOneRequest"]);
    Route::get("/user/requests/{user_id}",[UserRequestsController::class,"getUserRequests"]);
    Route::get("/user/requests/all/{user_id}",[UserRequestsController::class,"getAllRequests"]);
    Route::put("/user/editProfile/{user_id}",[UserController::class,'editProfile']);
    Route::post("/user/setPassword/{user_id}",[UserController::class,'setPassword']);
    
 });

 });


Route::group(['prefix'=>'v1','namespace'=> 'App\Http\Controllers\V1\AuthController'],function(){
   
    Route::post("/auth/login",[AuthController::class,"login"]);
    Route::post("/auth/verifyOtp",[AuthController::class,"verifyOtp"]);
    Route::post("/auth/logout",[AuthController::class,"logout"]);

    Route::post("/auth/requestFile",[UserRequestsController::class,"uploadFile"]);
   
});



// Route::group(['prefix'=>'v1','namespace'=> 'App\Http\Controllers\V1\AdminContoller'],function(){
   
//     Route::get("/admin/getAlladdEmployeeRequests",[AdminContoller::class,"getAddEmployeeRequests"]);
//     Route::get("/admin/getAddEmployeeRequest/{user_id}",[AdminContoller::class,"getAddEmployeeRequest"]);
//     Route::post("/admin/approvedAddEmployeeRequest/{user_id}",[AdminContoller::class,"approvedAddEmployeeRequest"]);
//     Route::post("/admin/addNewManager",[AdminContoller::class,"addNewManager"]);
//     Route::get("/admin/request/{request_id}",[AdminContoller::class,"getOneRequest"]);
//     Route::get("/admin/request/all",[AdminContoller::class,"getAllRequests"]);
//     Route::post("/admin/request/{request_id}",[AdminContoller::class,"approvedRequest"]);
   
// });

// Route::group(['prefix'=>'v1','namespace'=> 'App\Http\Controllers\V1'],function(){

//     Route::post("/users/editProfile/{user_id}",[UserController::class,'editProfile']);
//     Route::post("/users/setPassword/{user_id}",[UserController::class,'setPassword']);
//     Route::post("/users/notifyUser/{sender_id}",[UserController::class,"notifyUser"]);
    
// });

//  Route::group(['prefix'=>'v1','namespace'=> 'App\Http\Controllers\V1\UserRequestsController'],function(){
//     Route::post("/user/requests/create/{user_id}",[UserRequestsController::class,"createRequest"]);
//     Route::post("/user/requests/approved/{request_id}",[UserRequestsController::class,"approvedRequest"]);
//     Route::get("/user/requests/getOne/{request_id}",[UserRequestsController::class,"getOneRequest"]);
//     Route::get("/user/requests/{user_id}",[UserRequestsController::class,"getUserRequests"]);
//     Route::get("/user/requests/all/{user_id}",[UserRequestsController::class,"getAllRequests"]);
//     Route::delete("/user/requests/deny/{request_id}",[UserRequestsController::class,"denyRequest"]);
//  });


