<template>  
    <div class="container mt-60">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                  <br/>
                    <div class="card">

                        <div class="card-header">
                            <h3 class="fw-bold mb-3">{{instanceName}}</h3>
                        </div>
                        <div class="card-body">  
                            <div class="col-md-3">
                              <button class="btn"  style="background-color: #21d575;color: #fff;">Copy Build Link</button>
                            </div>         
                             
                              <br/>   
                             
                              <div class="row">
                                <div class="col-md-2">
                                  <button class="btn" @click="navigateToEdit()"  style="background-color: #21d575;color: #fff;">Edit</button>
                                </div>
                                <div class="col-md-3">
                                  <button class="btn"  @click="navigateCreateRewards()"   style="background-color: #21d575;color: #fff;">Rewards</button>
                                </div>                             
                                <br/>
                              </div> 
                              
                              <br/>
                              <div class="row">
                              <div class="col-md-6 col-lg-6">
                                <h5 class="fw-bold">Analytics</h5>                               
                                <br/>
                              </div>                
                            </div>
                            <div class="row">
                              <div class="col-md-6 col-lg-6">
                                <textarea class="form-control" placeholder=""></textarea>
                                <br/>
                              </div>              
                            </div>                
                            <div class="row">
                              <div class="col-md-3 col-lg-3">
                                <h5 class="fw-bold">User Email Addresses</h5>
                                <br/>
                              </div>
                              <div class="col-md-4 col-lg-4">
                                <label for="csvFileInput" class="btn text-white" style="background-color: #21d575;color: #fff;">
                                  CSV Upload
                                  <input
                                    id="csvFileInput"
                                    type="file"
                                    class="form-control-file d-none"
                                    @change="handleCsvUpload($event, 'player')"
                                    accept=".csv"
                                  />
                                </label>
                              </div>
                            </div>                   
                            
                       
                          </div>
                </div>
            </div>
        </div>  
    </div>
</div>
</template>


<script setup>
import {onMounted, ref,reactive} from "vue";
import { useRoute,useRouter } from 'vue-router';
import axios from "axios";
import { instance } from "@/Api";
import 'vue3-toastify/dist/index.css';

const router = useRouter();
const route = useRoute();

const userId = ref(route.params.uid); 
const instanceName = ref(route.params.name);
const instanceId = ref(route.params.id); 


const instances = ref([]);

// // navigate instance edit page
const navigateCreateRewards = () => {
  router.push({ 
    name: 'rewards', 
    params: { id: instanceId.value, name: instanceName.value, uid:userId.value } 
  });
};
// navigate instance edit page
const navigateToEdit = () => {
  router.push({ 
    name: 'updateinstance', 
    params: { id: instanceId.value, name: instanceName.value, uid:userId.value } 
  });
};

// fetch client instance
// const fetchClientInstances = async () => {
//       try {
//         const response = await instance.get(`/viewClientInstance/${clientId.value}`);
//         instances.value = response.data.instances;
//         console.log("Client Instances:", instances.value);
//       } catch (error) {
//         console.error("Error fetching instances:", error);
//       }
// };

// onMounted(() => {
//     fetchClientInstances();
// });

</script>
