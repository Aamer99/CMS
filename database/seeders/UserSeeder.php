<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Request as UserRequest;
use App\Models\Role;
use App\Models\UnapprovedUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $adminRole = Role::find(1);
        $managerRole = Role::find(2);
        $employeeRole = Role::find(3);
        
        $newAdmin = new User();
        $newAdmin-> name = "admin";
        $newAdmin-> email = "admin@admin.com";
        $newAdmin-> password = Hash::make("admin");
        $newAdmin-> phoneNumber = "055555555";
        $newAdmin-> type = $adminRole-> id;
        $newAdmin-> department_id = 0;
        $newAdmin-> is_validate = 0;
        $newAdmin-> save(); 

        $newUser = new User();
        $newUser-> name = "manager";
        $newUser-> email = "mi@em.com";
        $newUser-> password = Hash::make("manager");
        $newUser-> phoneNumber = "055555555";
        $newUser-> type = $managerRole-> id;
        $newUser-> department_id = 0;
        $newUser-> is_validate = 0;
        $newUser-> save(); 

        $newUser = new User();
        $newUser-> name = "manager";
        $newUser-> email = "em00@mo.com";
        $newUser-> password = Hash::make("manager");
        $newUser-> phoneNumber = "055555555";
        $newUser-> type = $managerRole-> id;
        $newUser-> department_id = 0;
        $newUser-> is_validate = 0;
        $newUser-> save(); 

        $newManager = new User();
        $newManager-> name = "manager2";
        $newManager-> email = "m20@m.com";
        $newManager-> password = Hash::make("manager");
        $newManager-> phoneNumber = "055555555";
        $newManager-> type = $managerRole-> id;
        $newManager-> department_id = 0;
        $newManager-> is_validate = 0;
        $newManager-> save();  

        $newEmployee = new User();
        $newEmployee-> name = "manager2";
        $newEmployee-> email = "mm@mo.com";
        $newEmployee-> password = Hash::make("manager");
        $newEmployee-> phoneNumber = "055555555";
        $newEmployee-> type = $managerRole-> id;
        $newEmployee-> department_id = 0;
        $newEmployee-> is_validate = 0;
        $newEmployee-> save();  


        $newRequest = new UserRequest(); 
        $newRequest->file_id  = 0;
        $newRequest->owner_id  = 3;
        $newRequest->department_id = 3;
        $newRequest->type  = 2;
        $newRequest->status  = 1;
        $newRequest->request_number  = 0;
        $newRequest->description  = "kfij";
        $newRequest->save();

        $newRequest = new UserRequest(); 
        $newRequest->file_id  = 0;
        $newRequest->owner_id  = 4;
        $newRequest->department_id = 1;
        $newRequest->type  = 2;
        $newRequest->status  = 2;
        $newRequest->request_number  = 0;
        $newRequest->description  = "kfij";
        $newRequest->save();

        $newDepartment = new Department();
        $newDepartment-> name = "B02";
        $newDepartment-> save();

        $newDepartment = new Department();
        $newDepartment-> name = "B03";
        $newDepartment-> save();

        $newDepartment = new Department();
        $newDepartment-> name = "B03";
        $newDepartment-> save();





    }
}
