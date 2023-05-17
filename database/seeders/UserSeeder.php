<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\File;
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
          $file = new File();
        $file->file_path = '/storage/app/file/admin';
       
        $newAdmin->file()->save($file);
       
        $adminRole= Role::find(1);
        
        $newAdmin->role()->attach($adminRole);

    
      

        $newUser = new User();
        $newUser-> name = "manager";
        $newUser-> email = "manager@manager.com";
        $newUser-> password = Hash::make("manager");
        $newUser-> phoneNumber = "055555555";
        $newUser-> department_id = 1;
        $newUser-> is_validate = 0;
         $newUser-> save();
        $newUser-> file()->create([
            'file_path'=> '/storage/app/file/manager1',
           
        ]);
       
        $managerRole= Role::find(2);
        $newUser->role()->attach($managerRole);


        $newUser = new User();
        $newUser-> name = "manager";
        $newUser-> email = "manager2@manager.com";
        $newUser-> password = Hash::make("manager");
        $newUser-> phoneNumber = "055555555";
        $newUser-> department_id = 2;
        $newUser-> is_validate = 0;
         $newUser-> save();
        $newUser-> file()->create([
            'file_path'=> '/storage/app/file/manager2',
        ]);
        
        $managerRole= Role::find(2);
        $newUser-> role()->attach($managerRole);
       

      

        $newEmployee = new User();
        $newEmployee-> name = "employee 1";
        $newEmployee-> email = "employee@employee.com";
        $newEmployee-> password = Hash::make("employee");
        $newEmployee-> phoneNumber = "055555555";
        $newEmployee-> department_id = 1;
        $newEmployee-> is_validate = 0;
        $newEmployee-> save(); 
         $file = new File();
        $file->file_path = '/storage/app/file/admin';

       $newEmployee->file()->save($file);
        $employeeRole= Role::find(3);
        $newEmployee->role()->sync($employeeRole); 
         

       

        $newEmployee = new User();
        $newEmployee-> name = "employee 2";
        $newEmployee-> email = "employee2@employee.com";
        $newEmployee-> password = Hash::make("employee");
        $newEmployee-> phoneNumber = "055555555";
        $newEmployee-> department_id = 2;
        $newEmployee-> is_validate = 0;
        $newEmployee->save();
        $file = new File();
        $file->file_path = '/storage/app/file/employee2';
       $newEmployee->file()->save($file);
       
        $employeeRole= Role::find(3);
        $newEmployee->role()->attach($employeeRole); 
       
    }
}
