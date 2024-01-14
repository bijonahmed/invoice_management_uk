<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Add New Bank</div>
                    <div class="col-md-2">
                        <router-link to="/bank/bank-list"><span stye="text-align:center;">Back</span></router-link>
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
                                <div class="row">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border loading" role="status" style="display:none">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row mb-3">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Country</label>
                                            <div class="col-sm-9">
                                                <select name="country_id" v-model="cdata.country_id" class="form-select">
                                                    <option value="">Select a Country...</option>
                                                    <option v-for="(data, id) in countrylist" :key="id" :value="id">{{
                                                        data.name
                                                }}</option>
                                                </select>
                                                <input type="hidden" v-model="cdata.id" name="id">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Bank Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" v-model="cdata.bank_name" id="bank_name" name="bank_name" placeholder="Bank Name">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <select name="status" v-model="cdata.status" class="form-select">
                                                    <option value="1" selected>Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>

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
import $ from "jquery";

export default {
    data() {
        return {
            cdata: {
                id: '',
                country_id: '',
                bank_name: '',
                status: 1,
            },
            notifmsg: '',
            countrylist: [],
        }
    },
    created() {
        this.getCountryList();

    },
    methods: {
        getCountryList() {
            axios.get('/api/user/getcountryList').then(response => {
                this.countrylist = response.data.data;
              
            });
        },

        saveData() {
            const formData = new FormData();
            formData.append('id', this.cdata.id);
            formData.append('country_id', this.cdata.country_id);
            formData.append('bank_name', this.cdata.bank_name);
            formData.append('status', this.cdata.status);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/bank/bankInsert',
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
                this.$router.push('/bank/bank-list');
                // return false;
            }).catch(e => {
                this.notifmsg = e.response.data
            });


 
        },
    },
}
</script>

<style>
#previewImg {
    width: 300px;
    height: 300px;
}
</style>
