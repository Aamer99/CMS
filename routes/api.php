<?php


use App\Http\Controllers\UserContoller;
use App\Http\Controllers\V1\CustomerController;
use App\Http\Controllers\V1\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::prefix(["/customers"=> 'v1'])->group(function(){
//     Route::get("/",[CustomerController::class,'index']);
//     Route::get("/findOne/{customer}",[CustomerController::class,'findOne']);
// });

Route::group(['prefix'=>'v1','namespace'=> 'App\Http\Controllers\V1\CustomerController'],function(){
    Route::get("/customers",[CustomerController::class,'index']);
    Route::get("/customers/findOne/{id}",[CustomerController::class,'findOne']);
    Route::get('/customers/search/{searchTerm}',[CustomerController::class,"search"]); 
    Route::post("/customers/createOne",[CustomerController::class,"store"]);
});

Route::prefix("/users/v1")->group(function(){

    Route::get("/",[UserController::class,'index']);
});





