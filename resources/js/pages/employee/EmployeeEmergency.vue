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
                        <li class="breadcrumb-item"><router-link to="/admin/employees">List of Employees </router-link>
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
                <div class="col-12  col-sm-6">
                    <div class="card card-hrms card-outline">
                        <div class="card-header ">
                            <h5 class="card-title">Emergency Contact</h5>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button @click="clearForm" class="btn btn-block btn-genashtim"> <i
                                                class="fa fa-plus" aria-hidden="true"></i> Add New Contact</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="callout callout-info">

                                <p class="mb-1"><b>Employee:</b> {{getFullName(employeeInfo)}}</p>
                                <p><b>Email:</b> {{ employeeInfo.email }}</p>
                            </div>
                            <dl class="dl-contact">
                                <div v-for="(emergency, index) in emergencyList" :key="emergency.id">
                                    <dt>{{emergency.full_name}}</dt>
                                    <dd>
                                        <p class="pl-4">
                                            <b>Relationship: </b> {{emergency.relationship}} <br> <b>Contact: </b> {{emergency.phone_number}} -
                                            {{emergency.email}} <br><b>Address: </b> {{ emergency.address }}
                                        </p>
                                        <div class="contact-last-item text-right">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-outline-info"  @click.prevent="selectToUpdate(index)"><i
                                                        class="fas fa-edit"></i> Edit</button>
                                                <button type="button" class="btn btn-outline-danger" @click.prevent="deleteContact(index)"><i
                                                        class="fa fa-trash"></i> Delete</button>
                                            </div>

                                        </div>
                                    </dd>
                                </div>

                            </dl>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div  id="add_emergency" class="col-12  col-sm-6">
                    <div class="card card-hrms card-outline">
                        <div class="card-header">
                            <h5 class="m-0">{{editCardName}}</h5>
                        </div>
                        <div class="card-body">
                            <div class="callout callout-warning">
                                <p>Required fields are marked with a red asterisk <span class="text-danger">(*)</span>
                                </p>
                            </div>

                            <form @submit.prevent="handleSubmit">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="fullName">Full Name <span class="text-danger">*</span></label>
                                            <input v-model="emergencyContact.full_name" type="text" class="form-control"
                                                id="fullName" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phoneNumber">Phone Number <span
                                                    class="text-danger">*</span></label>
                                            <input v-model="emergencyContact.phone_number" type="text"
                                                class="form-control" id="phoneNumber" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="relationship">Relationship <span
                                                    class="text-danger">*</span></label>
                                            <input v-model="emergencyContact.relationship" type="text"
                                                class="form-control" id="relationship" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input v-model="emergencyContact.email" type="email" class="form-control"
                                                id="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea v-model="emergencyContact.address" class="form-control"
                                                id="address"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ buttonText }}</button>
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
import {getFullName, validateEmergencyContactForm } from "../../functions";

const pageName = ref({});
const editCardName = ref({});
const buttonText = ref({});
const loading = ref(false);
const emergencyList = ref([]);
const router = useRouter();
const route = useRoute();
const employeeId = parseInt(route.params.id, 10);
const emergencyContact = reactive({
    full_name: '',
    relationship: '',
    phone_number: '',
    employee_id: 0,
    email: '',
    address: '',
    id:0
});
const employeeInfo = ref([]);
const errors = ref({});
pageName.value = 'Add Contact Information';
buttonText.value = 'Add New Contact';
editCardName.value = 'Add Emergency Contact Information';


const clearForm = () =>{
  emergencyContact.id = 0;
  emergencyContact.full_name = '';
  emergencyContact.relationship = '';
  emergencyContact.phone_number = '';
  emergencyContact.email = '';
  emergencyContact.address = '';
  buttonText.value = "Add New Contact";
  editCardName.value = 'Add Emergency Contact Information';
  document.getElementById('add_emergency').scrollIntoView({behavior : 'smooth'});
};

const selectToUpdate = (index)=>{

if(index >= 0 && index < emergencyList.value.length){
    console.log(emergencyList.value[index]); 
    const data = emergencyList.value[index];
    emergencyContact.id = data.id;
    emergencyContact.full_name = data.full_name;
    emergencyContact.relationship = data.relationship;
    emergencyContact.phone_number = data.phone_number;
    emergencyContact.email = data.email;
    emergencyContact.address = data.address;
    emergencyContact.employee_id = data.employee_id;
    buttonText.value = "Update Contact Information";
    editCardName.value = 'Update Emergency Contact Information';
    document.getElementById('add_emergency').scrollIntoView({behavior : 'smooth'});
    console.log(emergencyContact); 

}
}
const deleteContact = (index)=>{
    if(index >= 0 && index < emergencyList.value.length){
    console.log(emergencyList.value[index]); 
    const data = emergencyList.value[index];
    const htmlData = '<p>Delete Emergency Contact <b>'+data.full_name+'</b> from <b>'+getFullName(employeeInfo.value)+'</b></p>'
    Swal.fire({
        title: 'Are you sure?',
        html: htmlData,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
      if (result.isConfirmed) {
        loading.value = true;
        axios.delete(`/api/employee/emergency-contact/${data.id}`).then((response) => {
            console.log(response.data);
            getEmergencyContact();
            Swal.fire(
                        'Success!',
                        'Emergency data has been updated. please check.',
                        'success'
           );
        }).catch((error) => {
            console.error(error);
        }).finally(() => {
            loading.value = false;
        });
      }
    });
} 
}

const handleSubmit =() =>{
    errors.value = validateEmergencyContactForm(emergencyContact);
   
    if (Object.keys(errors.value).length === 0) {
        var textNotification = emergencyContact.id == 0 ? "Do you want to add new emergency contact?" : "Do you want to update emergency information";
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
        loading.value = true;
        emergencyContact.employee_id = employeeId;
            axios.post(`/api/employee/${employeeId}/emergency-contact`, emergencyContact).then((response) =>{
                Swal.fire(
                        'Success!',
                        'Emergency data has been updated. please check.',
                        'success'
                    )
            }).catch((error) =>{
                Swal.fire(
                        'Error!',
                        'Something is wrong. please contact the administrator.',
                        'error'
                    )
                console.error(error);
            }).finally(() =>{
                getEmergencyContact();
                clearForm();
                loading.value = false;
            });
      }
    });

    } else {
                Swal.fire(
                    'Validation Error!',
                    'Please fill in all required fields.',
                    'error'
                );
            }
    
}
   
const fetchEmployee = () => {
    if (!isNaN(employeeId) && employeeId > 0) {
        loading.value = true;
        axios.get(`/api/employee/${employeeId}`).then((response) => {
            employeeInfo.value = response.data;
            console.log(employeeInfo);
        }).catch((error) => {
            console.error(error);
            Swal.fire(
                'No Employee Found!',
                'No Employee information available. Please try again.',
                'error'
            );
            router.push('/admin/dashboard');
        }).finally(() => {
            loading.value = false;
        });

    } else {
        Swal.fire(
            'No Employee Found!',
            'No Employee information available. Please try again.',
            'error'
        );
        router.push('/admin/dashboard');
    }
};
const getEmergencyContact = ()=>{
  loading.value = true;
  axios.get(`/api/employee/${employeeId}/emergency-contact`).then((response)=>{
    console.log(response.data);
    emergencyList.value = response.data;
    console.log(emergencyList);

  }).catch((error) => {
        console.error(error);
    }).finally(()=>{
      loading.value = false;
    });
};

onMounted(() => {
    fetchEmployee();
    getEmergencyContact();
})
</script>