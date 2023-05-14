<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Request as UserRequest;
use App\Models\Role;
use App\Models\UnapprovedUser;
use App\Models\User;
use App\Models\usersRoles;
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

      
        
        $newAdmin = new User();
        $newAdmin-> name = "admin";
        $newAdmin-> email = "admin@admin.com";
        $newAdmin-> password = Hash::make("admin");
        $newAdmin-> phoneNumber = "055555555";
        $newAdmin-> department_id = 0;
        $newAdmin-> is_validate = 0;
        $newAdmin-> save(); 

        $newRole = new usersRoles();
        $newRole-> user_id = 1;
        $newRole-> role_id = 1;
        $newRole->save();

        $newUser = new User();
        $newUser-> name = "manager";
        $newUser-> email = "manager@manager.com";
        $newUser-> password = Hash::make("manager");
        $newUser-> phoneNumber = "055555555";
        $newUser-> department_id = 1;
        $newUser-> is_validate = 0;
        $newUser-> save(); 

        $newRole = new usersRoles();
        $newRole-> user_id = 2;
        $newRole-> role_id = 2;
        $newRole->save();

        $newUser = new User();
        $newUser-> name = "manager";
        $newUser-> email = "manager2@manager.com";
        $newUser-> password = Hash::make("manager");
        $newUser-> phoneNumber = "055555555";
        $newUser-> department_id = 2;
        $newUser-> is_validate = 0;
        $newUser-> save(); 

        $newRole = new usersRoles();
        $newRole-> user_id = 3;
        $newRole-> role_id = 2;
        $newRole->save();
      

        $newEmployee = new User();
        $newEmployee-> name = "employee 1";
        $newEmployee-> email = "employee@employee.com";
        $newEmployee-> password = Hash::make("employee");
        $newEmployee-> phoneNumber = "055555555";
        $newEmployee-> department_id = 1;
        $newEmployee-> is_validate = 0;
        $newEmployee-> save();  

        $newRole = new usersRoles();
        $newRole-> user_id = 4;
        $newRole-> role_id = 3;
        $newRole->save();

        $newEmployee = new User();
        $newEmployee-> name = "employee 2";
        $newEmployee-> email = "employee2@employee.com";
        $newEmployee-> password = Hash::make("employee");
        $newEmployee-> phoneNumber = "055555555";
        $newEmployee-> department_id = 2;
        $newEmployee-> is_validate = 0;
        $newEmployee-> save();  

        $newRole = new usersRoles();
        $newRole-> user_id = 5;
        $newRole-> role_id = 3;
        $newRole->save();

     






    }
}
