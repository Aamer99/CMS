import axios from "axios"; 
export default {
    getOne(id){
        return axios.get("http://127.0.0.1:8000/api/v1/users/requests/"+id);
    },
    create(data){
        return axios.post("http://127.0.0.1:8000/api/v1/users/requests");
    },
    myRequests(id){
        return axios.get("http://127.0.0.1:8000/api/v1/users/my-requests/"+id);
    },
    deny(id){
     return axios.get("http://127.0.0.1:8000/api/v1/users/requests/deny/"+id)
    }
}