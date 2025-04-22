<template>
  <div class="sidebar" style="background-color: black;">
    <div class="sidebar-logo">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="dark">
        <a href="index.html" class="logo" style="color:white">
          <!-- <img
          src="@/assets/img/kaiadmin/logo_light.svg"
          alt="navbar brand"
          class="navbar-brand"
          height="20"
          /> -->
          ADVERGAMES
        </a>
        <div class="nav-toggle">
          <button class="btn btn-toggle toggle-sidebar">
            <i class="gg-menu-right"></i>
          </button>
          <button class="btn btn-toggle sidenav-toggler">
            <i class="gg-menu-left"></i>
          </button>
        </div>
        <button class="topbar-toggler more">
          <i class="gg-more-vertical-alt"></i>
        </button>
      </div>
      <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
      <div class="sidebar-content">
        <ul class="nav nav-secondary">
          <li class="nav-item active">
            <router-link to="/dashboard" class="collapsed">
              <font-awesome-icon :icon="['fas', 'house']" style="margin-right:30px;margin-left:10px;color:white"/>
              <span style="color:white">Dashboard</span>
            </router-link>                  
        </li>
        
          <li class="nav-section" v-if="userRole === 'Super Admin' || userRole === 'Admin'" >
            <span class="sidebar-mini-icon">
              <i class="fa fa-ellipsis-h"></i>
            </span>
            <h4 class="text-section" style="color:white">Templates</h4>
          </li>
          <li class="nav-item" v-if="userRole === 'Super Admin' || userRole === 'Admin'">               
            <router-link to="/template" class="collapsed">           
              <font-awesome-icon :icon="['fas', 'gamepad']" style="margin-right:30px;margin-left:10px;color:white"/>
              <span style="color:white">Template</span>
            </router-link>       
          </li>   
         
         
        <li class="nav-section" v-if="userRole === 'Super Admin' || userRole === 'Admin'">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section" style="color:white">Setting</h4>          
        </li>        
       
        <li class="nav-item" v-if="userRole === 'Super Admin' || userRole === 'Admin'">       
          <router-link to="/user" class="collapsed">
            <font-awesome-icon :icon="['fas', 'user']" style="margin-right:30px;margin-left:10px;color:white"/>
            <span style="color:white">User Management</span>
          </router-link>                  
        </li>                 
      </ul>
    </div>
  </div>
</div>
</template>

<script setup>
  import {onMounted, ref, reactive} from "vue";
  import { useRouter } from "vue-router"; 

  const userRole = ref('');
  const router = useRouter();

  const getAuthDetails = () => {
    try {
      const storeduserRole = localStorage.getItem("adminportalauthrole");
     
      if (storeduserRole) {
        userRole.value = storeduserRole;
      } else {
        toast.error("Authentication error. Please login again.");
        router.push("/");
      }
    } catch (error) {
      console.error("Error fetching auth data:", error);
      toast.error("Authentication error. Please login again.");
    }
  };

  onMounted(()=>{
    getAuthDetails()
  })
</script>