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
                        <li class="breadcrumb-item"><router-link to="/admin/employees">List of Employee</router-link>
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
                            <h5 class="m-0">Employee Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="callout callout-warning">
                                <p>Required fields are marked with a red asterisk <span class="text-danger">(*)</span>
                                </p>
                            </div>
                            <form @submit.prevent="handleSubmit">

                                <div class="row">
                                    <div class="col-12 col-lg-9">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="first-name">First Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="first-name"
                                                        v-model="form.first_name" placeholder="Enter first name"
                                                        :class="{ 'is-invalid': errors.first_name }">
                                                    <div v-if="errors.first_name" class="invalid-feedback">{{
                                                        errors.first_name }}</div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="middle_name">Middle Name</label>
                                                    <input type="text" class="form-control" id="middle_name"
                                                        v-model="form.middle_name" placeholder="Enter middle name">

                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="last_name">Last Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="last_name"
                                                        v-model="form.last_name" placeholder="Enter last name"
                                                        :class="{ 'is-invalid': errors.last_name }">
                                                    <div v-if="errors.last_name" class="invalid-feedback">{{
                                                        errors.last_name }}</div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="extension_name">Extension Name</label>
                                                    <input type="text" class="form-control" id="extension_name"
                                                        v-model="form.extension_name"
                                                        placeholder="Enter extension name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="nick-name">Nick Name</label>
                                                    <input type="text" class="form-control" id="nick-name"
                                                        v-model="form.nick_name" placeholder="Enter nick name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="nick-name">Job Title  <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="nick-name"
                                                        v-model="form.job_title" placeholder="Enter Job Title" :class="{ 'is-invalid': errors.job_title }">
                                                    <div v-if="errors.job_title" class="invalid-feedback">{{
                                                        errors.job_title }}</div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="email">Email <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="email"
                                                        v-model="form.email" placeholder="Enter email"
                                                        :class="{ 'is-invalid': errors.email }" @blur="handleEmailAvatar">
                                                    <div v-if="errors.email" class="invalid-feedback">{{ errors.email }}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <div class="box-profile">
                                            <div class="text-center mt-4 pb-4">
                                                <img class="profile-employee-img img-fluid img-circle" v-if="avatarUrl"
                                                    :src="'/' + avatarUrl" alt="User profile picture">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="address" v-model="form.address"
                                                placeholder="Enter address" :class="{ 'is-invalid': errors.address }">
                                            <div v-if="errors.address" class="invalid-feedback">{{ errors.address }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="personal_email">Personal Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="personal_email"
                                                v-model="form.personal_email" placeholder="Enter Personal Email"
                                                :class="{ 'is-invalid': errors.personal_email }">
                                            <div v-if="errors.personal_email" class="invalid-feedback">{{
                                                errors.personal_email }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="phone-number">Phone Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="phone-number"
                                                v-model="form.phone_number" placeholder="Enter phone number"
                                                :class="{ 'is-invalid': errors.phone_number }">
                                            <div v-if="errors.phone_number" class="invalid-feedback">{{
                                                errors.phone_number }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="date-of-birth">Date of Birth <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="date-of-birth"
                                                v-model="form.date_of_birth"
                                                :class="{ 'is-invalid': errors.date_of_birth }">
                                            <div v-if="errors.date_of_birth" class="invalid-feedback">{{
                                                errors.date_of_birth }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="hire-date">Hire Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="hire-date"
                                                v-model="form.hire_date" :class="{ 'is-invalid': errors.hire_date }">
                                            <div v-if="errors.hire_date" class="invalid-feedback">{{ errors.hire_date }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="cat-status">Cat Status</label>
                                            <select class="form-control" id="cat-status" v-model="form.member_category">
                                                <option v-for="cs in member_category" :key="cs" :value="cs">{{ cs }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="gender">Gender <span class="text-danger">*</span></label>
                                            <select class="form-control" id="gender"
                                                :class="{ 'is-invalid': errors.gender }" v-model="form.gender">
                                                <option v-for="genderItem in gender" :key="genderItem"
                                                    :value="genderItem">{{ genderItem }}</option>
                                            </select>
                                            <div v-if="errors.gender" class="invalid-feedback">{{ errors.gender }}</div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">

                                        <div class="form-group">
                                            <label for="marital-status">Marital Status <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" id="marital-status"
                                                v-model="form.marital_status"
                                                :class="{ 'is-invalid': errors.marital_status }">
                                                <option v-for="ms in marital_status" :key="ms" :value="ms">{{ ms }}
                                                </option>
                                            </select>
                                            <div v-if="errors.marital_status" class="invalid-feedback">{{
                                                errors.marital_status }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="folder-link">CORE Folder Link <span
                                                    class="text-danger">*</span></label>
                                            <input type="url" class="form-control" id="folder-link"
                                                v-model="form.core_folder" placeholder="Enter CORE folder link"
                                                :class="{ 'is-invalid': errors.core_folder }">
                                            <div v-if="errors.core_folder" class="invalid-feedback">{{
                                                errors.core_folder }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="time-zone">Time Zone </label>
                                            <select class="form-control" id="time-zone" v-model="form.time_zone">
                                                <option v-for="zone in time_zones" :key="zone.value"
                                                    :value="zone.value"> {{ zone.name }} </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="country">Country <span class="text-danger">*</span></label>
                                            <select class="form-control" id="country"
                                                :class="{ 'is-invalid': errors.country }" v-model="form.country">
                                                <option v-for="country in countries" :key="country" :value="country">{{
                                                    country }}</option>
                                            </select>
                                            <div v-if="errors.country" class="invalid-feedback">{{ errors.country }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="employee-status">Employee Status <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" id="employee-status"
                                                v-model="form.current_status"
                                                :class="{ 'is-invalid': errors.current_status }">
                                                <option v-for="es in current_status" :key="es.value" :value="es.value">
                                                    {{ es.name }}</option>
                                            </select>
                                            <div v-if="errors.current_status" class="invalid-feedback">{{
                                                errors.current_status }}</div>
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

import { TIMEZONE_LIST, COUNTRY_LIST, EMPLOYEE_CATE_STATUS, EMPLOYEE_GENDER, EMPLOYEE_MARITAL_STATUS, EMPLOYEE_STATUS, DEFAULT_AVATAR } from "../../config/siteSettingsConsts.js";
import { validateEmployeeForm, isValidEmail } from "../../functions/validationFunctions.js";
import { updateFormData } from '../../functions/siteFunctions.js';

const pageName = ref({});
const buttonText = ref({});
const avatarUrl = ref({});
const loading = ref(false);
pageName.value = 'Add New Employee';
buttonText.value = 'Add Employee';
const form = reactive({
    id: 0,
    first_name: '',
    middle_name: '',
    last_name: '',
    extension_name: '',
    nick_name: '',
    job_title: '',
    email: '',
    phone_number: '',
    date_of_birth: '',
    hire_date: '',
    country: '',
    gender: '',
    marital_status: '',
    core_folder: '',
    time_zone: '',
    member_category: '',
    current_status: '',
    address: '',
    personal_email: '',
});
const errors = ref({});
const countries = COUNTRY_LIST;
const time_zones = TIMEZONE_LIST;
const gender = EMPLOYEE_GENDER;
const member_category = EMPLOYEE_CATE_STATUS;
const marital_status = EMPLOYEE_MARITAL_STATUS;
const current_status = EMPLOYEE_STATUS;
const router = useRouter();
const route = useRoute();
const employeeId = parseInt(route.params.id, 10);
avatarUrl.value = DEFAULT_AVATAR;

const fetchEmployee = async () => {
    if (!isNaN(employeeId) && employeeId > 0) {
        try {
            const response = await axios.get(`/api/employee/${employeeId}`);
            updateFormData(form, response.data);
            handleEmailAvatar();
            console.log(form);
            pageName.value = 'Edit Employee';
            buttonText.value = 'Update Employee';
        } catch (error) {
            console.error('Failed to fetch employee:', error);
            pageName.value = 'Add New Employee';
        }
    } else {
        pageName.value = 'Add New Employee';
        buttonText.value = 'Add Employee';
    }

};

const handleSubmit = async () => {

    errors.value = validateEmployeeForm(form);
    console.log(form);
    console.log(errors);
    if (Object.keys(errors.value).length === 0) {

        Swal.fire({
            title: 'Are you sure you want to save the changes?',
            text: "Data will be saved in the system",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, go ahead and save'
        }).then(async (result) => {
            if (result.isConfirmed) {
                loading.value = true;
                try {
                    const response = form.id == 0 ? await axios.post('/api/employee', form) : await axios.put('/api/employee/' + form.id, form);

                    console.log(response);
                    loading.value = false;
                    router.push('/admin/employees');
                    Swal.fire(
                        'Success!',
                        'Profile updated successfully.',
                        'success'
                    );
                } catch (error) {
                    console.error(error);
                    loading.value = false;
                    if (error.response && Object.keys(error.response.data.errors).length > 0) {
                        let errorData = error.response.data.errors;
                        let html = '<ul>';
                        for (const field in errorData) {
                            if (errorData.hasOwnProperty(field)) {
                                html += `<li><strong>${field.replace(/_/g, ' ')}</strong>: ${errorData[field].join(', ')}</li>`;
                            }
                        }
                        html += '</ul>';
                        Swal.fire(
                            'Validation Error!',
                            html,
                            'error'
                        );
                        return;
                    }
                }
            }
        });
    } else {
        Swal.fire(
            'Validation Error!',
            'Please fill in all required fields.',
            'error'
        );
    }
};
const handleEmailAvatar = async () => {
    if (isValidEmail(form.email)) {
        try {
            const response = await axios.get(`/api/graph/get-avatar/${form.email}`);
            console.log(response.data);
            avatarUrl.value = response.data.imageUrl;
        } catch (error) {
            console.error('Failed to fetch image URL:', error);
            avatarUrl.value = DEFAULT_AVATAR;
        }
    } else {
        console.log('Invalid email address');
        avatarUrl.value = DEFAULT_AVATAR;
    }
};
onMounted(() => {
    fetchEmployee();
   
});
</script>