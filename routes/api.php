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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



// Route::group(['prefix'=>'v1','namespace'=> 'App\Http\Controllers\V1\CustomerController'],function(){
//     Route::get("/customers",[CustomerController::class,'index']);
//     Route::get("/customers/findOne/{id}",[CustomerController::class,'findOne']);
//     Route::get('/customers/search/{searchTerm}',[CustomerController::class,"search"]); 
//     Route::post("/customers/createOne",[CustomerController::class,"createOne"]);
//     Route::put("/customers/updatedOne/{id}",[CustomerController::class,"updateOne"]);
//     Route::delete("/customers/deleteOne/{id}",[CustomerController::class,"deleteOne"]);
// });


Route::group(['prefix'=>'v1','namespace'=> 'App\Http\Controllers\V1\EmployeeContoller'],function(){
   
    Route::post("/employees/createOne/{departmentID}",[EmployeeContoller::class,"createNewEmployee"]); 
   
});
Route::group(['prefix'=>'v1','namespace'=> 'App\Http\Controllers\V1\DepartmentContoller'],function(){
   
    Route::post("/departments/createOne",[DepartmentContoller::class,"createNewDepartment"]);
   
});
Route::group(['prefix'=>'v1','namespace'=> 'App\Http\Controllers\V1\AuthController'],function(){
   
    Route::post("/auth/login",[AuthController::class,"login"]);
    Route::post("/auth/verifyOtp",[AuthController::class,"verifyOtp"]);
   
});

Route::group(['prefix'=>'v1','namespace'=> 'App\Http\Controllers\V1\ManagerContoller'],function(){
   
    Route::post("/managers/requestAddEmployee/{department_id}",[ManagerContoller::class,"requestAddEmployee"]);
    
   
});
Route::group(['prefix'=>'v1','namespace'=> 'App\Http\Controllers\V1\AdminContoller'],function(){
   
    Route::get("/admin/getAlladdEmployeeRequests",[AdminContoller::class,"getAddEmployeeRequests"]);
    Route::get("/admin/getAddEmployeeRequest/{user_id}",[AdminContoller::class,"getAddEmployeeRequest"]);
    Route::post("/admin/approvedAddEmployeeRequest/{user_id}",[AdminContoller::class,"approvedAddEmployeeRequest"]);
    Route::post("/admin/addNewManager",[AdminContoller::class,"addNewManager"]);
    Route::get("/admin/request/{request_id}",[AdminContoller::class,"getOneRequest"]);
    Route::get("/admin/request/all",[AdminContoller::class,"getAllRequests"]);
    Route::post("/admin/request/{request_id}",[AdminContoller::class,"approvedRequest"]);
   
});

Route::group(['prefix'=>'v1','namespace'=> 'App\Http\Controllers\V1'],function(){

    Route::post("/users/editProfile/{user_id}",[UserController::class,'editProfile']);
    Route::post("/users/setPassword/{user_id}",[UserController::class,'setPassword']);
    Route::post("/users/notifyUser/{sender_id}",[UserController::class,"notifyUser"]);
    
 
});
 Route::group(['prefix'=>'v1','namespace'=> 'App\Http\Controllers\V1\UserRequestsController'],function(){
    Route::post("/user/requests/create/{user_id}",[UserRequestsController::class,"createRequest"]);
    Route::post("/user/requests/approved/{request_id}",[UserRequestsController::class,"approvedRequest"]);
    Route::get("/user/requests/getOne/{request_id}",[UserRequestsController::class,"getOneRequest"]);
 });


