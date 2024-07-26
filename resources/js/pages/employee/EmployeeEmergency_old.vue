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
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Emergency contact Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="callout callout-warning">
                                <p>Required fields are marked with a red asterisk <span class="text-danger">(*)</span>
                                </p>
                                <p><b>Employee:</b> Employee</p>
                                <p><b>Email:</b> Employee</p>
                            </div>

                            <form @submit.prevent="handleSubmit">
                                <div class="row">
                                    <div class="col-12 ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="first-name">First Name </label>
                                                    <input type="text" class="form-control" id="first-name" disabled
                                                        v-model="employeeInfo.first_name">

                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="middle_name">Middle Name</label>
                                                    <input type="text" class="form-control" id="middle_name"
                                                        v-model="employeeInfo.middle_name" disabled>

                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="last_name">Last Name </label>
                                                    <input type="text" class="form-control" id="last_name"
                                                        v-model="employeeInfo.last_name" disabled>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="extension_name">Extension Name</label>
                                                    <input type="text" class="form-control" id="extension_name"
                                                        v-model="employeeInfo.extension_name" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="nick-name">Nick Name</label>
                                                    <input type="text" class="form-control" id="nick-name"
                                                        v-model="employeeInfo.nick_name" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="nick-name">Job Title </label>
                                                    <input type="text" class="form-control" id="nick-name"
                                                        v-model="employeeInfo.job_title" disabled>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="email">Email </label>
                                                    <input type="email" class="form-control" id="email"
                                                        v-model="employeeInfo.email" disabled>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="fullName">Full Name <span class="text-danger">*</span></label>
                                            <input v-model="emergencyContact.full_name" type="text" class="form-control"
                                                id="fullName" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phoneNumber">Phone Number <span class="text-danger">*</span></label>
                                            <input v-model="emergencyContact.phone_number" type="text"
                                                class="form-control" id="phoneNumber" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="relationship">Relationship <span class="text-danger">*</span></label>
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


const pageName = ref({});
const buttonText = ref({});
const loading = ref(false);
const router = useRouter();
const route = useRoute();
const employeeId = parseInt(route.params.id, 10);
const emergencyContact = reactive({
    full_name: '',
    relationship: '',
    phone_number: '',
    email: '',
    address: '',
});
const employeeInfo = ref([]);
pageName.value = 'Add Contact Information';
buttonText.value = 'Add Contact';

const saveEmergencyContact = async (contactData) => {
  try {
    const response = await axios.post(`/api/employees/${employeeId}/emergency-contacts`, contactData);
    return response.data;
  } catch (error) {
    console.error('Failed to save emergency contact:', error);
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
onMounted(() => {
    fetchEmployee();
})
</script>