<template>
    <div>
        <!-- sidebar -->
        <SidebarComponent/>       
        <div class="wrapper">
            <div class="main-panel">
                <div class="main-header">
                    <div class="main-header-logo">
                        <!-- Logo Header -->
                        <div class="logo-header" data-background-color="dark">
                            <a href="index.html" class="logo">
                            <img
                                src="@/assets/img/kaiadmin/logo_light.svg"
                                alt="navbar brand"
                                class="navbar-brand"
                                height="20"
                            />
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
                <!-- Navbar Header -->
                    <HeaderComponent/>
                <!-- End Navbar -->
                    </div>
                    <br/>
                    <br/>         
                <v-main style="background-color: #EDEDED;">    
                    <router-view />
                </v-main>   
        </div>
        </div>
    </div>
  </template>
  
<script>
import HeaderComponent from "@/components/HeaderComponent.vue";
import SidebarComponent from "@/components/SidebarComponent.vue";

  export default {
    components: {
    SidebarComponent, 
      HeaderComponent   
    },
  };
  </script>
  