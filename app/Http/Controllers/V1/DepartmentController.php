<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\RequestsResource;
use App\Models\Department;
use Faker\Extension\Extension;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function createNewDepartment(Request $request)
    {
        try {

            $request->validate([
                "name" => ["required", "unique:departments"]
            ]);

            $newDepartment = new Department();
            $newDepartment->name = $request->name;
            $newDepartment->save();

            return $this->successWithData(new DepartmentResource($newDepartment), "Department created successfully", 200);
        } catch (Extension $err) {
            return $this->error($err, 400);
        }
    }

    public function getOneDepartment($id)
    {
        try {

            $department = new DepartmentResource(Department::findOrFail($id));

            return $this->successWithData($department, "successful", 200);

        } catch (Extension $err) {
            return $this->error($err, 400);
        } catch (ModelNotFoundException $e) {
            return $this->error($e->getMessage(), 404);
        }
    }

    public function getAllDepartments()
    {
        try {

            $departments = DepartmentResource::collection(Department::all());

            return $this->successWithData($departments, "successful", 200);
        } catch (Extension $err) {
            return $this->error($err, 400);
        }
    }

    public function getAllDepartmentRequests($id)
    {
        try {

            $departmentRequests = RequestsResource::collection(Department::findOrFail($id)->requests);

            return $this->successWithData($departmentRequests, "successful", 200);
        } catch (Extension $err) {
            return $this->error($err, 400);
        } catch (ModelNotFoundException $e) {
            return $this->error("the department not exist", 404);
        }
    }
}
