<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests;
use App\Mail\requestNotifyMail;
use App\Mail\sendedRequestMail;
use App\Models\Department;
use App\Models\File;
use App\Models\Request as UserRequest;
use App\Models\User;
use Error;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class UserRequestsController extends Controller
{
    
    public function getOneRequest(string $request_id){
        try{

            $request = UserRequest::find($request_id);

            if($request){

             return response()-> json(["request"=> $request],200);

            } else{

                return response()-> json(["message"=> "not found"],404);
            }

        }catch(Error $err){

            return response()-> json(["message"=> $err],400);
        }
    }

   
    public function approvedManagerRequest(string $request_id){
        try{

            $request = UserRequest::where(["id"=> $request_id,"type"=>1,"status"=>0])-> first(); 
            

            if($request){
                

              $user = User::find($request-> owner_id);
              $request-> status = 1; 
              $request-> save(); 

              Mail::to($user-> email)->queue(new requestNotifyMail($request-> request_number, $user-> name));

              return response()-> json(["message"=> "the requests approved successfully "],200);
               

            } else{

                return response()-> json(["message"=> "the request not found"],404);
            }

        }catch(Error $err){

            return response()-> json(["message"=> $err],400);
        }
    }

    

    public function approvedEmployeeRequest(string $request_id){
        try{

             $request = UserRequest::where(["id"=> $request_id,"type"=> 2,"status"=> 0])->first(); 
            

             if($request){
                if($request-> department_id == auth()->user()-> department_id){

               $user = User::find($request-> owner_id);
               $request-> status = 1; 
               $request-> save(); 

               Mail::to($user-> email)->queue(new requestNotifyMail($request-> request_number,$user-> name));

               return response()-> json(["message"=> "the requests approved successfully "],200);
             }else{

               return response()-> json(["message"=> "you don't have access to this request "],401);
             }
            

            } else{

                return response()-> json(["message"=> "the request not found"],404);
            }

        }catch(Error $err){

            return response()-> json(["Error message"=> $err],400);
        }
    }

    public function denyRequest(string $request_id){
        try{

            $request = UserRequest::find($request_id);
            $user = User::find($request-> owner_id);
            if($request){ 
            $request-> delete();
            
            Mail::to($user-> email)->queue(new requestNotifyMail($request-> request_number,$user-> name));

            return response()->json(["message"=>" the request denied successfully "],200);
            } else{

                return response()->json(["message"=> "the request not found"],404);
            }

        }catch(Error $err){
            return response()-> json(["message"=> $err],400);
        }
    }

    public function getDepartmentRequests(){
        try{

            $department = Department::find(auth()-> user()-> department_id); 

            if($department){

                    $requests = UserRequest::where(["owner_id"=> !auth()-> user()-> id,"type"=> 1,"status"=> 0])-> get();
                    if(count($requests)){
                    return response()->json(["requests"=> $requests],200);
                     } else {
                        return response()->json(["message"=> "there is no requests found","code"=> 4040],404);
                    }
                
            } else {
                return response()-> json(["message"=> "the department not exist","code"=> 4041],404);
            }


        }catch(Error $err){
            return response()-> json(["message"=> $err],400);
        }

    }


    public function getManagerRequests(string $user_id){
        try{

            $requests = UserRequest::where(["status"=> 0 ,"type"=> 1,"owner_id"=> $user_id])->get();

            if(count($requests)){
            return response()->json(["message"=>$requests]);
            }else{
                return response()->json(["message"=> "there is no requests"],404);
            }
        }catch(Error $err){
            return response()->json(["message"=> $err],400);
        }
    }

    public function getUserRequests(string $user_id){
        try{

            $request = UserRequest::where("owner_id",$user_id)->get(); 

            return response()-> json(["requests"=> $request]);

        }catch(Error $err){
            return response()-> json(["messsage"=> $err],400);
        }
    }

    public function createRequest(StoreRequests $request,string $user_id){
        try{

            $user = User::find($user_id);
 
            if($user){

                // $request_number = $user-> type == 1 ? 'M-' : "E-";
                $request_number = Str::random(2) . '-'.sprintf("%06d", mt_rand(1, 9999999));

               $file_id = $this->uploadFile($request,$request_number);
               if($file_id){

                $newRequest = new UserRequest(); 
                $newRequest-> file_id = $file_id;
                $newRequest-> owner_id = $user-> id; 
                $newRequest-> department_id = $user-> department_id;
                $newRequest-> type = $user-> type; 
                $newRequest-> status = 0;
                $newRequest-> request_number = $request_number;
                $newRequest-> description = $request-> description; 
                $newRequest-> save(); 
                  $date = date("l d F Y");
                 Mail::to($user-> email)->queue(new sendedRequestMail($newRequest-> request_number,$date));

              return response()-> json(["message"=> "the request send successfully"],200);
               } else{
                return response()-> json(["message"=> "please check your file"],400);
               }

            } else{
                
                return response()-> json(["message"=> "sorry the user not exist "],400);
            }

        }catch(Error $err){
            return response()-> json(["message"=> $err],400);
        }
    }

    public function uploadFile(Request $request,string $request_id){
        try{

            if($request-> hasFile("requestFile")){

                $filePath = $request->file('requestFile')->store('requestsFile','public'); 
                $newFile = new File();
                $newFile-> file_path = $filePath;
                $newFile-> request_id = $request_id;
                $newFile-> file_type = $request->file("requestFile")->getMimeType();  
                $newFile-> save();

                return $newFile-> id; 
                
            }else{
                return null;
            }

        }catch(Error $err){
            return null;
        }
    }
}
