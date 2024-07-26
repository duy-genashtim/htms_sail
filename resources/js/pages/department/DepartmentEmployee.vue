<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Department Details</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><router-link to="/admin/dashboard">Home</router-link></li>
            <li class="breadcrumb-item"><router-link to="/admin/departments">List of Department</router-link>
            </li>
            <li class="breadcrumb-item active">Department Details</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="callout callout-hrms">
            <h5><i class="fas fa-info"></i> Note:</h5>
            Please review the department information and employee list below. Ensure thorough checking before adding or
            removing employees from the department.
            <p class="text-success">Default department of employee marked in green for employees with multiple
              departments.</p>
          </div>


          <!-- Main content -->
          <div v-if="Object.keys(departmentInfo).length > 0" class="invoice p-3 mb-3 ">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  <i class="fas fa-globe"></i> {{ departmentInfo.name }}
                  <small class="float-right">Added Date: {{ formatDatePretty(departmentInfo.created_at) }}</small>
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                {{ departmentInfo.description }} <br>
                <div v-html="showStatusActiveInactive(departmentInfo.current_status)"></div>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <b>Mancom</b><br><br>

                <strong v-if="typeof departmentInfo.mancom === 'object' && departmentInfo.mancom">{{
                  getFullName(departmentInfo.mancom)}}</strong><br>
                <p v-if="typeof departmentInfo.mancom === 'object' && departmentInfo.mancom">{{
                  departmentInfo.mancom.email}}</p>


              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <b>Manager</b><br><br>
                <strong v-if="typeof departmentInfo.head === 'object' && departmentInfo.head">{{
                  getFullName(departmentInfo.head)}}</strong><br>
                <p v-if="typeof departmentInfo.head === 'object' && departmentInfo.head">{{ departmentInfo.head.email }}
                </p>

              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-12 ">
                <a-transfer class="hrms-transfer" v-model:target-keys="employeeInData"
                  v-model:target-selected-keys="employeeInDataSelected" :data-source="allEmployeeData"
                  :titles="[' - Available List', ' - In Department\'s List']" show-search :list-style="{
                    width: '100%',
                    height: '400px',
                  }" :operations="['Add', 'Remove']" :filter-option="employeesFilterOption"
                  :locale="transferLocale" @selectChange="handleSelectChange">
                  <template #render="item">
                    <span class="hrms-transfer-custom-item"
                      :class="{ 'text-green': item.main_dept === 1, 'text-primary': item.main_dept !== 1 }">{{
                      item.title }}<span v-if="item.description.length > 0"> - </span>{{ item.description }} </span>
                  </template>
                  <template #notFoundContent>
                    <span>No Data Found</span>
                  </template>
                </a-transfer>
              </div>
              <!-- /.col -->
              <div class="col-12">
                <button style="float: right; margin: 5px" @click="modifyEmployees"
                  class="btn btn-outline-success btn-lg mt-2 mr-2">
                  Mark/Unmask as Main Department
                </button>
                <button style="float: right; margin: 5px" @click="addEmployeeToDepartment"
                  class="btn btn-outline-primary btn-lg mt-2 mr-2">
                  Save Employees to Department
                </button>
              </div>
            </div>
            <!-- /.row -->

          </div>
          <div v-else>
            Loading department information...
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
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
import { useRouter, useRoute } from 'vue-router';


import { formatDatePretty, getNestedValue, showStatusActiveInactive, getFullName } from "../../functions";

const router = useRouter();
const route = useRoute();
const deptId = parseInt(route.params.id, 10);

const departmentInfo = ref([]);
const loading = ref(false);
const errors = ref({});

const allEmployeeData = ref([]);
const employeeInData = ref([]);
const employeeInDataSelected = ref([]);

const transferLocale = {
  itemUnit: 'Employee',
  itemsUnit: 'Employees',
  notFoundContent: 'The list is Employee',
  searchPlaceholder: 'Search employee here'
};

const addEmployeeToDepartment = () => {
  Swal.fire({
    title: 'Are you sure?',
    text: "Save all employees under the department list to the database.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, go ahead!'
  }).then((result) => {
    if (result.isConfirmed) {
      const payload = {
        employeeIds: employeeInData.value,
      };

      // Make the API request
      axios.post(`/api/departments/${deptId}/employees`, payload)
        .then(response => {
          // Handle success
          console.log('Save successful:', response.data);
          getEmployees();

          Swal.fire(
            'Success!',
            'Employee list data has been updated. please check.',
            'success'
          )
          // alert('Employees have been successfully updated.');
        })
        .catch(error => {
          // Handle error
          console.error('Error saving employees:', error);
          // alert('Failed to update employees.');
        });
    }
  });

}
function generateEmployeeHtmlList(employees) {
  let htmlContent = '<ul>';
  employees.forEach(employee => {
    htmlContent += `<li>${employee.title}</li>`;
  });
  htmlContent += '</ul>';
  return htmlContent;
}

const modifyEmployees = () => {
  console.log(employeeInDataSelected);
  const employeeAffected = allEmployeeData.value.filter(emp => employeeInDataSelected.value.includes(emp.key));
  const htmlContent = generateEmployeeHtmlList(employeeAffected);
  console.log(employeeAffected);
  Swal.fire({
    title: 'Are you sure?',
    // text: "Change main department setting for: ",
    html: `
          <p>Change main department setting for:</p>
          ${htmlContent}
        `,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, go ahead!',
    cancelButtonText: 'No, cancel!'
  }).then((result) => {
    if (result.isConfirmed) {
      axios.patch(`/api/departments/${deptId}/toggle-main`, { employeeIds: employeeInDataSelected.value })
        .then(response => {
          console.log('Toggle successful for multiple employees', response.data);
          getEmployees();
          Swal.fire(
            'Success!',
            'Employee list data has been updated. please check.',
            'success'
          );
          // Update UI or state as needed
        })
        .catch(error => {
          console.error('Error toggling main department for multiple employees', error.response.data);
          // Handle error
        });
    }
  });

}

const employeesFilterOption = (input, option) => {
  return option.title.toLowerCase().indexOf(input.toLowerCase()) >= 0;
};

const handleSelectChange = (sourceSelectedKeys, targetSelectedKeys) => {
  console.log('sourceSelectedKeys: ', sourceSelectedKeys);
  console.log('targetSelectedKeys: ', targetSelectedKeys);
  employeeInDataSelected.value = targetSelectedKeys;
};

const fetchDepartment = () => {
  if (!isNaN(deptId) && deptId > 0) {
    loading.value = true;
    axios.get(`/api/departments/${deptId}`).then((response) => {
      departmentInfo.value = response.data;
      // const departmentInfo = reactive({});
      // Object.assign(departmentInfo, response.data);
      // console.log(departmentInfo.name);
      getEmployees();
      console.log(departmentInfo.value.name);
    }).catch((error) => {
      console.error('Failed to fetch department:', error);

    }).finally(() => {
      loading.value = false;
    });

  } else {

  }

};

const getEmployees = () => {
  loading.value = true;
  axios.get(`/api/employee/${deptId}/department`).then((response) => {

    const { employeeOptions, targetKeys } = processDataForTransfer(response.data.all_employee, response.data.in_department, deptId);

    allEmployeeData.value = employeeOptions;
    employeeInData.value = targetKeys;
    // allEmployeeData.value = convertEmployeeOptions(response.data.not_in_department);
    // employeeInData.value = convertEmployeeOptions(response.data.in_department);
    console.log('response.data ');
    console.log(response.data);
    console.log(allEmployeeData);
  }).catch((error) => {
    console.error(error);
  }).finally(() => {
    loading.value = false;
  });

};

const processDataForTransfer = (allEmployees, inDepartment, currentDeptId) => {
  const employeeOptions = allEmployees.map(employee => {
    // Create description based on department memberships
    const description = employee.departments.length > 0
      ? employee.departments
        .filter(dept => dept.id !== currentDeptId) // Filter out the current department
        .map(dept => dept.name)
        .join(' | ') // Join department names with a pipe
      : 'No department';
    const main_dept = employee.departments.some(dept =>
      dept.id === currentDeptId && dept.pivot.is_main_department === 1
    ) ? 1 : 0;
    return {
      key: employee.id.toString(),
      title: `${employee.first_name} ${employee.last_name} (${employee.email})`,
      description: description,
      main_dept: main_dept
    };
  });

  // Generate target-keys from in_department data
  const targetKeys = inDepartment.map(emp => emp.id.toString());

  return { employeeOptions, targetKeys };
};

onMounted(() => {

  fetchDepartment();
});
</script>
