<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Add New</div>
                    <div class="col-md-2"><router-link  to="/user-list"><span stye="text-align:center;">Back</span></router-link ></div>
                </div>
            </div><br>
           
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div v-for="(errorArray, idx) in notifmsg" :key="idx">
                                <div v-for="(allErrors, idx) in errorArray" :key="idx">
                                    <span class="text-danger">{{ allErrors}} </span>
                                </div>
                            </div>
                            <form @submit.prevent="insertUser()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Role</label>
                                    <div class="col-sm-9">
                                        <select class='form-control form-select' required @change="companyCheck" v-model="user.role_id">
                                            <option value='0' selected="selected">Select Role</option>
                                            <option v-for='data in routelist' :value='data.role_id'>{{ data.name }}
                                            </option>
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
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="password" v-model="user.password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Photo (Thumbnail )</label>
                                    <div class="col-sm-9">
                                        <input type="file" ref="file" @change="onFileSelected" class="form-control" id="file" name="file" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2 w-100 submit_btn">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</div>
</template>
<script>
import Nav from '../../components/Nav.vue';
import Sidebar from '../../components/Sidebar.vue';
export default {
    components: {
        Nav,
        Sidebar
    },
    data() {
        return {
            authUser: window.authUser,
            user: {
                name: '',
                file: '',
                email: '',
                role_id: 0,
                contact: '',
                status: 1,
                user_id: '',
                password: '',
                address: '',
                empImg: ''
            },
            notifmsg: '',
            countrylist: [],
            routelist: [],
        }
    },
    created() {
        this.getrulelist();
        this.getCountryList();
    },
    methods: {
        onFileSelected() {
            this.file = this.$refs.file.files[0];
        },
        insertUser() {
            const formData = new FormData();
            formData.append('file', this.file);
            formData.append('name', this.user.name);
            formData.append('email', this.user.email);
            formData.append('contact', this.user.contact);
            formData.append('address', this.user.address);
            formData.append('status', this.user.status);
            formData.append('user_id', this.user.user_id);
            formData.append('password', this.user.password);
            formData.append('role_id', this.user.role_id);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/user/addUser',
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
                this.$router.push('/user-list');
                // return false;
            }).catch(e => {
                this.notifmsg = e.response.data
            });
        },
        getrulelist() {
            axios.get('/api/user/getRoleList').then(response => {
                this.routelist = response.data.data;
            });
        },
        getCountryList() {
            axios.get('/api/user/getcountryList').then(response => {
                this.countrylist = response.data.data;
                console.log(this.countrylist);
            });
        },
        companyCheck() {
            let role_id = this.user.role_id;
            if (role_id == 5) {
                $(".companyname").show();
            } else {
                $(".companyname").hide();
            }
            console.log(role_id);
        },
        loadImage(imagelink) {
            this.user.empImg = imagelink;
        },
        checkEmail() {
            let email = $(".email").val();
            axios.post(`/api/user/checkEmail?email=${email}`).then((res) => {
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
                console.log(res.data.status);
                if (res.data.status == 1) {
                    $(".submit_btn").hide();
                    $(".phone_msg").html("This phone number is already registered");
                } else {
                    $(".submit_btn").show();
                    $(".phone_msg").html("");
                }
            });
        }
    },
}
</script>
