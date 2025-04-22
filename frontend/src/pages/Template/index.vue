<template>  
  <div class="container mt-60">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="fw-bold mb-3">Game Templates</h3>
            </div>
            <div class="card-body">
              <form @submit.prevent="submitForm">
                
                <!-- Template Selection -->
                <div class="row">
                  <div class="col-sm-6 col-md-3" v-for="(template, index) in templates" :key="index">
                    <div class="card card-stats card-round" 
                         @click="selectTemplate(template)" 
                         :class="{ 'selectcard': selectedTemplate && selectedTemplate.templateId === template.templateId }"
                         style="cursor: pointer; border: 2px solid transparent;">
                      <div class="card-body">
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category">{{ template.name }}</p>                                   
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Client Selection -->
                <div class="row">
                  <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                      <label>Select Client</label>
                      <select id="user" name="user" class="form-control" v-model="form.client">
                        <option value="1">Client 1</option>        
                        <option value="2">Client 2</option>                                          
                      </select>
                      <p v-if="error.client" class="text-danger">{{ error.client }}</p>
                    </div>
                  </div>
                </div>                   
                
                <!-- Submit Button -->
                <div class="row">
                  <div class="col-md-6 col-lg-6">
                    <button type="submit" class="btn" style="background-color: #21d575;color: #fff;margin-right: 10px;">
                      Create Instance
                    </button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>  
    </div>
  </div>
</template>


<script setup>
import {onMounted, ref,reactive} from "vue";
import axios from "axios";
import { instance } from "@/Api";
import 'vue3-toastify/dist/index.css';


const templates = ref([]);
const selectedTemplate = ref(null);

const form = reactive({
  client:'',
  templateid:'',
  
 
});

const error = reactive({
  client:'',
  templateid:''
  
});


const getTemplate = async ()=>{
  const res = await instance.get('templates'); 
  templates.value = res.data;  
}

const validatedForm = ()=>{
  let isValid = true;

  if (!form.client) {
    error.client = "Client is required";
    isValid = false;
  } else {
    error.client = "";
  }

  if (!form.templateid) {
    error.templateid = "Template ID is required";
    isValid = false;
  } else {
    error.templateid = "";
  }
  return isValid; 
}

// Select Template
const selectTemplate = (template) => {  
  selectedTemplate.value = template;
  form.templateid = template.templateId;  
};

// create instance
const submitForm = async()=>{
  if(validatedForm()){  
    try {
       await instance.post("/storeInstance", form);   

      // Clear form
      form.client = "";
      form.templateid = "";
      selectedTemplate.value = null;

    } catch (error) {
      console.error("Error creating instance:", error);
    }
  }
}

onMounted(
()=>{
  getTemplate()
}
) 

</script>
