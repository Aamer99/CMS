<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = new Role(); 
        $managerRole = new Role();
        $employeeRole = new Role();
        
        $adminRole-> role = "Admin";
        $adminRole-> save();

        $managerRole-> role = "Manager";
        $managerRole-> save();
        
        $employeeRole-> role = "Employee";
        $employeeRole-> save();


    }
}
