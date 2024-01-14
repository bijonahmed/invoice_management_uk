<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert" style="margin-bottom:10px;">
                <div class="row">
                    <div class="col-md-8">Due Report</div>
                </div>
            </div>
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Travel</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Money Transfer</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab-1" data-bs-toggle="pill" data-bs-target="#pills-profile-1" type="button" role="tab" aria-controls="pills-profile-1" aria-selected="false">Others</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <form @submit.prevent="SearchData()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <input type="date" class="form-control frm_date" id="frm_date" v-model="frm_date" placeholder="From Date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <!-- <Datepicker class="form-control to_date" placeholder="To Date"></Datepicker>   -->
                                    <input type="date" class="form-control to_date" id="datepicker" placeholder="To Date" v-model="to_date">
                                </div>
                            </div>
                            <div class="col-md-6 d-none">
                                <div class="input-group mb-3">
                                    <select class='form-control form-select customer_id' v-model="customer_id">
                                        <option value=''>Select Customer</option>
                                        <option v-for='data in customers' :value='data.customer_id'>{{ data.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <!-- <Datepicker class="form-control to_date" placeholder="To Date"></Datepicker>   -->
                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border loadingvideo" role="status" style="display:none">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <hr>
                    <table id="datatable" class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Invoice ID </th>
                                <th>Datetime</th>
                                <th>Customer Name</th>
                                <th>Customer Phone</th>
                                <th>Create By</th>
                                <th>Due Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='data in report'>
                                <td>{{ data.inv_id  }}</td>
                                <td>{{ data.invoice_date  }}</td>
                                <td>{{ data.customer_name }}</td>
                                <td>{{ data.phone }}</td>
                                <td>{{ data.name }}</td>
                                <td>{{ data.due_amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-3">
                            <center><span style="font-size: 25px; font-weight: bold;color:green;">Total Due: {{ total_due }}</span></center>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <form @submit.prevent="SearchDataForMoney()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <input type="date" class="form-control frm_date" id="money_frm_date" placeholder="From Date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <!-- <Datepicker class="form-control to_date" placeholder="To Date"></Datepicker>   -->
                                    <input type="date" class="form-control to_date" id="money_to_date" placeholder="To Date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <!-- <Datepicker class="form-control to_date" placeholder="To Date"></Datepicker>   -->
                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border loadingvideo" role="status" style="display:none">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <hr>
                    <table id="datatable" class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Invoice ID </th>
                                <th>Datetime</th>
                                <th>Customer Name</th>
                                <th>Customer Phone</th>
                                <th>Create By</th>
                                <th>Due Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='data in money_report'>
                                <td>{{ data.mone_transfer_id  }}</td>
                                <td>{{ data.invoice_date  }}</td>
                                <td>{{ data.customer_name }}</td>
                                <td>{{ data.phone }}</td>
                                <td>{{ data.name }}</td>
                                <td>{{ data.due_amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-3">
                            <center><span style="font-size: 25px; font-weight: bold;color:green;">Total Due: {{ money_total_due }}</span></center>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile-1" role="tabpanel" aria-labelledby="pills-profile-tab-1">
                    <form @submit.prevent="SearchDataOthers()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <input type="date" class="form-control frm_date" id="o_frm_date" placeholder="From Date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <!-- <Datepicker class="form-control to_date" placeholder="To Date"></Datepicker>   -->
                                    <input type="date" class="form-control to_date" id="o_to_date" placeholder="To Date">
                                </div>
                            </div>
                            <div class="col-md-6 d-none">
                                <div class="input-group mb-3">
                                    <select class='form-control form-select customer_id' v-model="customer_id">
                                        <option value=''>Select Customer</option>
                                        <option v-for='data in customers' :value='data.customer_id'>{{ data.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border loadingvideo" role="status" style="display:none">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <hr>
                    <table id="datatable" class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <!-- <th>Invoice ID </th> -->
                                <th>Datetime</th>
                                <th>Customer Name</th>
                                <th>Purpose</th>
                                <th>Net Amount</th>
                                <th>Customer Amount</th>
                                <th>Amount Paid</th>
                                <th>Amount Due</th>
                                <!-- <th>Profit</th> -->
                                <th>Create By</th>
                     
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='data in others_report'>
                                <!-- <td>{{ data.others_inv_id  }}</td> -->
                                <td>{{ data.invoice_date  }}</td>
                                <td>{{ data.customer_name }}</td>
                                <td>{{ data.purpose }}</td>
                                <td>{{ data.net_amount }}</td>
                                <td>{{ data.customer_amount }}</td>
                                <td>{{ data.amount_paid }}</td>
                                <td>{{ data.due_amount }}</td>
                                <!-- <td>{{ data.profit }}</td> -->
                                <td>{{ data.name }}</td>
                
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-3">
                            <center><span style="font-size: 25px; font-weight: bold;color:green;">Total Due: {{ other_total_due }}</span></center>
                        </div>
                    </div>
                </div>

            </div>
            <!-- row -->
        </div>
        <!-- Button trigger modal -->
        <Footer />
    </div>
</div>
</template>

<script>
import $ from "jquery";
import Datepicker from '../../components/Datepicker.vue';
import datepickerFactory from 'jquery-datepicker'
import {
    useRouter
} from "vue-router"
datepickerFactory($);
export default {
    setup() {
        const router = useRouter()
    },
    components: {
        Datepicker
    },
    data: function () {
        return {
            videoList: [],
            customers: [],
            frm_date: '',
            to_date: '',
            phone: '',
            total_due: '',
            money_total_due: '',
            other_total_due: '',
            customer_id: '',
            report: [],
            money_report: [],
            others_report: [],
        };
    },
    mounted() {
        //   this.customerlist();
        //   $('.frm_date,.to_date').datepicker();
    },
    methods: {
        customerlist() {
            axios.get('/api/category/allCustomers').then(response => {
                this.customers = response.data.data;
            });
        },
        SearchData() {
            $(".loadingvideo").show();
            const formData = new FormData();
            let frm_date = $(".frm_date").val();
            let to_date = $(".to_date").val();
            let customer_id = $(".customer_id").val();
            formData.append('frm_date', frm_date);
            formData.append('to_date', to_date);
            formData.append('customer_id', customer_id);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/post/dueReport',
                formData, {
                    headers
                }).then((res) => {
                $(".loadingvideo").hide();
                //    console.log(res.data.data);
                this.report = res.data.data;
                this.total_due = res.data.total_sum;
                console.log(res.data.total_sum);
                this.frm_date = frm_date;
                this.to_date = to_date;
            }).catch(e => {
                this.notifmsg = e.response.data
            });
        },
        SearchDataForMoney() {
            $(".loadingvideo").show();
            const formData = new FormData();
            let frm_date = $("#money_frm_date").val();
            let to_date = $("#money_to_date").val();
            let customer_id = $(".customer_id").val();
            formData.append('frm_date', frm_date);
            formData.append('to_date', to_date);
            formData.append('customer_id', customer_id);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/post/dueReportMoney',
                formData, {
                    headers
                }).then((res) => {
                $(".loadingvideo").hide();
                //    console.log(res.data.data);
                this.money_report = res.data.data;
                this.money_total_due = res.data.total_sum;
                console.log(res.data.total_sum);
                this.frm_date = frm_date;
                this.to_date = to_date;
            }).catch(e => {
                this.notifmsg = e.response.data
            });
        },
        SearchDataOthers() {
            $(".loadingvideo").show();
            const formData = new FormData();
            let frm_date = $("#o_frm_date").val();
            let to_date = $("#o_to_date").val();
            let customer_id = $(".customer_id").val();
            formData.append('frm_date', frm_date);
            formData.append('to_date', to_date);
            formData.append('customer_id', customer_id);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/post/deReportOthers',
                formData, {
                    headers
                }).then((res) => {
                $(".loadingvideo").hide();
                //    console.log(res.data.data);
                this.others_report = res.data.data;
                this.other_total_due = res.data.total_sum;
                console.log(res.data.total_sum);
                this.frm_date = frm_date;
                this.to_date = to_date;
            }).catch(e => {
                this.notifmsg = e.response.data
            });
        }
    }
};
</script>
