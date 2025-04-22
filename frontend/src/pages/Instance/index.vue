<template>  
  <div class="container mt-60">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="fw-bold mb-3">Game Instances</h3>
            </div>
            <div class="card-body">                              
              <!-- Instance Selection -->                                
              <div class="row">
                <div class="col-sm-6 col-md-3" v-for="(instance, index) in instances" :key="index">
                  <div class="card card-stats card-round" 
                  @click="navigateToEdit(instance.id, instance.instanceName)" 
                  :class="{ 'selectcard': selectedTemplate && selectedTemplate.id === instance.id }"
                  style="cursor: pointer; border: 3px solid transparent;">
                  <div class="card-body">
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">{{ instance.instanceName }}</p>                                   
                      </div>
                    </div>
                  </div>
                </div>
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

const clientId = ref(route.params.id); 

const instances = ref([]);

// navigate instance edit page
const navigateToEdit = (instanceId, instanceName) => {
  router.push({ 
    name: 'updateinstance', 
    params: { id: instanceId, name: instanceName } 
  });
};
// fetch client instance
const fetchClientInstances = async () => {
  try {
    const response = await instance.get(`/viewClientInstance/${clientId.value}`);
    instances.value = response.data.instances;
    console.log("Client Instances:", instances.value);
  } catch (error) {
    console.error("Error fetching instances:", error);
  }
};

onMounted(() => {
  fetchClientInstances();
});

</script>
