<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests;
use App\Http\Resources\RequestsResource;
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

    public function getOneRequest($id){
        try{

            $request = new RequestsResource(UserRequest::findOrFail($id));
   
             return $this->successWithData($request,"successful",200);

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

            return $this->success(" the request denied successfully ",200);
            } 

            return $this->error("Unauthenticated!",401);
           
            
     
         

        }catch(Error $err){

            return $this->error($err,400);

        }catch(ModelNotFoundException $e){

            return $this->error($e,404);

        }
    }

   

    public function getUserRequests($id){
        try{

            $managerRequests = RequestsResource::collection(User::findOrFail($id)->requests->where("status",2)); 

            return $this->successWithData($managerRequests,"successful",200);

        }catch(Error $err){

            return $this->error($err,400);

        } catch(ModelNotFoundException $e){

            return $this->error("the user not exist",404);
        }
    }

   

    public function createRequest($id,StoreRequests $request){
        try{


            $user = User::findOrFail($id);
 
                $request_number = Str::random(2) . '-'.sprintf("%06d", mt_rand(1, 9999999));

               $file = $this->uploadFile($request,$request_number);

               if($file){

                $newRequest = new UserRequest(); 
                $newRequest-> owner_id = $user-> id; 
                $newRequest-> department_id = $user-> department->id;
                $newRequest-> type = $user-> role[0]->id; 
                $newRequest-> status = 0;
                $newRequest-> request_number = $request_number;
                $newRequest-> description = $request-> description; 
                $newRequest-> save(); 
                
               $newRequest->file()->save($file);
                  
                //  Mail::to($user-> email)->queue(new sendedRequestMail($newRequest-> request_number,$date));

              return $this->successWithData(["request number"=>$request_number],"the request send successfully",200);
               }

                return $this->error("please check your file",400);
               
        }catch(Error $err){

            return $this->error($err,400);

        } catch(ModelNotFoundException $e){

            return $this->error("the user not exist ",404);

        }
    }

    public function uploadFile(Request $request){
        try{

            if($request-> hasFile("requestFile")){

                $filePath = $request->file('requestFile')->store('requestsFile','public'); 
                $file = new File();
                $file->file_path = $filePath;
        
                return $file; 
                
            }else{
                return null;
            }

        }catch(Error $err){
            return null;
        }
    }
}
