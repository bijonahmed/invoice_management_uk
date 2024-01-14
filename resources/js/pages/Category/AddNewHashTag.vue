<template>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <Nav />
            <div class="page-content">
                <div class="alert-primary" role="alert">
                    New Hash Tag
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form @submit.prevent="saveData()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
    
                                            <input type="text" class="form-control has_tag_name" v-model="cdata.has_tag_name" id="has_tag_name" placeholder="Name" @keyup="checkName">
                                            <span class="v-has_tag_name" style="color:red"></span>
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
                    has_tag_id: '',
                    has_tag_name: '',
                    status: 1,
                },
            }
        },
        created() {},
        methods: {
            saveData() {
                const formData = new FormData();
                formData.append('has_tag_id', this.cdata.has_tag_id);
                formData.append('has_tag_name', this.cdata.has_tag_name);
                formData.append('status', this.cdata.status);
                const headers = {
                    'Content-Type': 'multipart/form-data'
                };
                axios.post('/api/category/saveHashTag',
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
                    this.$router.push('/category/hash-tag-list');
                    // return false;
                }).catch((error) => {
                    $(".v-has_tag_name").html(error.response.data.errors.has_tag_name[0]);
    
                });
            },
            checkName() {
                let has_tag_name = $(".has_tag_name").val();
                axios.post(`/api/category/checkCateName?has_tag_name=${has_tag_name}`).then((res) => {
                   console.log(res.data.status);
                    if (res.data.status == 1) {
                        $(".submit_btn").hide();
                        $(".v-has_tag_name").html("This hashtag name is already exits");
                    } else {
                        $(".submit_btn").show();
                        $(".v-has_tag_name").html("");
                    }
                });
            }
        },
    }
    </script>
    