<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Mining List</div>
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
                            <option value="1">Running</option>
                            <option value="2">Complete</option>

                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <button class="btn btn-primary w-100" @click="SearchData">Search</button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary approved-modal" data-bs-toggle="modal" data-bs-target="#staticBackdropApproved" style="display:none">
                Details
            </button>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdropApproved" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropApproved" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form @submit.prevent="saveData()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title" id="staticBackdropLabel"><span sytle="color:white;">Details</span>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label"><small class="fsize">Mining Amount</small>
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control amount" id="amount">
                                            </div>
                                        </div>
                                        <div class="row  mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label"><small class="fsize">Profit %</small></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control profit_percentage" id="profit_percentage">
                                            </div>
                                        </div>
                                        <div class="row  mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label"><small class="fsize">Profit</small></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control profit" id="profit">
                                            </div>
                                        </div>
                                        <div class="row  mb-1">
                                            <label for="exampleInputMobile" class="col-sm-5 col-form-label"><small class="fsize">Status</small></label>
                                            <div class="col-sm-7">
                                                <select name="status" class="form-control status" id="status">
                                                    <option value="1">Runing</option>
                                                    <option value="2">Complete</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" class="id" id="id" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success btn btn-primary me-2 submit_btn" @click="apporvedRow">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive w-100">
                    <table id="datatable" class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Mining ID</th>
                                <th>User</th>
                                <th>Mining Amount</th>
                                <th>Create Time</th>
                                <th>Ending Time</th>
                                <th>Duration</th>
                                <th>Profit %</th>
                                <th>Profit</th>
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
                    'url': `/api/trade/mininghistory`,
                    'data': function (data) {
                        let info = $('#datatable').DataTable().page.info();
                        data.page = info.page + 1;
                        var status = $('.status').val();
                        var username = $('.username').val();
                        data.status = status;
                        data.username = username;
                    },
                },
                'columns': [{
                        data: 'mining_id'
                    },
                    {
                        data: 'username'
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'ending_time'
                    },
                    {
                        data: 'duration'
                    },
                    {
                        data: 'profi_percentage'
                    },
                    {
                        data: 'profit'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'actions',
                    }
                ],
            });
            let typesName = "";
            let datatable = this.datatable;
            $('body').on('click', '.edit', function () {
                let id = $(this).attr('data-id');
                $(".id").val(id);
                $(".approved-modal").click();
                axios.post(`/api/trade/miningRow?id=${id}`).then((res) => {
                    console.log(res.data.data.created_at);
                    //$(".trade_id").html(res.data.data.trade_id)
                    $(".id").html(res.data.data.id)
                    $(".mining_id").html(res.data.data.mining_id)
                    $(".amount").val(res.data.data.amount)
                    $(".diff_hour").html(res.data.data.diff_hour + "Hour")
                    $(".profit_percentage").val(res.data.data.profit_percentage)
                    $(".profit").val(res.data.data.profit)
                    $(".status").val(res.data.data.status)
                });
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
        saveData() {
            const formData = new FormData();
            formData.append('amount', $("#amount").val());
            formData.append('profit_percentage', $("#profit_percentage").val());
            formData.append('profit', $("#profit").val());
            formData.append('id', $(".id").val());
            formData.append('status', $("#status").val());
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/trade/updateMining',
                formData, {
                    headers
                }).then((res) => {
                this.SearchData();
                //formrest
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Has been succesfully saved',
                    showConfirmButton: false,
                    timer: 1500
                })
                // this.$router.push('/post/post-list');
                return false;
            });
        },
        SearchData() {
            this.datatable.draw();
        },
    }
};
</script>

<style>
.style5 {
    font-size: 15px
}

.style6 {
    font-size: 13px
}

.fsize {
    font-size: 12px;
}
</style>
