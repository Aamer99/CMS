import axios from "axios";
import { HTTP } from "./axios";

export default {


    requestAddEmployee(data){
        return HTTP.post("manager/requests/employees",data);
    },

    approvedEmployeeRequests(id){
        return HTTP.post(`manager/employees/requests/approved/${id}`);
    },

    getMyDepartments(id){
       return HTTP.get(`manager/my-department/${id}`);
    },
    getEmployee(id){

        return HTTP.get(`manager/employees/${id}`);
    },

   

}