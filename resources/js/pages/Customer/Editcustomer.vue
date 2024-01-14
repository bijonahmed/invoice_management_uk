<template>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <Nav />
            <div class="page-content">
                <div class="alert-primary" role="alert">
                    <div class="row">
                        <div class="col-md-10">Edit Customer</div>
                        <div class="col-md-2">
                            <router-link to="/customer/customer-list"><span stye="text-align:center;">Back</span></router-link>
                        </div>
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
                            <form @submit.prevent="saveData()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Customer Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control name" v-model="cdata.name" id="name" placeholder="">
                                              <input type="hidden" class="form-control customer_id" v-model="cdata.customer_id" id="customer_id" name="customer_id">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Phone Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control phone" v-model="cdata.phone" id="phone" placeholder="">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Addres</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control addres" v-model="cdata.addres" id="addres" placeholder="">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Type</label>
                                    <div class="col-sm-9">
                                        <select name="status" v-model="cdata.type" class="form-select">
                                            <option value="1" selected>Trave</option>
                                            <option value="2">Money Transfer</option>
                                            <option value="3">Others</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Destination</label>
                                    <div class="col-sm-9">
                                        <select name="destination" v-model="cdata.destination" class="form-select">
                                            <option value="">Select</option>
                                            <option>London Stansted</option>
                                            <option>Manchester</option>
                                            <option>London City</option>
                                            <option>Heathrow</option>
                                            <option>Gateway </option>

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
    // import Nav from '../../components/Nav.vue';
    // import Sidebar from '../../components/Sidebar.vue';
    export default {
        components: {
            // Nav,
            // Sidebar
        },
        data() {
            return {
                cdata: {
                customer_id: '',
                name: '',
                phone: '',
                addres: '',
                type: 1,
                destination: '',
                status: 1,
            },
            notifmsg: '',
            }
        },
        created() {
            this.findRowId();
        },
        methods: {
            saveData() {
            const formData = new FormData();
            formData.append('customer_id', this.cdata.customer_id);
            formData.append('name', this.cdata.name);
            formData.append('phone', this.cdata.phone);
            formData.append('addres', this.cdata.addres);
            formData.append('type', this.cdata.type);
            formData.append('destination', this.cdata.destination);
            formData.append('status', this.cdata.status);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/category/saveCustomer',
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
                this.$router.push('/customer/customer-list');
                // return false;
                // return false;
            }).catch(e => {
                this.notifmsg = e.response.data
            });
        },
            findRowId() {
                this.axios
                    .get(`/api/category/editCustomerId/${this.$route.params.id}`)
                    .then((response) => {
                        this.cdata.customer_id = response.data.data.customer_id;
                        this.cdata.name = response.data.data.name;
                        this.cdata.addres = response.data.data.addres;
                        this.cdata.destination = response.data.data.destination;
                        this.cdata.phone = response.data.data.phone;
                        this.cdata.status = response.data.data.status;
                    });
            },
             
             
           
        }
    }
    </script>
    