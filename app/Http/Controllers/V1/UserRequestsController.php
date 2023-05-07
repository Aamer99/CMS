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
use App\Traits\HttpResponses;
use Error;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class UserRequestsController extends Controller
{
    use HttpResponses;

    public function getOneRequest($id){
        try{

            $request = UserRequest::findOrFail($id);
   
             return $this->success($request,"successful",200);

        }catch(Error $err){

            return $this->error($err,400);

        }catch(ModelNotFoundException $e){
            return $this->error("the request not exist",404);
        }
    }

   
    // public function approvedManagerRequest(string $request_id){
    //     try{

    //         $request = UserRequest::where(["id"=> $request_id,"type"=>1,"status"=>0])-> first(); 
            

    //         if($request){
                

    //           $user = User::find($request-> owner_id);
    //           $request-> status = 1; 
    //           $request-> save(); 

    //           Mail::to($user-> email)->queue(new requestNotifyMail($request-> request_number, $user-> name));

    //           return response()-> json(["message"=> "the requests approved successfully "],200);
               

    //         } else{

    //             return response()-> json(["message"=> "the request not found"],404);
    //         }

    //     }catch(Error $err){

    //         return response()-> json(["message"=> $err],400);
    //     }
    // }

    

   

    public function denyRequest($id){

        try{

            $currentUserRole = Auth::user()->role-> id; 
            


            if($currentUserRole == 1|| $currentUserRole == 2){

                $request = UserRequest::findOrFail($id);
                $user = $request-> owner;
    
                $request-> delete();

         //  Mail::to($user-> email)->queue(new requestNotifyMail($request-> request_number,$user-> name));

            return $this->success(""," the request denied successfully ",200);
            } 

            return $this->error("Unauthenticated!",401);
           
            
     
         

        }catch(Error $err){

            return $this->error($err,400);

        }catch(ModelNotFoundException $e){

            return $this->error($e,404);

        }
    }

    public function getDepartmentRequests($id){
        try{

            $department =Department::findOrFail($id); 
            $requests = $department-> requests; 

            return $this->success($requests,"successfull",200);

        }catch(Error $err){
            return response()-> json(["message"=> $err],400);
        }

    }


    public function getUserRequestsByID($id){
        try{

            $managerRequests = User::findOrFail($id)->requests->where("status",2); 

            return $this->success($managerRequests,"successfull",200);

        }catch(Error $err){

            return $this->error($err,400);

        } catch(ModelNotFoundException $e){

            return $this->error("the user not exist",404);
        }
    }

   

    public function createRequest($id,StoreRequests $request){
        try{

            $user = User::findorFail($id);
 

               
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
                //  Mail::to($user-> email)->queue(new sendedRequestMail($newRequest-> request_number,$date));

              return $this->success("","the request send successfully",200);
               }

                return $this->error("please check your file",400);
               
        }catch(Error $err){

            return $this->error($err,400);

        } catch(ModelNotFoundException $e){

            return $this->error("the user not exist ",404);

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
