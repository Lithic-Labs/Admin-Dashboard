<template>
  <div class="sidebar" data-background-color="dark">
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
          ADVERGAME
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
              <font-awesome-icon :icon="['fas', 'house']" style="margin-right:30px;margin-left:10px"/>
              <p>Dashboard</p>
            </router-link>
                  
        </li>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Game Management</h4>
        </li>
        <li class="nav-item">          
          <router-link to="/template" class="collapsed">           
            <font-awesome-icon :icon="['fas', 'gamepad']" style="margin-right:30px;margin-left:10px"/>
            <p>Template</p>
          </router-link>       
        </li>  
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Setting</h4>
        </li>         
       
        <li class="nav-item">       
          <router-link to="/user" class="collapsed">
            <font-awesome-icon :icon="['fas', 'user']" style="margin-right:30px;margin-left:10px"/>
            <p>User Management</p>
          </router-link>                  
        </li>                 
      </ul>
    </div>
  </div>
</div>
</template>
