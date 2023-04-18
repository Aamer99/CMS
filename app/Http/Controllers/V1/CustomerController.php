<?php

namespace App\Http\Controllers\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use Error;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;

class EmployeeController extends Controller
{
   
    public function index()
    {
        return new CustomerCollection(Customer::all());
    }

    
    public function createOne(StoreCustomerRequest $request)
    {
        try{
               
         $newCustomer = new Customer();
         $newCustomer -> name = $request-> name ; 
         $newCustomer-> email = $request-> email;
         $newCustomer-> password = Hash::make($request-> password);
         $newCustomer-> phoneNumber = $request-> phoneNumber;
         $newCustomer-> save();

            return response("Customer created successfully",200);


        } catch(Error $err){
            return response($err,400);
        }
    }

    public function findOne(string $id)
    {
        try{

            $customer = Customer::find($id);  

            
            if($customer == null){
                return response("not found",404);

            } else{ 
                return new CustomerResource($customer);
            }
            

        }catch(Error $err){
            return response($err,400);
        }
      
    }


    public function search(String $searchTerm){

        try{ 
           $filter = Customer::where("name",$searchTerm)->get();

        if(count($filter) == 0){
            return response("not found",404);
         } else {
            return $filter;
            }

     } catch(Error $err){
        return response($err,400);
     }
    }

  
    public function updateOne(StoreCustomerRequest $request, string $id)
    {
        try{
        
        $customer = Customer::find($id); 
        $customer-> name = $request-> name ;
        $customer-> email = $request-> email; 
        $customer-> password = $request-> password; 
        $customer-> phoneNumber = $request-> phoneNumber; 
        $customer-> save() ;

        return response('customer updated successfully',200);
        } catch(Error $err){
            return response($err,400);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteOne(string $id)
    {
        try{

          $customer = Customer::find($id);
          $customer-> delete(); 

            return response("Customer deleted successfully",200);
        } catch(Error $err){
            return response($err,400);
        }
    }
}
