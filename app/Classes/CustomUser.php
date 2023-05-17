<?php
namespace App\Classes;
class CustomUser {
    

    public function toArray($user){

        // dd($user);

       
     $users =  $user->map(function($data,$index) {
        return [
            '_id' => $index,
            'name'=> $data->name,
            'email'=> $data->email,
            'phone_number' => $data->phone_number,
            'department' => $data->department_id
        ];
    });
        return $users; 

    }
}