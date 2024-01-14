<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">

            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Add New Due Amount Supplier Wise</div>
                    <div class="col-md-2">
                        <router-link to="/supplier/supplier-due-amt-list"><span stye="text-align:center;">Back</span></router-link>
                    </div>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <center>
                            <div v-for="(errorArray, idx) in notifmsg" :key="idx">
                                <div v-for="(allErrors, idx) in errorArray" :key="idx">
                                    <span class="text-danger">{{ allErrors}} </span>
                                </div>
                            </div>
                        </center>
                        <div class="card-body">
                            <form @submit.prevent="saveData()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Supplier</label>
                                    <div class="col-sm-9">
                                        <select name="sulipper_id" v-model="cdata.sulipper_id" class="form-select sulipper_id" @change="getnetAmounts">
                                            <option value="">Select</option>
                                            <option v-for='data in supplierlist' :value='data.sulipper_id'>{{data.name}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Due Amount</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control dueamt" v-model="cdata.dueamt" id="dueamt" name="dueamt" readonly>
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
                due_id: '',
                sulipper_id: '',
                dueamt:'',
            },
            notifmsg: '',
            supplierlist: [],
        }
    },
    created() {
        this.allSuppliers();

    },
    methods: {
        saveData() {
            const formData = new FormData();
            formData.append('sulipper_id', this.cdata.sulipper_id);
            formData.append('dueamt', this.cdata.dueamt);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/category/saveDueAmt',
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
                this.$router.push('/supplier/supplier-due-amt-list');
                // return false;
                // return false;
            }).catch(e => {
                this.notifmsg = e.response.data
            });
        },
        allSuppliers() {
            axios.get('/api/category/allsuppliders').then(response => {
                this.supplierlist = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        },
        getnetAmounts(){
            let sulipper_id = $(".sulipper_id").val();
            axios.post(`/api/category/chkSupplierAmt?sulipper_id=${sulipper_id}`).then(response => {
                this.cdata.dueamt = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        }
    },
}
</script>
