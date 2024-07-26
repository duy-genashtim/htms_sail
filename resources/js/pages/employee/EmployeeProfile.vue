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
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-hrms card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle profile-employee-img"
                                    src="https://adminlte.io/themes/v3//dist/img/user4-128x128.jpg"
                                    alt="Employee profile picture">
                            </div>

                            <h3 class="profile-username text-center">Nina Mcintire Nina Mcintire Nina Mcintire</h3>
                            <p class="text-muted text-center">(Nick Name)</p>
                            <p class="text-muted text-center">Software Engineer</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Status</b> <a class="float-right">Activated</a>
                                </li>

                            </ul>
                            <a href="#" class="btn btn-success btn-block"><b>Core Folder</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-hrms">
                        <div class="card-header">
                            <h3 class="card-title">Emergency Contract</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-users  mr-1"></i> Name here</strong>

                            <p class="mb-1">

                                B.S. in Computer Science from the University of Tennessee at Knoxville
                            </p>
                            <p>
                                B.S. in Computer Science from the University of Tennessee at Knoxville
                            </p>

                            <hr>
                            <strong><i class="fas fa-users  mr-1"></i> Name here</strong>


                            <p class="mb-1">

                                B.S. in Computer Science from the University of Tennessee at Knoxville
                            </p>
                            <p>
                                B.S. in Computer Science from the University of Tennessee at Knoxville
                            </p>

                            <hr>

                            <button @click="addEmergency" class="btn btn-block btn-outline-primary"></button>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-hrms card-outline mb-3">
                                <div class="card-body hrms-profile">

                                    <dl class="row mt-2">
                                        <dt class="col-sm-3"><b>Job Title</b></dt>
                                        <dd class="col-sm-9">A description list is perfect for defining terms.</dd>
                                        <dt class="col-sm-3"><b>Email</b></dt>
                                        <dd class="col-sm-9">A description list is perfect for defining terms.</dd>
                                        <dt class="col-sm-3"><b>Personal Email</b></dt>
                                        <dd class="col-sm-9">A description list is perfect for defining terms.</dd>
                                        <dt class="col-sm-3"><b>Phone Number</b></dt>
                                        <dd class="col-sm-9">A description list is perfect for defining terms.</dd>
                                        <dt class="col-sm-3"><b>Hire Date</b></dt>
                                        <dd class="col-sm-9">A description list is perfect for defining terms.</dd>
                                        <dt class="col-sm-3"><b>Gender</b></dt>
                                        <dd class="col-sm-9">Female</dd>
                                        <dt class="col-sm-3"><b>Country</b></dt>
                                        <dd class="col-sm-9">Female</dd>
                                        <dt class="col-sm-3"><b>Date of Birth</b></dt>
                                        <dd class="col-sm-9">December 33, 2024</dd>
                                        <dt class="col-sm-3"><b>Age</b></dt>
                                        <dd class="col-sm-9">55</dd>
                                        <dt class="col-sm-3"><b>Employee Category</b></dt>
                                        <dd class="col-sm-9">A description list is perfect for defining terms.</dd>
                                        <dt class="col-sm-3"><b>Marital Status</b></dt>
                                        <dd class="col-sm-9">A description list is perfect for defining terms.</dd>
                                        <dt class="col-sm-3"><b>Timezone</b></dt>
                                        <dd class="col-sm-9">A description list is perfect for defining terms.</dd>
                                    </dl>
                                    <button @click="editProfile" class="btn  btn-outline-primary">
                                        Edit Profile
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-hrms card-outline">

                        <div class="card-body hrms-profile">
                            <dl class="row mt-2 ">
                                <dt class="col-sm-3"><b>Department</b></dt>
                                <dd class="col-sm-9">
                                    <ul>
                                        <li>Department 1</li>
                                        <li>Department 2</li>
                                    </ul>
                                </dd>
                                <dt class="col-sm-3"><b>Mancom</b></dt>
                                <dd class="col-sm-9">A description list is perfect for defining terms.</dd>
                                <dt class="col-sm-3"><b>Manager</b></dt>
                                <dd class="col-sm-9">A description list is perfect for defining terms.</dd>
                            </dl>
                            <button @click="editDepartment" class="btn  btn-outline-primary">
                                Edit Department
                            </button>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card card-hrms card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Work History</h3>
                            <div class="card-tools">

                                <button @click="addWorkHistory" class="btn btn-block btn-outline-primary">
                                    Add Work History
                                </button>

                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="timeline timeline-inverse">

                                <div class="time-label">
                                    <span class="bg-danger">
                                        10 Feb. 2014
                                    </span>
                                </div>


                                <div>
                                    <i class="fas fa-envelope bg-primary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 12:05</span>
                                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                                        <div class="timeline-body">
                                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                            quora plaxo ideeli hulu weebly balihoo...
                                        </div>
                                        <div class="timeline-footer">
                                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                        </div>
                                    </div>
                                </div>


                                <div>
                                    <i class="fas fa-user bg-info"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>
                                        <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your
                                            friend request
                                        </h3>
                                    </div>
                                </div>


                                <div>
                                    <i class="fas fa-comments bg-warning"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>
                                        <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post
                                        </h3>
                                        <div class="timeline-body">
                                            Take me to your leader!
                                            Switzerland is small and neutral!
                                            We are more like Germany, ambitious and misunderstood!
                                        </div>
                                        <div class="timeline-footer">
                                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                        </div>
                                    </div>
                                </div>


                                <div class="time-label">
                                    <span class="bg-success">
                                        3 Jan. 2014
                                    </span>
                                </div>


                                <div>
                                    <i class="fas fa-camera bg-purple"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 2 days ago</span>
                                        <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                                        <div class="timeline-body">
                                            <img src="https://placehold.it/150x100" alt="...">
                                            <img src="https://placehold.it/150x100" alt="...">
                                            <img src="https://placehold.it/150x100" alt="...">
                                            <img src="https://placehold.it/150x100" alt="...">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="far fa-clock bg-gray"></i>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <Preloader :loading="loading" />
</template>
<script setup>
import { onMounted, reactive, ref } from 'vue';
import Preloader from "../../components/Preloader.vue";
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();
const pageName = "Employee Information"
const employeeId = parseInt(route.params.id, 10);
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
const addEmergency = () => {
  router.push({name: 'admin-employee-emergency-add', params:employeeId});
};
onMounted(() => {
    // fetchEmployee();
   
});
</script>