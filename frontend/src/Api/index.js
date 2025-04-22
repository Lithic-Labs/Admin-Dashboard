import axios from "axios";
import { toast } from 'vue3-toastify';

export const instance = axios.create({
    baseURL:import.meta.env.VITE_API_ENDPOINT,
});

instance.interceptors.request.use(
    function (config) {
    if (localStorage.adminportalauthtoken) {
        config.headers.Authorization = `Bearer ${localStorage.adminportalauthtoken}`;

        console.log(config);
    }      
    return config;
}, function (error) {
    return Promise.reject(error);
});



instance.interceptors.response.use(
    function (response) { 
        if (response.data.message) {
            toast.success(response.data.message,'Success');           
        }
    return response;
    },
    function (error) {
        if (error.response) {           
            if (error.response.status === 401) {
                toast.error(error.response.data.message, "error");
              } else if (error.response.status === 403) {
                toast.error(error.response.data.message, "error");
              } else if (error.response.status === 404) {
                toast.error(error.response.data.message, "error");
              } else if (error.response.status === 405) {
                toast.error(error.response.data.message, "warning");
              } else if (error.response.status === 422) {
                toast.error(error.response.data.message, "error");
              } else if (error.response.status === 500) {
                toast.error(error.response.data.error, "error");
              }
            
          }
   
    return Promise.reject(error);
});