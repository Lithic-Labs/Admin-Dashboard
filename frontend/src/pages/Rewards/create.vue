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
                                    <h3 class="fw-bold mb-3">Rewards Editor</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                           <form @submit.prevent="submitForm" >                                                           
                                <div class="card-body">
                                    <h4 class="fw-bold mb-3">{{ instanceName }}- Rewards</h4>                               
                                    <br/>                                                       
                                    <div class="row">
                                        <div class="col-md-2" style="font-size: large;">Reward Type</div>
                                        <div class="col-md-4">                                                                                                          
                                          <select id="role" name="rewards" class="form-control" v-model="form.rewards">
                                              <option value="Discount Codes">Discount Codes</option>    
                                              <option value="Loyalty Points">Loyalty Points</option>
                                              <option value="Coupons">Coupons</option>                                               
                                          </select>
                                        </div>
                                        
                                    </div>
                                    <br/>
                                    
                                  <div class="row">
                                    <div class="col-md-2" style="font-size: large;">Rewards List</div>
                                    <div class="col-md-4">                                                                                                          
                                      <label for="csvFileInput" class="btn text-white" style="background-color: #21d575;color: #fff;">
                                          CSV Upload
                                          <input
                                              id="csvFileInput"
                                              type="file"
                                              class="form-control-file d-none"
                                              @change="handleCsvUpload"
                                              accept=".csv"
                                          />
                                      </label>                                 
                                    </div> 
                                    <div class="col-md-2" style="font-size: large;">Rewards Left</div>
                                    <div class="col-md-4">                                                                                                          
                                         
                                          
                                    </div>                                    
                                  </div>    
                                  <br/>  
                                  <div class="row">
                                    <div class="col-md-6">
                                      <table class="table">
                                        <thead>
                                          <tr>                                           
                                            <th>Code</th>
                                            <th>Amount</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr v-for="(detail, index) in rewardsdetails" :key="index">                                           
                                            <td>{{ detail.code }}</td>
                                            <td>{{ detail.amount }}</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
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
import { ref, reactive, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { instance } from '@/Api';
import 'vue3-toastify/dist/index.css';

const route = useRoute();

const instanceName = ref(route.params.name);
const instanceId = ref(route.params.id); 

// Store form fields
const form = reactive({
  rewards: '', 
});

// Store selected files
const csvFile = ref(null);
const csvFileName = ref("");
const userId = ref("");
const rewardsdetails = ref([]);
const reward = ref("");

const error = reactive({
  rewards: '', 
});

// validation function
const validatedForm = ()=>{
  let isValid = true;
  if(!form.rewards.trim()){
    error.title = "Rewards is required";
    isValid = false;
  } 
  return isValid;
};

// Handle CSV file upload
const handleCsvUpload = (event) => {
  const file = event.target.files[0];
  if (file && file.type === "text/csv") {
    csvFile.value = file;
    csvFileName.value = file.name;
  } else {
    alert("Please upload a valid CSV file!");
    csvFile.value = null;
    csvFileName.value = "";
  }
};

  // Submit form function
  // const submitForm = async () => { 
  //     if (validatedForm()) {
  //         const formData = new FormData(); 
  //         userId.value = localStorage.getItem("adminportalauthid");
  //         formData.append("userId", userId.value);
  //         formData.append("instanceId", instanceId.value);
  //         formData.append("rewards", form.rewards || "");  

  //         // Append CSV file if selected
  //         if (csvFile.value) {
  //             formData.append("csvFile", csvFile.value);
  //         }

  //         try {
  //             await instance.post("createrewards", formData, {
  //                 headers: { "Content-Type": "multipart/form-data" },
  //             });
  //             console.log("Upload successful!");
  //         } catch (error) {
  //             console.error("Upload failed!", error);
  //         }
  //     }
  // };

  const submitForm = async () => {
    if (validatedForm()) {
      const formData = new FormData();
      userId.value = localStorage.getItem("adminportalauthid");
      formData.append("userId", userId.value);
      formData.append("instanceId", instanceId.value);
      formData.append("rewards", form.rewards || "");

      if (csvFile.value) {
        formData.append("csvFile", csvFile.value);
      }

      try {
        await instance.post(`updaterewards/${instanceId.value}`, formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });
        console.log("Update successful!");
      } catch (error) {
        console.error("Update failed!", error);
      }
    }
  };


  const editRewardDetails = async ()=>{
    try {
      const response = await instance.get(`editrewards/${instanceId.value}`);
    
      if (response.data && response.data.reward) {
        rewardsdetails.value = response.data.reward_details || [];
        form.rewards = response.data.reward.rewards_type || '';
      } else {
        // If no reward is returned
        rewardsdetails.value = [];
        form.rewards = '';
      }

    } catch (error) {
      console.error("Error fetching reward details:", error);

      // Handle not found (404) or other errors by setting default values
      rewardsdetails.value = [];
      form.rewards = '';
    }

  };

  onMounted(()=>{
    editRewardDetails();
  });
</script>
