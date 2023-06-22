<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests;
use App\Http\Resources\RequestsResource;
use App\Mail\requestNotifyMail;
use App\Mail\sendedRequestMail;
use App\Models\File;
use App\Models\Request as UserRequest;
use App\Models\User;
use Faker\Extension\Extension;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class UserRequestsController extends Controller
{

    public function getOneRequest($id)
    {
        try {

            $request = new RequestsResource(UserRequest::findOrFail($id));

            return $this->successWithData($request, "successful", 200);
        } catch (Extension $err) {

            return $this->error($err, 400);
        } catch (ModelNotFoundException $e) {
            return $this->error("the request not exist", 404);
        }
    }


    public function denyRequest($id)
    {

        try {

            $currentUser = Auth::user();
            $currentUserRole = $currentUser->role[0]->id;



            if ($currentUserRole == 1 || $currentUserRole == 2) {



                $request = UserRequest::findOrFail($id);;
                $user = $request->owner;
                if ($user->id != $currentUser->id) {
                    $request->delete();

                    //  Mail::to($user-> email)->queue(new requestNotifyMail($request-> request_number,$user-> name));

                    return $this->success(" the request denied successfully ", 200);
                } else {
                    return $this->error("you don't have permission to do this", 403);
                }
            }

            return $this->error("Unauthenticated!", 401);
        } catch (Extension $err) {

            return $this->error($err, 400);
        } catch (ModelNotFoundException $e) {

            return $this->error($e->getMessage(), 404);
        }
    }



    public function getUserRequests($id)
    {
        try {

            $userRequests = RequestsResource::collection(User::findOrFail($id)->requests);

            return $this->successWithData($userRequests, "successful", 200);
        } catch (Extension $err) {

            return $this->error($err, 400);

        } catch (ModelNotFoundException $e) {

            return $this->error("the user not exist", 404);
        }
    }



    public function createRequest(StoreRequests $request)
    {
        try {


            $user = auth()->user();

            $request_number = Str::random(2) . '-' . sprintf("%06d", mt_rand(1, 9999999));

            $file = $this->uploadFile($request, $request_number);

            if ($file) {

              
                $newRequest = new UserRequest();
                $newRequest->owner_id = $user->id;
                $newRequest->department_id = $request->department_id; 
                $newRequest->type = $user->role[0]->id;
                $newRequest->status = 1;
                $newRequest->request_number = $request_number;
                $newRequest->description = $request->description;
                $newRequest-> title = $request->title;
                $newRequest->save();

                $newRequest->file()->save($file);

                //  Mail::to($user-> email)->queue(new sendedRequestMail($newRequest-> request_number,$date));

                return $this->successWithData(["request number" => $request_number,"request"=> new RequestsResource($newRequest)], "the request send successfully", 200);
            }

            return $this->error("please check your file", 400);
        } catch (Extension $err) {

            return $this->error($err, 400);
        }
    }

    public function uploadFile(Request $request)
    {
        try {

            if ($request->hasFile("requestFile")) {

                $filePath = $request->file('requestFile')->store('requestsFile', 'public');

                $file = new File();
                $file->file_path = $filePath;
                $file-> file_type = $request-> file_type;

                return $file;
            } else {
                return null;
            }
        } catch (Extension $err) {
            return null;
        }
    }
}
