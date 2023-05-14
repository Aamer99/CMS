<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
