import axios from "axios";
export default {
    getDepartment(id) {
        return axios.get("http://127.0.0.1:8000/api/v1/admin/departments/" + id );
    },
    all() {
        return axios.get("http://127.0.0.1:8000/api/v1/admin/departments",);
    },
    create(data) {
        return axios.post("http://127.0.0.1:8000/api/v1/admin/departments",data);
    },
};
