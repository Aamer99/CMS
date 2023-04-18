<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Error;
use Illuminate\Http\Request;

class DepartmentContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createNewDepartment(Request $request)
    {
        try{

        $newDepartment = new Department();
        $newDepartment-> name = $request-> name;
        $newDepartment-> save();

        return response("Department created successfully",200);
        
        } catch(Error $err){
            return response($err,400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
