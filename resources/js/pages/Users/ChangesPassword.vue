<template>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <Nav />
            <div class="page-content">
                <div class="alert-primary" role="alert">
                     Change Password
                    </div>
                    <br>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div v-for="(errorArray, idx) in notifmsg" :key="idx">
                                <div v-for="(allErrors, idx) in errorArray" :key="idx">
                                    <span class="text-danger">{{ allErrors}} </span>
                                </div>
                            </div>
                                <center><span id="showerror" stye="color: red; font-size: 15px;"></span></center>
                                <form @submit.prevent="updateprofile()" id="userSubmitFrm" class="forms-sample"
                                    enctype="multipart/form-data">

                                    <!-- <div class="row mb-3">
                                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Old
                                            Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="currentpassword"
                                                v-model="user.currentpassword" autocomplete="off"
                                                placeholder="Password">
                                        </div>
                                    </div> -->
                                    <div class="row mb-3">
                                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="password"
                                                v-model="user.password" autocomplete="off" placeholder="New Password">
                                        </div>
                                    </div>
                                   <div class="row mb-3">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Confirm New
                                            Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="password_confirmation"
                                                 v-model="user.password_confirmation"
                                                placeholder="Confirm New Password">
                                        </div>
                                    </div>  

                                    <button type="submit" class="btn btn-primary me-2 w-100">Submit</button>
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
            notifmsg: '',
            authUser: window.authUser,
            user: {
                currentpassword: '',
                password: '',
                password_confirmation: ''
            },

        }
    },
    methods: {
        updateprofile() {
            const formData = new FormData();
           // formData.append('currentpassword', this.user.currentpassword);
            formData.append('password', this.user.password);
            formData.append('password_confirmation', this.user.password_confirmation);
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
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                })
                return false;
            }).catch(e => {
                this.notifmsg = e.response.data
            });
        },


    },
}
</script>
