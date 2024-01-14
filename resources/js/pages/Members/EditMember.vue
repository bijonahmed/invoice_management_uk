<template>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <Nav />
            <div class="page-content">
                <div class="alert-primary" role="alert">
                    <div class="row">
                        <div class="col-md-10">Edit</div>
                        <div class="col-md-2">
                            <router-link to="/member/member-list"><span stye="text-align:center;">Back</span></router-link>
                        </div>
                    </div>
                </div><br>
                <div class="alert alert-primary" role="alert">

                    <center>
                        Register IP: {{ user.register_ip }}<br>
                        IP Information:<br>{{ user.ip_tracking }}
                </center>
</div>

                <br>
                <div class="row">
                    <div class="col-md-9 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
    
                                <div v-for="(errorArray, idx) in editnotifmsg" :key="idx">
                                    <div v-for="(allErrors, idx) in errorArray" :key="idx">
                                        <span class="text-danger">{{ allErrors}} </span>
                                    </div>
                                </div>
                                <form @submit.prevent="updateprofile()" id="formrest" class="forms-sample" enctype="multipart/form-data">
    
                                    <div class="row mb-3">
                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Role</label>
                                        <div class="col-sm-9">
                                            <select class='form-control form-select' id="role_id" v-model="user.role_id">
                                                <option v-for='data in routelist' :value='data.role_id'>{{ data.name }}</option>
                                            </select>
                                        </div>
                                    </div>
    
                                    <div class="row mb-3">
                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" v-model="user.name" id="name" placeholder="Name">
                                        </div>
                                    </div>
    
                                    <div class="row mb-3">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Phone</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control phone" name="contact" v-model="user.contact" placeholder="Phone number" @change="checkPhone">
                                            <span class="phone_msg" style="color: red;"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control email" name="email" v-model="user.email" placeholder="Email" @change="checkEmail">
                                            <span class="email_msg" style="color: red;"></span>
                                        </div>
                                    </div>
    
                                    <div class="row mb-3">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">File</label>
                                        <div class="col-sm-9">
    
                                            <input type="file" ref="file" @change="onFileSelected" class="form-control" id="file" name="file" />
                                        </div>
                                    </div>
    
                                    <div class="row mb-3">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <select name="status" v-model="user.status" class="form-select" required>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
    
                                    <button type="submit" class="btn btn-primary me-2 w-100 submit_btn">Submit</button>
                                </form>
    
                                <hr>
                                <center>Change Password</center>
                                <div v-for="(errorArray, idx) in editPassnotifmsg" :key="idx">
                                    <div v-for="(allErrors, idx) in errorArray" :key="idx">
                                        <span class="text-danger">{{ allErrors}} </span>
                                    </div>
                                </div>
                                <form @submit.prevent="changesPassword()" id="userSubmitFrm" class="forms-sample" enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Old
                                            Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="currentpassword" v-model="cpassword.currentpassword" autocomplete="off" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="password" v-model="cpassword.password" autocomplete="off" placeholder="New Password">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Confirm New
                                            Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="password_confirmation" v-model="cpassword.password_confirmation" placeholder="Confirm New Password">
                                        </div>
                                    </div>
                                    <center><span id="showerror" stye="color: red; font-size: 15px;"></span></center>
                                    <button type="submit" class="btn btn-primary me-2 w-100">Submit</button>
                                </form>
    
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 grid-margin stretch-card">
                        <div v-if="user.empImg === null">
                            <img :src="`/backend/assets/images/blank_profile.png`" style="height:150px; width: 200px;" alt="image" />
                        </div>
                        <div v-else>
                            <img :src="user.empImg" style="height:150px; width: 200px;" />
                        </div>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    </div>
    </template>
    
    <script>
    export default {
    
        data() {
            return {
                user: {
                    name: '',
                    email: '',
                    contact: '',
                    role_id: '',
                    status: '',
                    register_ip: '',
                    ip_tracking: '',
                    user_id: this.$route.params.id,
                    file: '',
                    empImg: ''
                },
    
                editnotifmsg: '',
                editPassnotifmsg: '',
                cpassword: {
                    currentpassword: '',
                    password: '',
                    password_confirmation: ''
                },
    
                countrylist: [],
                routelist: [],
            }
        },
    
        created() {
            this.getrulelist();
            this.getCountryList();
            this.findRowId();
        },
    
        methods: {
            getrulelist() {
                axios.get('/api/user/getRoleList').then(response => {
                    this.routelist = response.data.data;
                });
            },
    
            onFileSelected() {
                this.file = this.$refs.file.files[0];
            },
            updateprofile() {
                const formData = new FormData();
                formData.append('file', this.file);
                formData.append('name', this.user.name);
                formData.append('email', this.user.email);
                formData.append('contact', this.user.contact);
                formData.append('status', this.user.status);
                formData.append('user_id', this.user.user_id);
                formData.append('role_id', this.user.role_id);
                const headers = {
                    'Content-Type': 'multipart/form-data'
                };
                axios.post('/api/user/updateUser',
                    formData, {
                        headers
                    }).then((res) => {
                    this.loadImage(res.data.imagelink);
                    $('#formrest')[0].reset();
    
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data has been saved!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.$router.push('/member/member-list');
                    // return false;
                }).catch(e => {
                    this.editPassnotifmsg = e.response.data
                });
            },
            changesPassword() {
                const formData = new FormData();
                formData.append('currentpassword', this.cpassword.currentpassword);
                formData.append('password', this.cpassword.password);
                formData.append('password_confirmation', this.cpassword.password_confirmation);
                const headers = {
                    'Content-Type': 'multipart/form-data'
                };
                axios.post('/api/user/updatePassword',
                    formData, {
                        headers
                    }).then((res) => {
                    //console.log(res);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been update',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    return false;
                }).catch(e => {
                    this.editPassnotifmsg = e.response.data
                });
            },
            findRowId() {
                this.axios
                    .get(`/api/user/editUserId/${this.$route.params.id}`)
                    .then((response) => {
    
                        //$("#role_id").val(response.data.data.role_id);
                        console.log("role ID: " + response.data.data.role_id);
                        this.user.name = response.data.data.name;
                        this.user.email = response.data.data.email;
                        this.user.contact = response.data.data.contact;
                        this.user.emergency = response.data.data.emergency;
                        this.user.role_id = response.data.data.role_id;
                        this.user.description = response.data.data.description;
                        this.user.empImg = response.data.data.image;
                        this.user.status = response.data.data.status;
                        this.user.register_ip = response.data.data.register_ip;
                        this.user.ip_tracking = response.data.data.ip_tracking;

                        
                        this.editcompanyCheck(this.user.role_id);
                    });
    
            },
            loadImage(imagelink) {
                this.user.empImg = imagelink;
            },
            getCountryList() {
                axios.get('/api/user/getcountryList').then(response => {
                    this.countrylist = response.data.data;
                });
            },
            checkEmail() {
                let email = $(".email").val();
                axios.post(`/api/checkEmail?email=${email}`).then((res) => {
                    // console.log(res.data.status);
                    if (res.data.status == 1) {
                        $(".submit_btn").hide();
                        $(".email_msg").html("This email is already registered");
                    } else {
                        $(".submit_btn").show();
                        $(".email_msg").html("");
                    }
                });
            },
            checkPhone() {
                let phone = $(".phone").val();
                axios.post(`/api/user/checkPhone?phone=${phone}`).then((res) => {
    
                    if (res.data.status == 1) {
                        $(".submit_btn").hide();
                        $(".phone_msg").html("This phone number is already registered");
                    } else {
                        $(".submit_btn").show();
                        $(".phone_msg").html("");
                    }
                });
    
            },
            companyCheck() {
                let role_id = this.user.role_id;
                if (role_id == 5) {
                    $(".companyname").show();
                } else {
                    $(".companyname").hide();
                }
    
            },
            editcompanyCheck(id) {
                let role_id = id;
                if (role_id == 5) {
                    $(".companyname").show();
                } else {
                    $(".companyname").hide();
                }
            },
        }
    }
    </script>
    