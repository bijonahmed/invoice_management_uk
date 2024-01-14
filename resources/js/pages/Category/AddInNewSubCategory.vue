<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Add</div>
                    <div class="col-md-2"><router-link to="/category/in-subcategory-list"><span stye="text-align:center;">Back</span></router-link></div>
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
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Category
                                        Name</label>
                                    <div class="col-sm-9">
                                        <select name="country_id" v-model="cdata.category_id" class="form-select category_id" @change="getSubCategory">
                                            <option value="">Select</option>
                                            <option v-for='data in ctegorylist' :value='data.category_id'>{{
                                                        data.category_name
                                                }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Sub Category
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="sub_cate_id" v-model="cdata.sub_cate_id" class="form-select">
                                            <option value="">Select</option>
                                            <option v-for='data in subctegorylist' :value='data.sub_cate_id'>{{
                                                        data.sub_category_name
                                                }}</option>
                                        </select>
                                        <input type="hidden" v-model="cdata.sub_cate_id" name="sub_cate_id">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Account Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control in_sub_category_name" v-model="cdata.in_sub_category_name" id="in_sub_category_name" name="in_sub_category_name" placeholder="Name" @keyup="checkName">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Account Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control account_number" v-model="cdata.account_number" id="account_number" name="account_number" placeholder="Account Number">
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
        
    },
    data() {
        return {
            cdata: {
                category_id: "",
                sub_cate_id: '',
                in_sub_cate_id: '',
                in_sub_category_name: '',
                account_number: '',
                status: 1,
            },
            notifmsg:[],
            ctegorylist: [],
            subctegorylist: [],
        }
    },
    created() {
        this.getCategoryList();
    },
    methods: {
        saveData() {
            const formData = new FormData();
            formData.append('in_sub_cate_id', this.cdata.in_sub_cate_id);
            formData.append('category_id', this.cdata.category_id);
            formData.append('sub_cate_id', this.cdata.sub_cate_id);
            formData.append('in_sub_category_name', this.cdata.in_sub_category_name);
            formData.append('account_number', this.cdata.account_number);
            formData.append('status', this.cdata.status);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/category/inSaveSubCategory',
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
                this.$router.push('/category/in-subcategory-list');
                // return false;
            }).catch(e => {
                this.notifmsg = e.response.data
            });
        },
        checkName() {
            let in_sub_category_name = $(".in_sub_category_name").val();
            axios.post(`/api/category/checkInSubCateName?in_sub_category_name=${in_sub_category_name}`).then((res) => {
                console.log(res.data.status);
                if (res.data.status == 1) {
                    $(".submit_btn").hide();
                    $(".v-in_sub_category_name").html("This category name is already exits");
                } else {
                    $(".submit_btn").show();
                    $(".v-in_sub_category_name").html("");
                }
            });
        },
        getCategoryList() {
            axios.get('/api/category/getCategoryList').then(response => {
                this.ctegorylist = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        },
        getSubCategory() {
            let categoryid = $(".category_id").val();
            axios.post(`/api/category/chkCategoryId?categoryid=${categoryid}`).then(response => {
                this.subctegorylist = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        }
    },
}
</script>
