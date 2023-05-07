<?php

namespace App\Traits;

trait HttpResponses{

    protected function success($data,$message,$code){

        return response()->json([
            "data"=> $data,
            "message"=> $message
        ],$code);
    } 

    protected function error($message,$code){
        return response()->json(["message"=>$message],$code);
    }
    
}



?>