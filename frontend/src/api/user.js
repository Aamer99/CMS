import axios from "axios";
import { HTTP } from "./axios";


export default {
    sendMessage(data){
        
        return HTTP.post("users/send-message",data);
    },

    getAllUsers(){
       return HTTP.get("users");
    },

    getFile(data){
       
        return HTTP.post("users/file",data);
    },

    editProfile(data){
        return HTTP.put("users/edit-profile",data);
    }

}