<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Sub Category</div>
                    <div class="col-md-2">
                        <router-link to="/category/subcategory-list"><span stye="text-align:center;">Back</span></router-link>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="saveData()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Category
                                        Name</label>
                                    <div class="col-sm-9">

                                        <select name="country_id" v-model="cdata.category_id" class="form-select">
                                            <option value="">Select</option>
                                            <option v-for='data in ctegorylist' :value='data.category_id'>{{data.category_name}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Sub Category
                                        Name</label>
                                    <div class="col-sm-9">

                                        <input type="text" class="form-control sub_category_name" v-model="cdata.sub_category_name" id="sub_category_name" name="sub_category_name" placeholder="Name" @keyup="checkName">
                                        <span class="v-sub_category_name" style="color:red"></span>
                                        <input type="hidden" v-model="cdata.sub_cate_id" name="sub_cate_id">
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
                category_id: "",
                sub_cate_id: '',
                sub_category_name: '',
                status: 1,
            },
            ctegorylist: [],
        }
    },
    created() {

        this.getCategoryList();

    },
    methods: {
        saveData() {
            const formData = new FormData();
            formData.append('category_id', this.cdata.category_id);
            formData.append('sub_cate_id', this.cdata.sub_cate_id);
            formData.append('sub_category_name', this.cdata.sub_category_name);
            formData.append('status', this.cdata.status);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/category/saveSubCategory',
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
                this.$router.push('/category/subcategory-list');
                // return false;
            }).catch((error) => {
                $(".v-sub_category_name").html(error.response.data.errors.sub_category_name[0]);

            });
        },
        checkName() {
            let sub_category_name = $(".sub_category_name").val();
            axios.post(`/api/category/checkSubCateName?sub_category_name=${sub_category_name}`).then((res) => {
                console.log(res.data.status);
                if (res.data.status == 1) {
                    $(".submit_btn").hide();
                    $(".v-sub_category_name").html("This category name is already exits");
                } else {
                    $(".submit_btn").show();
                    $(".v-sub_category_name").html("");
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
    },
}
</script>
