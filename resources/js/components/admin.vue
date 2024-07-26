<template>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"
          ><i class="fas fa-bars"></i
        ></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/logout" class="nav-link">Logout</a>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <router-link to="/admin/dashboard"  class="brand-link">
      <img
        src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png"
        alt="AdminLTE Logo"
        class="brand-image img-circle elevation-3"
        style="opacity: 0.8"
      />
      <span class="brand-text font-weight-light">{{ appName }}</span>
    </router-link>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- <img
            src="/storage/images/avatars/no_image.jpg"
            class="img-circle elevation-2"
            alt="{{ authUserStore.user.name }}"
          /> -->
          <img v-if="authUserStore.user.avatar" 
           v-bind:src="'/'+ authUserStore.user.avatar"
            class="img-circle elevation-2"
             :alt="authUserStore.user.name ? `Avatar of ${authUserStore.user.name}` : 'User avatar'"
          />
        </div>
        <div class="info">
          <a href="#" class="d-block"
            >{{ authUserStore.user.name }}</a
          >
        </div>
      </div>

      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <li class="nav-item">
            <router-link active-class="active" to="/admin/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link active-class="active" to="/admin/employees" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Employees</p>
            </router-link>
            </li>
          <li class="nav-item">
            <router-link active-class="active" to="/admin/departments" class="nav-link">
                <i class="nav-icon fa fa-building"></i>
                <p>Departments</p>
            </router-link>
            </li>
           
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <router-view></router-view>
   
  </div>


  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">{{ appVersion }}</div>

    <div v-html="copyright"></div>
  </footer>
 
</template>

<script setup>
import { useAuthUserStore } from "../stores/AuthUserStore.js";
import { onMounted } from "vue";
import {appName,appVersion,copyright} from "../config/constants.js";
// import { useRouter } from "vue-router";
// const router = useRouter();
const authUserStore = useAuthUserStore();
const { user, getAuthUser } = authUserStore;
const fetchUser = async () => {
  try {
    await getAuthUser().then(console.log(user));
  } catch (error) {
    console.error('Authentication error:', error);
    window.location.href = '/login';
  }
  
};

onMounted(() => {
  fetchUser();
});
</script>