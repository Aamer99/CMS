import axios from "axios";
import { HTTP } from "./axios";

export default{
    login(data){
        return axios.post("http://127.0.0.1:8000/api/v1/auth/login",data)
    },

    logout(){
        return HTTP.post("auth/logout");
    },
    
    verifyOTP(data){
        const headers = {
            'Content-Type': 'application/x-www-form-urlencoded',
          };
         
        return axios.post("http://127.0.0.1:8000/api/v1/auth/otp",data,{headers:headers})
    },

    setPassword(data){

        console.log("reset password");
        console.log(data);
        const headers = {
            'Content-Type': 'application/json',
          };
         return axios.post("http://127.0.0.1:8000/api/v1/auth/set-password",data,{headers:headers});
        
    },

    resetPassword(data){

        const headers = {
            'Content-Type': 'application/json',
          };
         return HTTP.post("auth/reset-password",data);

    }
}