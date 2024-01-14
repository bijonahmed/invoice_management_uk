<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Deposit List</div>

                </div>
            </div><br>
            <!-- <span class="loader"></span> -->
            <div class="row">

                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control username" placeholder="Username">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <select class="form-select form-select-solid status">
                            <option value="">All Status</option>
                            <option value="0">Pending</option>
                            <option value="1">Approved</option>
                            <option value="2">Cancel</option>
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
                Cancel 
            </button>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Cancel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <center style="color: red; font-size: 15px; font-weight: bold;">Do you want to cancel this request?</center>
                            <input type="hidden" class="id" v-model="id" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" @click="cancelRow">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END DELETE MODAL -->


            <button type="button" class="btn btn-primary approved-modal" data-bs-toggle="modal" data-bs-target="#staticBackdropApproved" style="display:none">
                Approved 
            </button>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdropApproved" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropApproved" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Approved</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <center style="color: red; font-size: 15px; font-weight: bold;">Do you want to approved this request?</center>
                            <input type="hidden" class="id" v-model="id" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" @click="apporvedRow">Approved</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="table-responsive w-100">
                 
                    <table id="datatable" class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Deposit ID</th>
                                <th>User</th>
                                <th>Method</th>
                                <th>Details</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date Time</th>
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
        // Nav,
        // Sidebar,
        Datepicker
    },
    data: function () {

        return {
            users: [],
            id: '',
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
                    'url': `/api/deposit/getDepositList`,
                    'data': function (data) {
                        let info = $('#datatable').DataTable().page.info();
                        data.page = info.page + 1;
                        var status = $('.status').val();
                        var username = $('.username').val();
                        var type = $('.type').val();

                        //Append Data
                        data.status = status;
                        data.username = username;
                        data.type = type;

                    },
                },
                'columns': [{
                        data: 'id'
                        },{
                        data: 'username'
                    },
                    {
                        data: 'payment_method'
                    },
                    {

                        data: 'details',
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'actions',
                    }
                ],
            });
            let datatable = this.datatable;
            $('body').on('click', '.edit', function () {
                let id = $(this).attr('data-id');
                $(".id").val(id);
                $(".approved-modal").click();
                //approved-modal
            });
            $('body').on('click', '.del', function () {
                let id = $(this).attr('data-id');
                $(".id").val(id);
                $("#staticBackdropLabel").html("ID :" + id);
                $(".edit-modal").click();
            });

            $('.status').change(function () {
                datatable.draw();
            });

            $('.category').keyup(function () {
                datatable.draw();
            });

            $('.type').change(function () {
                datatable.draw();
            });

        },

        editMMode() {
            let ids = $(".id").val();
            this.$router.push({
                name: "edit-category",
                params: {
                    id: ids
                }
            })
        },
        cancelRow() {
            let id = $(".id").val();
            axios.post(`/api/deposit/cancelDeposit?id=${id}`).then((res) => {
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
        apporvedRow() {
            let id = $(".id").val();
            axios.post(`/api/deposit/approvedDeposit?id=${id}`).then((res) => {
                $('.btn-close').click();
                this.datatable.draw();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Successfully approved request',
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
            this.$router.push('/category/add-new-category');
        }

    }
};
</script>
