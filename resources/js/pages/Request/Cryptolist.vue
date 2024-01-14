<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Crypto History List</div>
                </div>
            </div><br>
            <!-- <span class="loader"></span> -->
            <div class="row">
                <div class="col-md-3 d-none">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control username" placeholder="Username">
                    </div>
                </div>
                <div class="col-md-3 d-none">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control trade_id" placeholder="Trde ID:">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <select class="form-select form-select-solid status">
                            <option value="">All Status</option>
                            <option value="1">Win</option>
                            <option value="2">Loss</option>
                            <option value="0">Review</option>
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
                                <center>
                                    <div v-for="(errorArray, idx) in notifmsg" :key="idx">
                                        <div v-for="(allErrors, idx) in errorArray" :key="idx">
                                            <span class="text-danger">{{ allErrors}} </span>
                                        </div>
                                    </div>
                                </center>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label"><small class="fsize">Name</small>
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control name" id="name">
                                            </div>
                                        </div>
                                        <div class="row  mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label"><small class="fsize">Crypto Wallet Address</small></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control crypto_wallet_address" id="crypto_wallet_address">
                                            </div>
                                        </div>
                                        <div class="row  mb-1">
                                            <label for="exampleInputMobile" class="col-sm-5 col-form-label"><small class="fsize">Status</small></label>
                                            <div class="col-sm-7">
                                                <select name="status" class="form-control" id="status">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <input type="hidden" name="id" class="id" id="id" />
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger closebtn" data-bs-dismiss="modal">Close</button>
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
                                <th>ID</th>
                                <th>Name</th>
                                <th>Wallet Address</th>
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
            notifmsg: '',
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
                    'url': `/api/trade/cryptohistory`,
                    'data': function (data) {
                        let info = $('#datatable').DataTable().page.info();
                        data.page = info.page + 1;
                        var status = $('.status').val();
                        var trade_id = $('.trade_id').val();
                        var username = $('.username').val();
                        data.status = status;
                        data.trade_id = trade_id;
                        data.username = username;
                    },
                },
                'columns': [{
                        data: 'id',
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'crypto_wallet_address',
                    },
                    {
                        data: 'status',
                    },
                    {
                        data: 'actions'
                    }
                ],
            });
            let typesName = "";
            let datatable = this.datatable;
            $('body').on('click', '.edit', function () {
                let id = $(this).attr('data-id');
                $(".id").val(id);
                $(".approved-modal").click();
                axios.post(`/api/trade/checkCryprtoRow?id=${id}`).then((res) => {
                    console.log(res.data.data.trade_percent);
                    $(".id").val(res.data.data.id)
                    $(".name").val(res.data.data.name)
                    $(".crypto_wallet_address").val(res.data.data.crypto_wallet_address)
                    $("#status").val(res.data.data.status);
                    //this.cdata.statusudpate=res.data.data.status;
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
            formData.append('name', $("#name").val());
            formData.append('crypto_wallet_address', $("#crypto_wallet_address").val());
            formData.append('id', $(".id").val());
            formData.append('status', $("#status").val());
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/trade/updateCrypto',
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
                $('.closebtn').click();
                return false;
            }).catch(e => {
                this.notifmsg = e.response.data
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
