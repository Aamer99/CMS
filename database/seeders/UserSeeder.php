<?php

namespace Database\Seeders;

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

        $newAdmin = new User();
        $newAdmin-> name = "admin";
        $newAdmin-> email = "admin@admin.com";
        $newAdmin-> password = Hash::make("admin");
        $newAdmin-> phoneNumber = "055555555";
        $newAdmin-> type = 0;
        $newAdmin-> department_id = 0;
        $newAdmin-> is_validate = 0;
        $newAdmin-> approved = 1;
        $newAdmin-> save();

    }
}
