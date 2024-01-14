<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Invoice List Travel</div>
                    <div class="col-md-2"><a href="javascript:void(0)" @click="addNew"><span stye="text-align:center;">Add
                                New</span></a></div>
                </div>
            </div><br>
            <!-- <span class="loader"></span> -->
            <div class="row">

                <div class="col-md-3">
                    <input type="text" class="form-control inv_id" placeholder="Invoice ID" />
                </div>

                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <select class="form-select customer_id">
                            <option value="">All Customer</option>
                            <option v-for='data in customers' :value='data.customer_id'>{{data.name}}</option>
                        </select>

                    </div>
                </div>

                <div class="col-md-2">
                    <div class="input-group mb-3">
                        <select class="form-select form-select-solid payment_type">
                            <option value="">All</option>
                            <option value="1">Bank Transfer</option>
                            <option value="2">Card Payment</option>
                            <option value="3">Cash</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="input-group mb-3">
                        <select class="form-select form-select-solid status">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
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
                            <input type="hidden" class="invoice_id" v-model="invoice_id" />
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
                    <input type="hidden" class="invoice_id" v-model="invoice_id" />
                    <button class="btn btn-primary w-100 print-inv" @click="printMode" style="display: none;">Edit Mode</button>
                              <button class="btn btn-primary w-100 edit-mode" @click="edit" style="display: none;">Edit Mode</button>
                    <table id="datatable" class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <th>Customer</th>
                                <th>Net Amount</th>
                                <th>Profit</th>
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
            invoice_id: '',
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
                    'url': `/api/category/getInvoiceslist`,
                    'data': function (data) {
                        let info = $('#datatable').DataTable().page.info();
                        data.page = info.page + 1;
                        var status = $('.status').val();
                        var inv_id = $('.inv_id').val();
                        var payment_type = $('.payment_type').val();
                        var customer_id = $('.customer_id').val();
                        //Append Data
                        data.status = status;
                        data.payment_type = payment_type;
                        data.customer_id = customer_id;
                        data.inv_id = inv_id;

                    },
                },
                'columns': [{
                        data: 'inv_id'
                    },
                    {
                        data: 'name'
                    }, {
                        data: 'net_amount'
                    }, {
                        data: 'profit'
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
            $('body').on('click', '.print', function () {
                let id = $(this).attr('data-id');
                $(".invoice_id").val(id);
                $(".print-inv").click();
            });

            $('body').on('click', '.edit', function () {
                let id = $(this).attr('data-id');
                $(".invoice_id").val(id);
                $(".edit-mode").click();
            });


            $('body').on('click', '.del', function () {
                let id = $(this).attr('data-id');
                $(".invoice_id").val(id);
                $("#staticBackdropLabel").html("DELETE ID :" + id);
                $(".edit-modal").click();
            });

            $('.status').change(function () {
                datatable.draw();
            });

            $('.inv_id').keyup(function () {
                datatable.draw();
            });

            $('.type').change(function () {
                datatable.draw();
            });

        },

        printMode() {
            let id = $(".invoice_id").val();
            this.$router.push({
                name: "print-preview-invoice",
                params: {
                    id: id
                }
            })
        },


        edit() {
            let id = $(".invoice_id").val();
            this.$router.push({
                name: "edit-travel-invoice",
                params: {
                    id: id
                }
            })
        },


        
        deleteRow() {
            let id = $(".invoice_id").val();
            axios.post(`/api/category/removeCategory?id=${id}`).then((res) => {
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
            this.$router.push('/invoice/addnewinvoice');
        },
        allCustomers() {
            axios.get('/api/category/allCustomerslist').then(response => {
                this.customers = response.data.data;
            })

        }

    }
};
</script>
