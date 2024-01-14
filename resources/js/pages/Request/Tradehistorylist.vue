<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Trade List</div>
                </div>
            </div><br>
            <!-- <span class="loader"></span> -->
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control username" placeholder="Username">
                    </div>
                </div>
                <div class="col-md-3">
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
                                 <center>  <div v-for="(errorArray, idx) in notifmsg" :key="idx">
                                <div v-for="(allErrors, idx) in errorArray" :key="idx">
                                    <span class="text-danger">{{ allErrors}} </span>
                                </div>
                            </div></center>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label"><small class="fsize">Opening Rate</small>
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control fast_price" id="fast_price">
                                            </div>
                                        </div>
                                        <div class="row  mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label"><small class="fsize">Closing Rate</small></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control update_price" id="update_price">
                                            </div>
                                        </div>
                                        <div class="row  mb-1">
                                            <label for="exampleInputMobile" class="col-sm-5 col-form-label"><small class="fsize">Status</small></label>
                                            <div class="col-sm-7">
                                                <select name="status" class="form-control" id="status">
                                                    <option value="1">Win</option>
                                                    <option value="2">Loss</option>
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row  mb-1">
                                            <label for="exampleInputMobile" class="col-sm-5 col-form-label"><small class="fsize">Trade Types</small></label>
                                            <div class="col-sm-7">
                                                <select name="trade_types" class="form-control t_types" id="trade_types">
                                                    <option value="1">Long</option>
                                                    <option value="2">Sort</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" class="id" id="id" />
                                    </div>
                                    <div class="col-md-8">
                                        <table width="100%" border="0" class="table table-sm table-hover">
                                            <tr>
                                                <td width="72%"><small class="fsize style6">ID</small></td>
                                                <td width="28%" class="id fsize style5"></td>
                                            </tr>
                                            <tr>
                                                <td width="72%"><small class="fsize style6">T/A ID</small></td>
                                                <td width="28%" class="trade_id fsize style5"></td>
                                            </tr>
                                            <tr>
                                                <td width="72%"><small class="fsize style5">Date &amp; Time</small></td>
                                                <td width="28%" class="create_at fsize style5"></td>
                                            </tr>
                                            <tr>
                                                <td><small class="fsize style5">Currency</small> </td>
                                                <td class="coin_code fsize style5"></td>
                                            </tr>
                                            <tr>
                                                <td><small class="fsize style5">Duration </small></td>
                                                <td class="close_time fsize style5"></td>
                                            </tr>
                                            <tr>
                                                <td><small class="fsize style5">T/A Amount</small> </td>
                                                <td class="trade_price fsize style5"></td>
                                            </tr>

 <tr>
                                                <td><small class="fsize style5">Trade Profit</small> </td>
                                                <td class="fsize style5">
                                                    <input type="text" name="trade_profit" class="trade_profit"/>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td><small class="fsize style5">T/A Percentage</small> </td>
                                                <td class="fsize style5">
                                                    <input type="text" name="trade_percent" class="trade_percent"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><small class="fsize style5">T/A Fee</small></td>
                                                <td class="fsize style5">
                                                    <input type="text" name="trade_fee" class="trade_fee"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><small class="fsize style5">Future Prediction</small></td>
                                                <td class="trade_types fsize style5"></td>
                                            </tr>
                                            <tr>
                                                <td><small class="fsize style5">Extinmated Profit</small></td>
                                                <td class="fsize style5">
                                                    <input type="text" name="es_profit" class="es_profit"/>


                                                </td>
                                            </tr>
                                        </table>

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
                                <th>Trade ID</th>
                                <th>User</th>
                                <th>Coin Code</th>
                                <th>Create Time</th>
                                <th>API Response Status</th>
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
                    'url': `/api/trade/tradinghistory`,
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
                        data: 'trade_id',
                    },
                    {
                        data: 'username',
                    },
                    {
                        data: 'coin_code',
                    },
                    {
                        data: 'created_at',
                    }, {
                        data: 'api_update_status',
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
                axios.post(`/api/trade/traderow?id=${id}`).then((res) => {

                    console.log(res.data.data.trade_percent);
                    $(".trade_id").html(res.data.data.trade_id)
                    $(".id").html(res.data.data.id)
                    $(".coin_code").html(res.data.data.coin_code)
                    $(".close_time").html(res.data.data.close_time + " sec.")
                    $(".es_profit").val(res.data.data.es_profit)
                    $(".trade_percent").val(res.data.data.trade_percent)
                    $(".trade_fee").val(res.data.data.trade_fee)
                    $(".trade_price").html("$" + res.data.data.trade_price)
                    $(".trade_profit").val(res.data.data.trade_profit)
                    $(".fast_price").val(res.data.data.fast_price)
                    $(".update_price").val(res.data.data.update_price)
                    $(".t_types").val(res.data.data.trade_types)
                    $(".create_at").html(res.data.data.create_at)
                    $("#status").val(res.data.data.status);
                    //this.cdata.statusudpate=res.data.data.status;

                    if (res.data.data.trade_types == 1) {
                        typesName = "Long";
                    }

                    if (res.data.data.trade_types == 2) {
                        typesName = "Sort";
                    }
                    $(".trade_types").html(typesName)

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
            formData.append('fast_price', $("#fast_price").val());
            formData.append('update_price', $("#update_price").val());
            formData.append('trade_types', $("#trade_types").val());

            formData.append('trade_profit', $(".trade_profit").val());
            formData.append('trade_percent', $(".trade_percent").val());
            formData.append('trade_fee', $(".trade_fee").val());
            formData.append('es_profit', $(".es_profit").val());



            formData.append('id', $(".id").val());
            formData.append('status', $("#status").val());
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/trade/updateTrade',
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
