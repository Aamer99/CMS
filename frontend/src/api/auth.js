import axios from "axios";

export default{
    login(data){
        return axios.post("http://127.0.0.1:8000/api/v1/auth/login",data)
    },
    verifyOTP(data){
        return axios.post("http://127.0.0.1:8000/api/v1/auth/otp",data)
    }
}