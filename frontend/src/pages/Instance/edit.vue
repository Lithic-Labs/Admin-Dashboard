<template>
    <div class="container mt-60">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">                
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row g-3">
                                <div>
                                    <h3 class="fw-bold mb-3">Edit Game Instance</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                           <form @submit.prevent="submitForm" >                                                           
                                <div class="card-body">
                                    <h4 class="fw-bold mb-3">{{ instanceName }}</h4>                               
                                    <br/>
                                    <div><h4 style="font-weight: 600;">Images</h4></div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-2" style="font-size: large;">Background</div>
                                        <div class="col-md-4">                                                                                                          
                                            <input
                                              type="file"
                                              class="form-control-file"
                                              @change="handleFileUpload($event, 'backgroundImage')"
                                            />
                                            <div v-if="previews.backgroundImage" class="mt-2">
                                              <img :src="previews.backgroundImage" alt="Background Preview" class="img-thumbnail" width="100">
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="font-size: large;">Player</div>
                                        <div class="col-md-4">                                                                                                          
                                            <input
                                            type="file"
                                            class="form-control-file" 
                                            @change="handleFileUpload($event, 'player')"                                                                                                              
                                            />
                                            <div v-if="previews.player" class="mt-2">
                                              <img :src="previews.player" alt="Background Preview" class="img-thumbnail" width="100">
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-2" style="font-size: large;">Button</div>
                                        <div class="col-md-4">                                                                                                          
                                            <input
                                            type="file"
                                            class="form-control-file" 
                                            @change="handleFileUpload($event, 'button')"                                                                                                              
                                            />
                                            <div v-if="previews.button" class="mt-2">
                                              <img :src="previews.button" alt="Background Preview" class="img-thumbnail" width="100">
                                            </div>
                                        </div>                                        
                                    </div>
                                    <br/>
                                    <div><h4 style="font-weight: 600;">Text</h4></div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-2" style="font-size: large;">Title</div>
                                        <div class="col-md-4">                                                                                                          
                                            <input
                                            type="text"
                                            class="form-control" 
                                            v-model="form.title"                                                                                                                                                          
                                            />
                                            <span v-if="error.title" style="color:red">{{ error.title }}</span>
                                        </div>
                                        <div class="col-md-2" style="font-size: large;">Win text</div>
                                        <div class="col-md-4">                                                                                                          
                                            <input
                                            type="text"
                                            class="form-control" 
                                            v-model="form.winText"                                                                                                                                                         
                                            />
                                            <span v-if="error.winText" style="color:red">{{ error.winText }}</span>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-2" style="font-size: large;">Lose Text</div>
                                        <div class="col-md-4">                                                                                                          
                                            <input
                                            type="text"
                                            class="form-control"  
                                            v-model="form.loseText"                                                                                                                                                        
                                            />
                                            <span v-if="error.loseText" style="color:red">{{ error.loseText }}</span>
                                        </div>                                       
                                    </div>
                                    <br/>
                                    <div><h4 style="font-weight: 600;">Colors</h4></div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-2" style="font-size: large;">Color 1</div>
                                        <div class="col-md-4">                                                                                                          
                                          <input type="color" v-model="form.color1" />
                                            <span v-if="error.color1" style="color:red">{{ error.color1 }}</span>
                                        </div>
                                        <div class="col-md-2" style="font-size: large;">Color 2</div>
                                        <div class="col-md-4">                                                                                                          
                                          <input type="color" v-model="form.color2" />
                                            <span v-if="error.color2" style="color:red">{{ error.color2 }}</span>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-2" style="font-size: large;">Color 3</div>
                                        <div class="col-md-4">                                                                                                          
                                          <input type="color" v-model="form.color3" />
                                            <span v-if="error.color3" style="color:red">{{ error.color3 }}</span>
                                        </div>                                       
                                    </div>
                                    <br/>                           
                                </div>
                                <div class="card-action">
                                    <button class="btn" type="submit" style="background-color: #21d575;color: #fff;">Update</button>
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
import { ref, reactive } from 'vue';
import { useRoute } from 'vue-router';
import { instance } from '@/Api';
import 'vue3-toastify/dist/index.css';
import ColorPicker from 'vue3-colorpicker';
import 'vue3-colorpicker/style.css';

const route = useRoute();
const instanceId = route.params.id;
const instanceName = route.params.name;

// Store form fields
const form = reactive({
  title: '',
  winText: '',
  loseText: '',
  color1: '#ff0000',
  color2: '#00ff00',
  color3: '#0000ff'
});

// Store selected files and their previews
const files = reactive({
  backgroundImage: null,
  player: null,
  button: null
});

const previews = reactive({
  backgroundImage: null,
  player: null,
  button: null
});

//error form field

// Store form fields
const error = reactive({
  title: '',
  winText: '',
  loseText: '',
  color1: '',
  color2: '',
  color3: ''
});

const validatedForm = ()=>{
  let isValid = true;
  if(!form.title.trim()){
    error.title = "Title is required";
    isValid = false;
  }
  if(!form.winText.trim()){
    error.winText = "Win Text is required";
    isValid = false;
  }
  if(!form.loseText.trim()){
    error.loseText = "lose Text is required";
    isValid = false;
  }
  if(!form.color1.trim()){
    error.color1 = "color1 is required";
    isValid = false;
  }
  if(!form.color2.trim()){
    error.color2 = "color2 is required";
    isValid = false;
  }
  if(!form.color3.trim()){
    error.color3 = "color3 is required";
    isValid = false;
  }
  return isValid;
}

const handleFileUpload = (event, key) => {
  const file = event.target.files[0]; // Get the selected file
  if (file) {
    files[key] = file; // Store file
    previews[key] = URL.createObjectURL(file); // Generate preview URL
  }
};

const submitForm = async () => {
    if(validatedForm()){
    const formData = new FormData();
      formData.append("instanceId", instanceId);

    // Append text fields (even if empty, they will be updated to null)
    formData.append("title", form.title || "");
    formData.append("winText", form.winText || "");
    formData.append("loseText", form.loseText || "");
    formData.append("color1", form.color1 || "");
    formData.append("color2", form.color2 || "");
    formData.append("color3", form.color3 || "");

      // Append each file with its respective key
      Object.keys(files).forEach((key) => {
        if (files[key]) {
          formData.append(key, files[key]);
        }
      });

      try {
        await instance.post("updateInstance", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });
        console.log("Upload successful!");
      } catch (error) {
        console.error("Upload failed!", error);
      }
  }
 
};
</script>
