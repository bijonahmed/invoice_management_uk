<template>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <Nav />
            <div class="page-content">
                <div class="alert-primary" role="alert">
                    <div class="row">
                        <div class="col-md-10">KYC List</div>
                        <div class="col-md-2"></div>
                    </div>
                </div><br>
                <!-- <span class="loader"></span> -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control username" placeholder="Username">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <select class="form-select form-select-solid status">
                                <option value="">All Status</option>
                                <option value="1">Approved</option>
                                <option value="0">Not Approved</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <button class="btn btn-primary w-100" @click="SearchData">Search</button>
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
                                <h5 class="modal-title" id="staticBackdropLabel">CONFIRM</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <center style="color: red; font-size: 15px; font-weight: bold;">Do you wanto to approved?</center>
                                <input type="hidden" class="user_id" v-model="user_id" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger" @click="deleteUser">Approved</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END DELETE MODAL -->
                <div class="col-md-12">
                    <div class="table-responsive w-100">
                        <input type="hidden" class="user_id" v-model="user_id" />
                        <button class="btn btn-primary w-100 edit-mode" @click="editMMode" style="display: none;">Edit Mode</button>
                        <table id="datatable" class="table table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Country</th>
                                    <th>Personname</th>
                                    <th>ID/Passport</th>
                                    <th>F Pages Img</th>
                                    <th>B Pages Img</th>
                                    <th>Hold Pages </th>
                                    <th>Created At</th>
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
    import Nav from '../../components/Nav.vue';
    import Sidebar from '../../components/Sidebar.vue';
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
            Nav,
            Sidebar,
            Datepicker
        },
        data: function () {
            var date = new Date();
            var day = date.getDate();
            var date_ago = day - 30;
            var month = date.getMonth() + 1;
            var year = date.getFullYear();
            if (month < 10) month = "0" + month;
            if (day < 10) day = "0" + day;
            var t_date = year + "-" + month + "-" + day;
            var dateAgo = year + "-" + month + "-" + date_ago;
            return {
                users: [],
                frm_date: dateAgo,
                to_date: t_date,
                user_id: '',
                datatable: {},
                routelist: [],
    
            };
        },
        mounted() {
            this.defaultLoadingData();
            this.getrulelist();
            $('.frm_date,.to_date').datepicker();
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
                        'url': `/api/member/getKycData`,
                        'data': function (data) {
                            let info = $('#datatable').DataTable().page.info();
                            data.page = info.page + 1;
                            var phone = $('.phone').val();
                            var status = $('.status').val();
                            var email = $('.email').val();
                            var frm_date = $('.frm_date').val();
                            var to_date = $('.to_date').val();
                            var role_id = $('.role_id').val();
                            var username = $('.username').val();
                            //Append Data
                            data.phone = phone;
                            data.status = status;
                            data.email = email;
                            data.frm_date = frm_date;
                            data.to_date = to_date;
                            data.role_id = role_id;
                            data.username = username;
                        },
                    },
                    'columns': [
                      
                        {
                            data: 'id',
                        },
                        {
                            data: 'username',
                        },
                        {
                            data: 'countryname',
                        },
                        {
                            data: 'person_name',
                        },
                        {
                            data: 'id_passport',
                        },
                        {
                            data: 'f_pages_img',
                        },
                        {
                            data: 'b_pages_img',
                        },
                        {
                            data: 'hold_pages_img',
                        },
                        {
                            data: 'created_at',
                        },
                        {
                            data: 'status',
                        }, {
                            data: 'actions'
                        }
                    ],
                });
                let datatable = this.datatable;
                $('body').on('click', '.edit', function () {
                    let id = $(this).attr('data-id');
                    $(".user_id").val(id);
                    $(".edit-mode").click();
                });
                $('body').on('click', '.del', function () {
                    let id = $(this).attr('data-id');
                    $(".user_id").val(id);
                    $("#staticBackdropLabel").html("KYC  ID :" + id);
                    $(".edit-modal").click();
                });
                $('.status').change(function () {
                    datatable.draw();
                });
               
            },
            getrulelist() {
                axios.get('/api/user/getRoleList').then(response => {
                    this.routelist = response.data.data;
                }).catch(error => {
                    //  console.log(error);
                });
            },
            editMMode() {
                let ids = $(".user_id").val();
                this.$router.push({
                    name: "edit-user",
                    params: {
                        id: ids
                    }
                })
            },
            deleteUser() {
                let id = $(".user_id").val();
                axios.post(`/api/member/approvedKyc?id=${id}`).then((res) => {
                    $('.btn-close').click();
                    this.datatable.draw();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Successfully Approvied KYC',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    return false;
                });
            },
            SearchData() {
                this.datatable.draw();
            },
           
    
        }
    };
    </script>
    