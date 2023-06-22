
import { HTTP } from "./axios";

export default{
    
    allAddEmployeeRequest(){
        return HTTP.get("admin/requests/employees");
    },


    getAllDepartment(){
         
       return HTTP.get("admin/departments");
       
    },

    createDepartment(data){
        
       return HTTP.post("admin/departments",data);
    },

    createManager(data){
       
        return HTTP.post("admin/managers",data);
    },

    approveManagerRequest(data){ 
      
       return HTTP.post("admin/requests/approved",data);

    },

    getAllManager(){
        return HTTP.get("admin/all-managers")
    },

    denyAddNewEmployeeRequest(id){

        return HTTP.delete(`admin/requests/employees/deny/${id}`);

    }

}