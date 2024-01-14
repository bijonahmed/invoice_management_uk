<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Edit Category</div>
                    <div class="col-md-2">
                        <router-link to="/category/category-list"><span stye="text-align:center;">Back</span></router-link>
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
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" class="form-control" v-model="cdata.category_id" id="category_id" placeholder="Name">
                                        <input type="text" class="form-control category_name" v-model="cdata.category_name" id="category_name" placeholder="Name"  @keyup="checkName">
                                        <span class="v-category_name" style="color:red"></span>
                                    </div>
                                </div> 

                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select name="status" v-model="cdata.status" class="form-select" required>
                                            <option value="1">Active</option>
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
                category_id: '',
                category_name: '',
                status: '',
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
            formData.append('category_id', this.cdata.category_id);
            formData.append('category_name', this.cdata.category_name);
            formData.append('type', this.cdata.type);
            formData.append('status', this.cdata.status);
            formData.append('order_id', this.cdata.order_id);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/category/saveCategory',
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
                this.$router.push('/category/category-list');
                // return false;
            }).catch(e => {
                this.notifmsg = e.response.data
            });
        },
        findRowId() {
            this.axios
                .get(`/api/category/editCategoryId/${this.$route.params.id}`)
                .then((response) => {
                    this.cdata.category_id = response.data.data.category_id;
                    this.cdata.category_name = response.data.data.category_name;
                    this.cdata.status = response.data.data.status;
                    this.cdata.type = response.data.data.type;
                    this.cdata.order_id = response.data.data.order_id;
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
       
    }
}
</script>
