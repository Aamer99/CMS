
import { HTTP } from "./axios";
export default {
    getRequest(id){

        return HTTP.get("users/requests/"+id);
    },
    createRequest(data){
        const config = {
            headers: { 'content-type': 'multipart/form-data' }
        }
        return HTTP.post("users/requests",data,config);
    },
    myRequests(id){
        return HTTP.get("users/my-requests/"+id);
    },
    denyRequest(id){
     return HTTP.delete("users/requests/deny/"+id)
    },

    getManagerRequests(){
        return HTTP.get("admin/requests/managers");
    },
    getEmployeeRequests(id){
        return HTTP.get(`manager/employees/requests/${id}`);
      }
}