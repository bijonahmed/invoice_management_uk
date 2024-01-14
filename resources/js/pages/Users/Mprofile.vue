<template>
    <div class="main-wrapper">
       
        <div class="page-wrapper">
            <Nav />
            <div class="page-content">
                <div class="alert-primary" role="alert">
                     Profile
                    </div>
                    <br>
                <div class="row">
                <div class="col-md-9 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                      
                            <form @submit.prevent="updateprofile()" id="userSubmitFrm" class="forms-sample"
                                enctype="multipart/form-data">

                                <div class="row mb-3">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="user.name" id="name"
                                            placeholder="Name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Company</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="company" v-model="user.company"
                                            autocomplete="off" placeholder="Company">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Phone</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="contact" v-model="user.contact"
                                            placeholder="Phone number">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="email" v-model="user.email"
                                            placeholder="Email">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">File</label>
                                    <div class="col-sm-9">

                                        <input type="file" ref="file" @change="onFileSelected" class="form-control"
                                            id="file" name="file" />
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary me-2 w-100">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 grid-margin stretch-card">
                    <div v-if="user.empImg === null">
                                       <img :src="`/backend/assets/images/blank_profile.png`"
                                       style="height:150px; width: 200px;" alt="image" /> 
                        </div>
                        <div v-else>
                            <img :src="user.empImg" style="height:150px; width: 200px;"/>
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
                company: '',
                country_id: '',
                contact: '',
                address: '',
                empImg: ''
            },
            countrylist: [],
        }
    },
    created() {
        if (authUser !== null) {
            this.user.name = authUser.name;
            this.user.email = authUser.email;
            this.user.company = authUser.company;
            this.user.contact = authUser.contact;
            this.user.country_id = authUser.country;
            this.user.address = authUser.address;
            this.user.empImg = authUser.image;
            //console.log("-------" + authUser.image);
            console.log('Component has been created!');
            this.getCountryList();
        }
    },

    methods: {
        onFileSelected() {
            this.file = this.$refs.file.files[0];
        },
        updateprofile() {
            const formData = new FormData();
            formData.append('file', this.file);
            formData.append('name', this.user.name);
            formData.append('email', this.user.email);
            formData.append('company', this.user.company);
            formData.append('contact', this.user.contact);
            formData.append('country_id', this.user.country_id);
            formData.append('address', this.user.address);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/user/updateprofile',
                formData, {
                headers
            }).then((res) => {
                this.loadImage(res.data.imagelink);
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                })
                return false;
            });
        },
        getCountryList() {
            axios.get('/api/getcountryList').then(response => {
                this.countrylist = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        },
        loadImage(imagelink) {
            this.user.empImg = imagelink;
        }
    },
}
</script>
