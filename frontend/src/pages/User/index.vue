<template>
  <div class="container" style="margin-top: 20px;">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">User Management</h3>
                    <ul class="breadcrumbs mb-3">
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a >Back</a>
                        </li>
                    </ul>
            </div>
            <form @submit.prevent="submitForm" >                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                        <label>Name</label>
                                            <input id="name" type="text" class="form-control" v-model="form.name">
                                           <span v-if="error.name" style="color:red">{{ error.name }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                        <label>Email</label>
                                        <input id="email" type="text" class="form-control" v-model="form.email">
                                           <span v-if="error.email" style="color:red">{{ error.email }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" v-model="form.password">
                                          <span v-if="error.password" style="color:red">{{ error.password }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                        <label>Password Confirmation</label>
                                        <input type="password" class="form-control" v-model="form.password_confirmation">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                        <label>Role</label>
                                            <select id="role" name="role" class="form-control" v-model="form.usertype">
                                                <option  v-for="(role, index) in roles"
                                                :key="index"  >                                              
                                                {{ role.name }}</option>                                               
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn" type="submit" style="background-color: #21d575;color: #fff;">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </template>

<script setup>
import { ref,reactive, onMounted } from 'vue';
import 'vue3-toastify/dist/index.css';
import { instance } from '@/Api';

const roles = ref([]);

const form = reactive({
  name:'',
  email:'',
  password:'',
  password_confirmation:'',
});

const error = reactive({
  name:'',
  email:'',
  password:'',
  password_confirmation:'',
});

const validatedForm = ()=>{
  let isValid = true;
  if(!form.name.trim()){
    error.name = "Name is required";
    isValid = false;
  }
  if(!form.email.trim()){
    error.email = "Email is required";
    isValid = false;
  }else if(!/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(form.email)){
    error.email = "Invalid Email Format";
    isValid = false;
  }
  if(!form.password.trim()){
    error.password = "Password is required";
    isValid = false;

  }else if(!/\d/.test(form.password)){
    error.password ="A password must contain at least one number";
    isValid = false;
  }else if(!/[a-z]/.test(form.password)){
    error.password = "A password must contain at least one lower case letter";
    isValid = false;
  }else if(!/[A-Z]/.test(form.password)){
    error.password ="A password must contain at least one Upper case letter";
    isValid = false;
  }
  if(!form.password_confirmation.trim()){
    error.password_confirmation = "Password Confirmation is required";
    isValid = false;
  }else if(!/\d/.test(form.password_confirmation)){
    error.password_confirmation ="A password must contain at least one number";
    isValid = false;
  }else if(!/[a-z]/.test(form.password_confirmation)){
    error.password_confirmation = "A password must contain at least one lower case letter";
    isValid = false;
  }else if(!/[A-Z]/.test(form.password_confirmation)){
    error.password_confirmation ="A password must contain at least one Upper case letter";
    isValid = false;
  }
  return isValid;
}

// register user
const submitForm = async()=>{
  if(validatedForm()){
    return await instance.post('/storeUser',form).then((res)=>{
        // clear form
        form.name = '';
        form.email = '';
        form.password ='';
        form.password_confirmation = '';
        form.usertype = '';
        // window.location.reload();
    }).catch(()=>{

    });  
  }
}

// get role
const getRole = async()=>{
  const res =  await instance.get('/role'); 
  roles.value = res.data; 
}

onMounted(
  ()=>{
    getRole()
  }
)


</script>