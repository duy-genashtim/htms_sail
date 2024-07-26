<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Employees</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <router-link to="/admin/employees">Home</router-link>
            </li>
            <li class="breadcrumb-item active">Employees List</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-hrms card-outline">
            <div class="card-header">
              <h5 class="m-0 card-title">Employee List</h5>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <button
                      @click="addNewEmployee"
                      class="btn btn-block btn-outline-primary"
                    >
                      Add New Employee
                    </button>
                  </li>
                </ul>
              </div>
            </div>
            <div class="card-body">
              <div v-if="employees.length > 0">
              <table class="table table-bordered hrms-table">
                <thead>
                  <tr>
                    <th width="50"></th>
                    <th>Full Name</th>
                    <th>Nick Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Country</th>
                    <th>Gender</th>
                    <th>Departments</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(employee) in employees" :key="employee.id">
                    <td> <img :src="employee.imageSrc" class="img-circle img-size-32" alt="{{ employee.nick_name }}" /></td>
                    <td> <router-link :to="{ name: 'admin-employee-view', params: { id: employee.id } }">{{ getFullName(employee) }}</router-link></td>
                    <td>{{ employee.nick_name }}</td>
                    <td>{{ employee.email }}</td>
                    <td>{{ employee.phone_number }}</td>
                    <td>{{ employee.country }}</td>
                    <td>{{ employee.gender }}</td>
                    <td>
                      <ul>
                        <li
                          v-for="department in employee.departments"
                          :key="department.id"
                        >
                          {{ department.name }} 
                        </li>
                      </ul>
                    </td>
                    <td>
                      <a href="#" aria-label="Edit user information"  @click.prevent="editUser(employee.id)">
                        <i class="fa fa-edit mr-2"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
              </div>
              <div v-else  class="text-center">
                <p class="text-muted">No data found</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Preloader :loading="loading" />
</template>
<script setup>

import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from "vue-router";
import {getFullName, checkAvatarImage } from "../../functions";
import Preloader from "../../components/Preloader.vue";
const loading = ref(false);

const employees = ref([]);
const router = useRouter();
const addNewEmployee = () => {
  router.push("/admin/employees/add");
};
const fetchEmployees = async () => {
  loading.value = true;
  try {
    const response = await axios.get('/api/employee');
    // employees.value = response.data;
    employees.value = response.data.map(employee => ({
      ...employee,
      imageSrc: '/storage/images/avatars/no_image.jpg' // Default image initially
    }));
    for (let i = 0; i < employees.value.length; i++) {
      employees.value[i].imageSrc = await checkAvatarImage(employees.value[i].email);
    }
  console.log(employees.value);
    loading.value = false;
  } catch (error) {
    console.error(error);
    loading.value = false;
  }
};

const editUser = (employeeId) => {
  router.push({ name: 'admin-employee-edit', params: { id: employeeId } });
};

onMounted(() => {
  fetchEmployees();
});
</script>