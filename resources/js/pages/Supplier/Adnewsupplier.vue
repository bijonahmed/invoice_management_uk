<template>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <Nav />
            <div class="page-content">
    
                <div class="alert-primary" role="alert">
                    <div class="row">
                        <div class="col-md-10">Customer</div>
                        <div class="col-md-2">
                            <router-link to="/supplier/supplier-list"><span stye="text-align:center;">Back</span></router-link>
                        </div>
                    </div>
                </div><br>
    
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <center><div v-for="(errorArray, idx) in notifmsg" :key="idx">
                                <div v-for="(allErrors, idx) in errorArray" :key="idx">
                                    <span class="text-danger">{{ allErrors}} </span>
                                </div>
                            </div></center>
                            <div class="card-body">
                                <form @submit.prevent="saveData()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Supplier Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control name" v-model="cdata.name" id="name" placeholder="">
                                        </div>
                                    </div>
    
                                    <div class="row mb-3">
                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Type</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control type" v-model="cdata.type" id="type" placeholder="">
                                        </div>
                                    </div>
     
    
                                    <div class="row mb-3">
                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Service</label>
                                        <div class="col-sm-9">
                                            <select name="service" v-model="cdata.service" class="form-select">
                                                <option value="1" selected>Travel</option>
                                                <option value="2">Money Transfer</option>
                                                <option value="3">Others</option>
                                            </select>
                                        </div>
                                    </div>
    
                                    
    
                                    <div class="row mb-3">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <select name="status" v-model="cdata.status" class="form-select">
                                                <option value="1" selected>Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
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
    export default {
        components: {
            // Nav,
            // Sidebar
        },
        data() {
            return {
                cdata: {
                    sulipper_id: '',
                    name: '',
                    service:'',
                    type: '',
                    status: 1,
                },
                notifmsg: '',
            }
        },
        created() {},
        methods: {
            saveData() {
                const formData = new FormData();
                formData.append('sulipper_id', this.cdata.sulipper_id);
                formData.append('name', this.cdata.name);
                formData.append('type', this.cdata.type);
                formData.append('service', this.cdata.service);
                formData.append('status', this.cdata.status);
                const headers = {
                    'Content-Type': 'multipart/form-data'
                };
                axios.post('/api/category/saveSupplier',
                    formData, {
                        headers
                    }).then((res) => {
                    $('#formrest')[0].reset();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data has been saved!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.$router.push('/supplier/supplier-list');
                    // return false;
                    // return false;
                }).catch(e => {
                    this.notifmsg = e.response.data
                });
            },
            checkName() {
                let category_name = $(".category_name").val();
                axios.post(`/api/category/checkCateName?category_name=${category_name}`).then((res) => {
                    console.log(res.data.status);
                    if (res.data.status == 1) {
                        $(".submit_btn").hide();
                        $(".v-category_name").html("This category name is already exits");
                    } else {
                        $(".submit_btn").show();
                        $(".v-category_name").html("");
                    }
                });
            }
        },
    }
    </script>
    