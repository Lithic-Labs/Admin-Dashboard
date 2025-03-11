<template>    
       <div class="container">
        <div class="page-inner">
        <div class="row" style="margin-top:50px">
        <div class="col-md-3"></div>
        <div class="col-md-6">
        <div class="row d-flex justify-content-center align-items-center"><img src="" style="width:250px" /></div>
        <div class="row d-flex justify-content-center align-items-center"><h2 style="margin-bottom:20px;font-weight:bold;text-align:center;margin-top:10px">SIGN IN</h2></div>
        <div class="card">
            <form @submit.prevent="submitForm">
            <div class="card-body">                 
                <div class="row">
                    <div class="col-md-6 col-lg-12">
                        <div class="form-group">
                            <label for="email2">Email Address</label>
                            <input id="email" type="email" class="form-control" v-model="form.email" autofocus>                           
                            <span v-if="error.email" style="color:red">{{error.email}}</span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                             <input id="password" type="password" class="form-control" v-model="form.password">                           
                            <span v-if="error.password" style="color:red">{{ error.password }}</span>
                        </div>
                    </div>
                </div>               
            </div>
            <div class="card-action">
                <button class="btn btn-primary" type="submit">LOGIN</button>               
                <a class="btn btn-link"></a>            
            </div>
            </form>
        </div>    
    </div>
        <div class="col-md-3"></div>
        </div>
        </div>
       </div>     
</template>

<script setup >
import {ref, reactive, } from "vue";
import 'vue3-toastify/dist/index.css';
import { instance } from "@/Api"; 


    const form = reactive({
      email: '',
      password: '',
    });

    const error = reactive({
      email: '',
      password: '',
    });

    const validatedForm = () =>{
      let isValid = true;
      if (!form.email.trim()){
        error.email = 'Email is required';
        isValid = false;
      }
      if (!form.password.trim()){
        error.password = 'Password is required';
        isValid = false;
      }
      return isValid;
    }

    // Method to login user
    const submitForm = async () => {
      if(validatedForm()){
        return await instance.post('/login',form).then((res) => {          
            const role = res.data.data.data.usertype;           
            localStorage.setItem("adminportalauthtoken",res.data.data.token);
            localStorage.setItem("adminportalauthrole",role);
            localStorage.setItem("adminportalauthname",res.data.data.data.name);
            // clear form
            form.email = '';
            form.password ='';
            if(role === "client"){
                window.location.href="/dashboard";
            } 
            
        });
    
      }
    }
</script>