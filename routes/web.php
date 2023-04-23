<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('otpMail',["userName"=> "amer",'userEmail'=> "amer@test.com","userPassword"=>"33333","userRole"=>"2"]);
    // return view("otpMail",['otp'=>"1234567"]);
      return view("NotifyMail",['senderEmail'=>"email@exmaple.com",'senderName'=>"Amer Essa","message"=>"test klmdlkmdlkddkmkldndld"]);
});
