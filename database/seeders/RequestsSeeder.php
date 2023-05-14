<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Request as UserRequest;

class RequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $newRequest = new UserRequest(); 
        $newRequest->file_id  = 0;
        $newRequest->owner_id  = 2;
        $newRequest->department_id = 1;
        $newRequest->type  = 2;
        $newRequest->status  = 2;
        $newRequest->request_number  = 0;
        $newRequest->description  = "description";
        $newRequest->save();

        $newRequest = new UserRequest(); 
        $newRequest->file_id  = 0;
        $newRequest->owner_id  = 2;
        $newRequest->department_id = 2;
        $newRequest->type  = 1;
        $newRequest->status  = 1;
        $newRequest->request_number  = 0;
        $newRequest->description  = "description";
        $newRequest->save();
    }
}
