<template>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <Nav />
            <div class="page-content">
                <div class="alert-primary" role="alert">
                    <div class="row">
                        <div class="col-md-10">Sub Category List</div>
                        <div class="col-md-2"><a href="javascript:void(0)" @click="addNew"><span stye="text-align:center;">Add
                                    New</span></a></div>
                    </div>
                </div><br>
                <!-- <span class="loader"></span> -->
                <div class="row">
    
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control category" placeholder="Sub Category Name">
                        </div>
                    </div>
    
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <select class="form-select form-select-solid status">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
    
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <button class="btn btn-primary w-100" @click="SearchData">Search</button>
                        </div>
                    </div>
    
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <button class="btn btn-primary w-100" @click="addNew">Add New</button>
                        </div>
                    </div>
    
                </div>
    
                <!-- START DELETE MODAL -->
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary edit-modal" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="display:none">
                    DEL
                </button>
                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">DELETE</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <center style="color: red; font-size: 15px; font-weight: bold;">Do you want to delete this category?</center>
                                <input type="hidden" class="sub_cate_id" v-model="sub_cate_id" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger" @click="deleteRow">DELETE</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END DELETE MODAL -->
                <div class="col-md-12">
                    <div class="table-responsive w-100">
                        <input type="hidden" class="sub_cate_id" v-model="sub_cate_id" />
                        <button class="btn btn-primary w-100 edit-mode" @click="editMMode" style="display: none;">Edit Mode</button>
                        <table id="datatable" class="table table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Sub Category Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </template>
    
    <script>
    import $ from "jquery";
    // import Nav from '../../components/Nav.vue';
    // import Sidebar from '../../components/Sidebar.vue';
    import Datepicker from '../../components/Datepicker.vue';
    import "datatables.net-dt/js/dataTables.dataTables";
    import "datatables.net-dt/css/jquery.dataTables.min.css";
    import datepickerFactory from 'jquery-datepicker';
    import {
        useRouter
    } from "vue-router"
    import {
        useStore
    } from 'vuex'
    datepickerFactory($);
    export default {
        setup() {
            const router = useRouter()
        },
        components: {
         //   Nav,
         //   Sidebar,
            Datepicker
        },
        data: function () {
    
            return {
                users: [],
                sub_cate_id: '',
                datatable: {},
    
            };
        },
        mounted() {
            this.defaultLoadingData();
        },
        methods: {
            defaultLoadingData() {
                this.datatable = $('#datatable').DataTable({
                    'processing': true,
                    'serverSide': true,
                    //  'destroy': true,
                    'retrieve': true,
                    'serverMethod': 'GET',
                    'searching': false,
                    'ajax': {
                        'url': `/api/category/getSubCategoryData`,
                        'data': function (data) {
                            let info = $('#datatable').DataTable().page.info();
                            data.page = info.page + 1;
                            var status = $('.status').val();
                            var category = $('.category').val();
    
                            //Append Data
                            data.status = status;
                            data.category = category;
    
                        },
                    },
                    'columns': [{
                            data: 'category_name'
                        },
                        {
                            data: 'sub_category_name'
                        },
                        {
                            data: 'status'
                        }, {
                            data: 'actions',
                        }
                    ],
                });
                let datatable = this.datatable;
                $('body').on('click', '.edit', function () {
                    let id = $(this).attr('data-id');
                    $(".sub_cate_id").val(id);
                    $(".edit-mode").click();
                });
                $('body').on('click', '.del', function () {
                    let id = $(this).attr('data-id');
                    $(".sub_cate_id").val(id);
                    $("#staticBackdropLabel").html("DELETE ID :" + id);
                    $(".edit-modal").click();
                });
    
                $('.status').change(function () {
                    datatable.draw();
                });
    
                $('.category').keyup(function () {
                    datatable.draw();
                });
    
            },
    
            editMMode() {
                let ids = $(".sub_cate_id").val();
                this.$router.push({
                    name: "edit-sub-category",
                    params: {
                        id: ids
                    }
                })
            },
            deleteRow() {
                let id = $(".sub_cate_id").val();
                axios.post(`/api/category/removeSubCategory?id=${id}`).then((res) => {
                    $('.btn-close').click();
                    this.datatable.draw();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Successfully delete record',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    return false;
                });
            },
            SearchData() {
                this.datatable.draw();
            },
            addNew() {
                this.$router.push('/category/add-new-sub-category');
            }
    
        }
    };
    </script>
    