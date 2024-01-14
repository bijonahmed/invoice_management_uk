<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Invoice List Money Transfer</div>
                    <div class="col-md-2"><a href="javascript:void(0)" @click="addNew"><span stye="text-align:center;">Add
                                New</span></a></div>
                </div>
            </div><br>
            <!-- <span class="loader"></span> -->
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control beneficiary_name" placeholder="Beneficiary Name">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <select class="form-select form-select-solid payment_type">
                            <option value="">All</option>
                            <option value="1">Bkash</option>
                            <option value="2">Bank Transfer</option>
                            <option value="3">Cash</option>
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
                            <h5 class="modal-title" id="staticBackdropLabel">DELETE</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <center style="color: red; font-size: 15px; font-weight: bold;">Do you want to delete this category?</center>
                            <input type="hidden" class="mone_transfer_id" v-model="mone_transfer_id" />
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
                    <input type="hidden" class="mone_transfer_id" v-model="mone_transfer_id" />
                    <button class="btn btn-primary w-100 edit-mode" @click="editMMode" style="display: none;">Edit Mode</button>
                    <button class="btn btn-primary w-100 print-mode" @click="printMode" style="display: none;">Print Mode</button>
                    <table id="datatable" class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Tran.Ref</th>
                                <th>Customer Name</th>
                                <th>Beneficiary Details</th>
                                <!-- <th>Beneficiary Country</th>
                                <th>Beneficiary City</th>
                                <th>Contact</th> -->
                                <!-- <th>Beneficiary Name</th>
                                <th>Beneficiary Country</th>
                                <th>Beneficiary City</th>
                                <th>Contact</th> -->
                                <th>Rate</th>
                                <th>Fees</th>
                                <th>Recv. Amount</th>
                                <th>Payment Type</th>
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
            customers: [],
            mone_transfer_id: '',
            datatable: {},
        };
    },
    mounted() {
        this.defaultLoadingData();
        this.allCustomers();
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
                    'url': `/api/category/getInvoicesmoneylist`,
                    'data': function (data) {
                        let info = $('#datatable').DataTable().page.info();
                        data.page = info.page + 1;
                        var status = $('.status').val();
                        var payment_type = $('.payment_type').val();
                        var beneficiary_name = $('.beneficiary_name').val();
                        //Append Data
                        data.status = status;
                        data.payment_type = payment_type;
                        data.beneficiary_name = beneficiary_name;
                    },
                },
                'columns': [{
                        data: 'transaction_ref'
                    },
                    {
                        data: 'customer_name'
                    }, {
                        data: 'beneficiary_name'
                    },
                    {
                        data: 'rate'
                    },
                    {
                        data: 'fees'
                    },
                    {
                        data: 'receiving_amount'
                    },
                    {
                        data: 'payment_type'
                    },
                    {
                        data: 'actions',
                    }
                ],
            });
            let datatable = this.datatable;
            $('body').on('click', '.edit', function () {
                let id = $(this).attr('data-id');
                $(".mone_transfer_id").val(id);
                $(".edit-mode").click();
            });
            $('body').on('click', '.print', function () {
                let id = $(this).attr('data-id');
                $(".mone_transfer_id").val(id);
                $(".print-mode").click();
            });
            $('body').on('click', '.del', function () {
                let id = $(this).attr('data-id');
                $(".mone_transfer_id").val(id);
                $("#staticBackdropLabel").html("DELETE ID :" + id);
                $(".edit-modal").click();
            });
            $('.status').change(function () {
                datatable.draw();
            });
            $('.beneficiary_name').keyup(function () {
                datatable.draw();
            });
            $('.type').change(function () {
                datatable.draw();
            });
        },
        editMMode() {
            let id = $(".mone_transfer_id").val();
            this.$router.push({
                name: "edit-money-invoice",
                params: {
                    id: id
                }
            })
        },
        printMode() {
            let id = $(".mone_transfer_id").val();
            this.$router.push({
                name: "print-money-invoice",
                params: {
                    id: id
                }
            })
        },
        SearchData() {
            this.datatable.draw();
        },
        addNew() {
            this.$router.push('/invoice/addnewinvoiceMoney');
        },
        allCustomers() {
            axios.get('/api/category/allCustomers').then(response => {
                this.customers = response.data.data;
            })
        }
    }
};
</script>
