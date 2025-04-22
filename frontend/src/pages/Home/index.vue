<template>  
  <div class="container mt-60">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <br/>
          <div class="card">
            <div class="card-header">              
              <h3 class="fw-bold mb-3" v-if="userRole === 'Super Admin' || userRole === 'Admin'">
                ADMIN DASHBOARD
              </h3>
              <h3 class="fw-bold mb-3" v-else-if="userRole === 'Client'">
                CLIENT DASHBOARD
              </h3>
              <h3 class="fw-bold mb-3" v-else>
                DASHBOARD
              </h3>
            </div>
            <div class="card-body">                              
              <!-- Instance Selection -->                                
              <div class="row">
                <div class="col-sm-6 col-md-3" v-for="(instance, index) in instances" :key="index">
                  <div class="card card-stats card-round instance-card"
                     @click="handleCardClick(instance.id, instance.instanceName)"
                    :class="{ 'selectcard': selectedTemplate && selectedTemplate.id === instance.id }"
                    style="cursor: pointer; border: 2px solid #21d575 !important; background-color: #f0fdf4; border-radius: 10px; margin-bottom: 15px;">
                    <div class="card-body">
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">{{ instance.instanceName }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>              
              <div class="row" v-if="userRole === 'Super Admin' || userRole === 'Admin'">
                <div class="col-md-6 col-lg-6">
                  <h5 class="fw-bold mb-3">Client Name</h5>                               
                  <br/>
                </div>
                <div class="col-md-3 col-lg-3"></div>
                <div class="col-md-3 col-lg-3">                
                  <button class="btn"  style="background-color: #21d575;color: #fff;">Manage</button>                  
                </div>
              </div>
              <div class="row" v-if="userRole === 'Client'">
                 <div class="col-md-6 col-lg-6">                 
                </div>
                <div class="col-md-3 col-lg-3"></div>
                <div class="col-md-3 col-lg-3">                
                  <button class="btn" @click="routeInstanceView()" style="background-color: #21d575;color: #fff;">Manage</button>                  
                </div>
              </div>

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
</div>
</template>


<script setup>
import {onMounted, ref, reactive} from "vue";
import { useRoute,useRouter } from 'vue-router';
import axios from "axios";
import { instance } from "@/Api";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const router = useRouter();

const instances = ref([]);
const userRole = ref('');
const userId = ref('');
const isLoading = ref(true);
const selectedInstance = ref(null);

// Update your card click handler to only set the selected instance for Clients
const handleCardClick = (instanceId, instanceName) => {
  // Set the selected instance first
  selectedInstance.value = {
    id: instanceId,
    instanceName: instanceName
  };
  if (userRole.value === 'Super Admin' || userRole.value === 'Admin') {
    // Admin users go directly to edit instance page
    router.push({
      name: 'updateinstance',
      params: {
        id: instanceId,
        name: instanceName
      }
    });
  }
};
// Update the Manage button click function to navigate for Clients
const routeInstanceView = () => {
  // Check if an instance is selected
  if (selectedInstance.value) {
    if (userRole.value === 'Client') {
      // Now navigate when Manage button is clicked
      router.push({
        name: 'viewinstance',
        params: {
          id: selectedInstance.value.id,
          name: selectedInstance.value.instanceName,
          uid: userId.value,         
        }
      });
    } else if (userRole.value === 'Super Admin' || userRole.value === 'Admin') {
      router.push({
        name: 'updateinstance',
        params: {
          id: selectedInstance.value.id,
          name: selectedInstance.value.instanceName
        }
      });
    }
  } else {
    // Show alert when no instance is selected
    toast.warning("Please select an instance first");
  }
};

// fetch client instance
  // Function to get user auth data from localStorage
  const getUserAuthData = async () => {
    try {
      userId.value = localStorage.getItem("adminportalauthid");
      userRole.value = localStorage.getItem("adminportalauthrole");
    
      if (!userId.value) {
        toast.error("Authentication error. Please login again.");
        router.push('/login');
        return false;
      }
    
      return true;
    } catch (error) {
      console.error("Error fetching auth data:", error);
      toast.error("Authentication error. Please login again.");
      return false;
    }
  };

  // Function to fetch instances based on role
  const fetchInstances = async () => {
    isLoading.value = true;  
    const isAuthenticated = await getUserAuthData();
    if (!isAuthenticated) return;  
    try {
      let response;    
      if (userRole.value === 'Client') {
        // Client role - fetch only their instances
        response = await instance.get(`/viewClientInstance/${userId.value}`);        
      } else if (userRole.value === 'Super Admin' || userRole.value === 'Admin') {
        // Admin/SuperAdmin role - fetch all instances
        response = await instance.get(`/viewAllClientInstance/${userId.value}`);        
      } else {
        // Handle unknown role
        toast.warning("Unknown user role. Access restricted.");
        instances.value = [];
        isLoading.value = false;
        return;
      }    
      instances.value = response.data.instances;
    } catch (error) {
      console.error("Error fetching instances:", error);
      toast.error("Error loading instances. Please try again.");
      instances.value = [];
    } finally {
      isLoading.value = false;
    }
  };

  onMounted(() => {
    fetchInstances();
  });

</script>
