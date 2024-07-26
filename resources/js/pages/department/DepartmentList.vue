<template>
     <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Departments</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
              <li class="breadcrumb-item active">List of Department</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div id="department_list" class="col-12 col-md-12 ">
          <div class="card card-hrms card-outline">
            <div class="card-header">
              <h5 class="m-0 card-title">Department List</h5>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <button @click="addNewDepartment" 
                      class="btn btn-block btn-outline-primary"
                      >Add New Department</button
                    >
                  </li>
                </ul>
              </div>
            </div>
            <div class="card-body">
              <div v-if="departmentList.length > 0">
                <a-table class="antTable" :columns="columns" :data-source="departmentList" :row-selection="rowSelection" childrenColumnName="departments" defaultExpandAllRows="true" >
                  <template #bodyCell="{ column, record }">
                    <template v-if="column.key === 'action' ">
                      <!-- <a @click="logData(record)">Delete</a> -->
                      <a href="#"  aria-label="Add user to department" @click.prevent="addUserToDepartment(record.id)">
                            <i class="fas fa-users mr-1" aria-hidden="true"></i>
                         </a> || <a href="#"  aria-label="Edit department information" @click.prevent="selectToUpdateDepartment(record.id)">
                            <i class="fa fa-edit ml-1" aria-hidden="true"></i>
                         </a>
                    </template>
                    <template v-if="column.key === 'status'" >
                      <div v-html="showStatusActiveInactive(record.current_status)"></div>
                    </template>
                    <template v-if="column.key === 'manager'" >
                      <div v-html="getDepartmentLeadInfo(record.head)"></div>
                    </template>
                    <template v-if="column.key === 'mancom'" >
                      <div v-html="getDepartmentLeadInfo(record.mancom)"></div>
                    </template>
                  </template>
                </a-table>
                
              </div>
              <div v-else  class="text-center">
                <p class="text-muted">No data found</p>
              </div>
            </div>
          </div>
        </div>
        <!-- /.col-12 col-md-12 col-lg-6 -->
        
       
      </div>
    </div>
  </div>
  <Preloader :loading="loading" />
</template>
<script setup>
import { onMounted, ref, reactive } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';
import Preloader from "../../components/Preloader.vue";
import { showStatusActiveInactive, getDepartmentLeadInfo } from "../../functions";
// import { DEPARTMENT_STATUS } from '../../config/siteSettingsConsts.js';
import { useRoute, useRouter } from 'vue-router';
const router = useRouter();
const route = useRoute();
const logData = (data)=>{
  console.log(data);
};
const columns = [
  {
    title: 'Name',
    dataIndex: 'name',
    key: 'name',
  },
  {
    title: 'Description',
    dataIndex: 'description',
    key: 'description',
  },
  {
    title: 'Manager',
    dataIndex: 'manager',
    key: 'manager',
  },
  {
    title: 'Mancom',
    dataIndex: 'mancom',
    key: 'mancom',
  },
  {
    title: 'Status',
    dataIndex: 'status',
    key: 'status',
  },
  {
    title: 'Action',
    dataIndex: 'action',
    key: 'action',
  },
];

const loading = ref(false);
const errors = ref({});


const departmentList = ref([]);
const getDepartments = ()=>{
  loading.value = true;
  axios.get('/api/departments').then((response)=>{
    console.log(response.data);
    departmentList.value = response.data;
    loading.value = false;
  }).catch((error) => {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
            loading.value = false;
        }else{
          console.log(error.response);
          loading.value = false;
        }
    });
};

const addNewDepartment = () => {
  router.push("/admin/departments/add");
}

const selectToUpdateDepartment = (index)=>{
  router.push({ name: 'admin-department-edit', params: { id: index } });
}

const addUserToDepartment = (departmentId) => {
router.push({ name: 'admin-department-employees', params: { id: departmentId } });
};

onMounted(() => {
    getDepartments();
});
</script>
