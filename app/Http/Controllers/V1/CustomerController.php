<?php

namespace App\Http\Controllers\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use Error;
use PhpParser\Node\Stmt\TryCatch;

class CustomerController extends Controller
{
   
    public function index()
    {
        return new CustomerCollection(Customer::all());
    }

    
    public function store(StoreCustomerRequest $request)
    {
        try{
               
            Customer::create($request);

        } catch(Error $err){
            return response($err,400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function findOne(string $id)
    {
        try{

            $customer = Customer::find($id);  

            if($customer -> count() == 0){
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
