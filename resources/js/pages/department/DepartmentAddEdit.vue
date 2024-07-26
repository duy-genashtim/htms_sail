<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ pageName }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item"><router-link to="/admin/departments">List of Department</router-link>
                        </li>
                        <li class="breadcrumb-item active">{{ pageName }}</li>
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
                            <h5 class="m-0">Department Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="callout callout-warning">
                                <p>Required fields are marked with a red asterisk <span class="text-danger">(*)</span>
                                </p>
                            </div>
                            <form @submit.prevent="handleSubmit">
   
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Department Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" v-model="form.name"
                                                placeholder="Name of the Department" :class="{ 'is-invalid': errors.name }" @input="autoSlug">
                                            <div v-if="errors.name" class="invalid-feedback">{{ errors.name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="slug"> Auto Slug </label>
                                            <input disabled type="email" class="form-control" id="slug"
                                                v-model="form.slug" placeholder="Name on URL">
                                            
                                        </div>
                                    </div>
                                </div>
                               

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                        <label>Description</label>
                                        <textarea v-model="form.description" class="form-control" rows="2" placeholder="Enter ..."></textarea>
                                    </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="managerId">Parent Department</label>
                                            <a-tree-select
                                            class="form-control"
                                                v-model:value="form.parent_id"
                                                show-search
                                                style="width: 100%"
                                                :dropdown-style="{ maxHeight: '400px', overflow: 'auto' }"
                                                placeholder="Please select"
                                                allow-clear
                                                tree-default-expand-all
                                                :tree-data="treeData"
                                                tree-node-filter-prop="label"
                                            >
                                                <template #title="{ value: val, label }">
                                                <b v-if="val === 'parent 1-1'" style="color: #08c">sss</b>
                                                <template v-else>{{ label }}</template>
                                                </template>
                                            </a-tree-select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="mancomId">Select Mancom</label>
                                        <a-select id="mancomId"  class="form-control" show-search style="width: 100%;" 
                                        v-model:value="form.mancom_id" :options="employeeOptions"
                                        placeholder="Input Name to search"
                                        :filter-option="employeesFilterOption">
                                       
                                        </a-select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="managerId">Select Manager</label>
                                        <a-select id="managerId"  class="form-control" show-search style="width: 100%;" 
                                        v-model:value="form.head_id" :options="employeeOptions"
                                        placeholder="Input Name to search"
                                        :filter-option="employeesFilterOption">
                                        
                                        </a-select>
                                    </div>
            
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                        <label for="managerId">Is Mancom Department</label>
                                            <a-switch class="switch_block" v-model:checked="form.is_mancom" checked-children="Mancom" un-checked-children="Not Mancom" />
                                       
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                        <label for="managerId">Status</label>
                                            <a-switch class="switch_block" v-model:checked="form.current_status" checked-children="Active" un-checked-children="InActive" />
                                       
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">{{buttonText}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Preloader :loading="loading" />
</template>
<script setup>
import { onMounted, reactive, ref } from 'vue';
import Preloader from "../../components/Preloader.vue";
import Swal from 'sweetalert2';
import { useRouter, useRoute } from 'vue-router';

import { validateEmployeeForm,updateFormData, textToSlug, toggleParentId, toggleBoolean } from "../../functions";

const pageName = ref({});
const buttonText = ref({});
const loading = ref(false);
pageName.value = 'Add New Department';
buttonText.value = 'Add Department';
const form = reactive({
    id: 0,
    name: '',
    slug: '',
    description: '',
    parent_id: 0,
    mancom_id: null,
    head_id: null,
    current_status: true,
    is_mancom: false,
});
const errors = ref({});
const treeData = ref([]);
const employeeOptions = ref([]);
const router = useRouter();
const route = useRoute();
const deptId = parseInt(route.params.id, 10);
const validateForm = () => {
  errors.value = {}; // Reset errors
  if (!form.name) {
    errors.value.name = 'Name is required';
    return false;
  }
  return true;
};

const employeesFilterOption = (input, option) => {
  return option.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;
};

// const convertDepartmentsToTreeData = (departments) => {
//   return [...departments.map(department => ({
//     label: department.id === 3 ? department.name + '(cant select)': department.name,
//     value: department.id,
//     disabled: department.id === 3,
//     children: department.departments.length > 0 ? convertDepartmentsToTreeData(department.departments) : []
//   }))];
// };
const convertDepartmentsToTreeData = (departments, isRoot = true) => {
  // Default option for the root level only
  const defaultOption = {
    value: 0,
    label: '-- Select a Parent Department --',
  };

  // Map departments to tree data structure
  const departmentTree = departments.map(department => ({
    label: form.id >0 && department.id === form.id ? department.name + ' (Current department - Can\'t select)' : department.name,
    value: department.id,
    disabled: form.id >0 && department.id === form.id,
    children: department.departments.length > 0 ? convertDepartmentsToTreeData(department.departments, false) : []
  }));

  // If it's the root level, prepend the default option
  return isRoot ? [defaultOption, ...departmentTree] : departmentTree;
};

const convertEmployeeOptions = (employees) => {
    const defaultOption = {
    value: null,
    label: ' -- Select if Applicable --' 
  };
  return [ defaultOption, ...employees.map(employee => ({
    value: employee.id,
    label: `${employee.first_name} ${employee.last_name} (${employee.email})`
  }))];
};

const getDepartments = ()=>{
  loading.value = true;
  axios.get('/api/departments').then((response)=>{
    console.log(response.data);
    // departmentList.value = response.data;
    treeData.value = convertDepartmentsToTreeData(response.data);
    console.log('treeData.value = ');
    console.log(treeData.value);
    loading.value = false;
  }).catch((error) => {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        }
        loading.value = false;
    });
};
const getEmployees = () => {
  loading.value = true;
  axios.get('/api/employee').then((response)=>{
    console.log('response.data ');
    // console.log(response.data);
    employeeOptions.value = convertEmployeeOptions(response.data);
  }).catch((error) => {
        
        console.error(error);
        loading.value = false;
    });
 
};

const autoSlug = () => {
    form.slug = textToSlug(form.name); // Update input2 with input1's value
  };

const fetchDepartment = async () => {
    if (!isNaN(deptId) && deptId > 0) {
        try {
            const response = await axios.get(`/api/departments/${deptId}`);
            updateFormData(form, response.data);
            console.log('data from response.data');
            console.log(form);
            toggleParentId(form);
            form.current_status = toggleBoolean(form.current_status);
            form.is_mancom = toggleBoolean(form.is_mancom);
            console.log(form);
            
            pageName.value = 'Edit Department';
            buttonText.value = 'Update Information';
        } catch (error) {
            console.error('Failed to fetch department:', error);
            pageName.value = 'Add New Department';
        }
    } else {
        pageName.value = 'Add New Department';
        buttonText.value = 'Add Department';
    }

};

const handleSubmit = async () => {
    toggleParentId(form);
    console.log(form);

    if (!validateForm()) {
    Swal.fire(
      'Validation Error!',
      'Please fill in all required fields.',
      'error'
    );
    return;
  }
  var textNotification = form.id == 0 ? "Do you want to add new department?" : "Do you want to update department information";
  Swal.fire({
        title: 'Are you sure?',
        text: textNotification,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, go ahead!'
    }).then((result) => {
      if (result.isConfirmed) {
        axios.post('/api/departments',form).then((response)=>{
          console.log(response.data);
          router.push('/admin/departments');
          Swal.fire(
                'Success!',
                'Department data has been updated. please check.',
                'success'
            )
        }).catch((error) => {
              if (error.response && error.response.status === 422) {
                  errors.value = error.response.data.errors;
                  Swal.fire(
                        'Error!',
                        'Something is wrong. please contact the administrator.',
                        'error'
                    )
              }

        });
      }
    });

};
onMounted(() => {
    fetchDepartment();
    getDepartments();
    getEmployees();
});
</script>