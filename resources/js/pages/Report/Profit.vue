<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert" style="margin-bottom:10px;">
                <div class="row">
                    <div class="col-md-8">Report</div>
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
                    <button class="nav-link" id="pills-profile-1-tab" data-bs-toggle="pill" data-bs-target="#pills-profile-1" type="button" role="tab" aria-controls="pills-profile-1" aria-selected="false">Othres Invoice</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <form @submit.prevent="SearchData()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <input type="date" class="form-control frm_date" v-model="frm_date" placeholder="From Date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <!-- <Datepicker class="form-control to_date" placeholder="To Date"></Datepicker>   -->
                                    <input type="date" class="form-control to_date" placeholder="To Date" v-model="to_date">
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

                    <!-- start  -->
                    <div class="table-responsive">
                        <table border="2" cellpadding="1" cellspacing="2" width="100%" class="table">
                            <td height="17" width="107">
                                <div align="center" class="style8">Transaction Date&nbsp;</div>
                            </td>
                            <td width="110">
                                <div align="center" class="style8">PNR&nbsp;</div>
                            </td>
                            <td width="110">
                                <div align="center" class="style8">Passesnger Name&nbsp;</div>
                            </td>
                            <td width="116">
                                <div align="center" class="style8">Route</div>
                            </td>
                            <td width="123">
                                <div align="center" class="style8">Net Amount/Supplier Amount</div>
                            </td>
                            <td width="98">
                                <div align="center" class="style8">Customer Amount&nbsp;</div>
                            </td>
                            <td width="58">
                                <div align="center" class="style8">Profit</div>
                            </td>
                            <td width="66">
                                <div align="center" class="style8">Amount Paid</div>
                            </td>
                            <td width="56">
                                <div align="center" class="style8">Due</div>
                            </td>
                            <td width="99">
                                <div align="center" class="style8">Suppliers</div>
                            </td>
                            <td width="123">
                                <div align="center" class="style8">Payment type&nbsp;</div>
                            </td>

                            <tr height="17" v-for="data in report" :key="data.inv_id">
                                <td height="17" class="style8"><span class="style21">{{ data.created_at  }}</span></td>
                                <td class="style8">{{ data.vendorpnr }}</td>
                                <td class="style8"><span class="style21">{{ data.customer_name }}</span></td>
                                <td class="style8"><span class="style21">{{ data.depart_to }}</span></td>
                                <td class="style8"><span class="style21 text-center">
                                        <center>{{ data.net_amount }}</center>
                                    </span></td>
                                <td class="style8"><span class="style21">
                                        <center>{{ data.customer_amount }}</center>
                                    </span></td>
                                <td class="style8"><span class="style21">
                                        <center>{{ data.profit }}</center>
                                    </span></td>
                                <td class="style8"><span class="style21">
                                        <center>{{ data.customer_deposit }}</center>
                                    </span></td>
                                <td class="style8"><span class="style21">
                                        <center>{{ data.due_amount }}</center>
                                    </span></td>
                                <td class="style8"><span class="style21">{{ data.supplier_name }}</span></td>
                                <td class="style8"><span class="style21">
                                        <p v-if="data.status === 1">Bank</p>
                                        <p v-else-if="data.status === 2">Bank Transfer</p>
                                        <p v-else-if="data.status === 3">Cash</p>
                                        <p v-else>Unknown Status</p>
                                    </span></td>
                            </tr>

                        </table>
                    </div>

                    <!-- end -->

                </div>

                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <form @submit.prevent="SearchDataMoney()" id="formrest" class="forms-sample" enctype="multipart/form-data">
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
                    <!-- start money  -->

                    <table width="100%" height="100%" border="2" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <col width="343" />
                        <col width="226" />
                        <col width="203" />
                        <col width="196" />
                        <col width="140" span="2" />
                        <col width="196" />
                        <col width="154" span="2" />
                        <col width="179" span="2" />
                        <col width="168" />
                        <col width="154" />
                        <tr height="17">
                            <td height="17" width="111"><span class="style3">
                                    <center>Tran. date</center>&nbsp;
                                </span></td>
                            <td width="147">
                                <div align="center"><span class="style3">Beneficiary<br />
                                        Name</span></div>
                            </td>
                            <td width="74">
                                <div align="center"><span class="style3">Sender Name&nbsp;</span></div>
                            </td>
                            <td width="95">
                                <div align="center"><span class="style3">Sending Amount&nbsp;</span></div>
                            </td>
                            <td width="64">
                                <div align="center"><span class="style3">Rate</span></div>
                            </td>
                            <td width="66">
                                <div align="center"><span class="style3">sale</span></div>
                            </td>
                            <td width="54">
                                <div align="center"><span class="style3">Charge</span></div>
                            </td>
                            <td width="54">
                                <div align="center"><span class="style3">Others Charge</span></div>
                            </td>
                            <td width="64">
                                <div align="center"><span class="style3">Total sale</span></div>
                            </td>
                            <td width="63">
                                <div align="center"><span class="style3">Profit</span></div>
                            </td>
                            <td width="91">
                                <div align="center"><span class="style3">Customer Paid&nbsp;</span></div>
                            </td>
                            <td width="86">
                                <div align="center"><span class="style3">Payment type&nbsp;</span></div>
                            </td>
                            <td width="47">
                                <div align="center"><span class="style3">Due</span></div>
                            </td>
                            <td width="90">
                                <div align="center"><span class="style3">Supplier</span></div>
                            </td>
                        </tr>
                        <tr height="17" v-for='data in money_report' :key="data.mone_transfer_id">
                            <td height="17">
                                <center>{{ data.invoice_date  }}</center>
                            </td>
                            <td>
                                <center>{{ data.beneficiary_name  }}</center>
                            </td>
                            <td>
                                <center>{{ data.customer_name }}</center>
                            </td>
                            <td>
                                <center>{{ data.receiving_amount }}</center>
                            </td>
                            <td>
                                <center>{{ data.rate  }}</center>
                            </td>
                            <td>
                                <center>{{ (data.receiving_amount / data.rate).toFixed(2) }}</center>
                            </td>
                            <td>
                                <center>{{ data.fees  }}</center>
                            </td>
                            <td>
                                <center>{{ data.others_fees  }}</center>
                            </td>
                            <td>
                                <center>{{ calculateTotal().toFixed(2) }}</center>
                            </td>
                            <td>
                                <center>{{ data.profit  }}</center>
                            </td>
                            <td>
                                <center>{{ data.customer_deposit  }}</center>
                            </td>
                            <td>
                                <p v-if="data.status === 1">Bank</p>
                                <p v-else-if="data.status === 2">Bank Transfer</p>
                                <p v-else-if="data.status === 3">Cash</p>
                                <p v-else>Unknown Status</p>
                            </td>
                            <td>
                                <center>{{ data.due_amount  }}</center>
                            </td>
                            <td>
                                <center>{{ data.supplier_name  }}</center>
                            </td>
                        </tr>

                    </table>
                    <hr />
                    <table width="100%" border="6">
                        <tr>
                            <td width="24%">Total Transaction </td>
                            <td width="1%">:</td>
                            <td width="75%"><strong>{{ totalTransaction }}</strong></td>
                        </tr>
                        <tr>
                            <td>Transaction Balance</td>
                            <td>:</td>
                            <td><strong>{{ total_fees }}</strong></td>
                        </tr>
                        <tr>
                            <td>Total Profit </td>
                            <td>:</td>
                            <td><strong>{{ money_total_profit }}</strong></td>
                        </tr>
                        <tr>
                            <td>Total Due /Outstanding </td>
                            <td>:</td>
                            <td><strong>{{ total_due }}</strong></td>
                        </tr>
                    </table>

                    <!-- end money -->
                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-3">
                            <center><span style="font-size: 25px; font-weight: bold;color:green;">Total Profit: {{ money_total_profit }}</span></center>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-profile-1" role="tabpanel" aria-labelledby="pills-profile-tab">
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
                                <!-- <th>Amount Due</th> -->
                                <th>Create By</th>
                                <th>Profit Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='data in others_report'>
                                <!-- <td>{{ data.others_inv_id  }}</td> -->
                                <td>{{ data.create_date  }}</td>
                                <td>{{ data.customer_name }}</td>
                                <td>{{ data.purpose }}</td>
                                <td>{{ data.net_amount }}</td>
                                <td>{{ data.customer_amount }}</td>
                                <td>{{ data.amount_paid }}</td>
                                <!-- <td>{{ data.due_amount }}</td> -->
                                <td>{{ data.name }}</td>
                                <td>{{ data.profit }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-3">
                            <center><span style="font-size: 25px; font-weight: bold;color:green;">Total Profit: {{ others_total_profit }}</span></center>
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
            total_fees: 0,
            total_profit: 0,
            totalTransaction: 0,
            total_due: 0,
            money_total_profit: 0,
            others_total_profit: 0,
            customer_id: '',
            report: [],
            money_report: [],
            others_report: [],
        };
    },
    mounted() {
        //   this.customerlist();
        //  $('.frm_date,.to_date').datepicker();
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
            axios.post('/api/post/profitReport',
                formData, {
                    headers
                }).then((res) => {
                $(".loadingvideo").hide();

                this.report = res.data.data;
                this.total_profit = res.data.total_sum;

                console.log(res.data.total_sum);
                this.frm_date = frm_date;
                this.to_date = to_date;
            }).catch(e => {
                this.notifmsg = e.response.data
            });
        },
        SearchDataMoney() {
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
            axios.post('/api/post/profitReportMoney',
                formData, {
                    headers
                }).then((res) => {
                $(".loadingvideo").hide();
                //    console.log(res.data.data);
                this.money_report = res.data.data;
                this.money_total_profit = res.data.total_sum;
                this.total_fees = res.data.total_fees;
                // console.log(res.data.total_sum);
                this.total_due = res.data.total_due;
                this.totalTransaction = res.data.totalTransaction;
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
            axios.post('/api/post/profitReportOthers',
                formData, {
                    headers
                }).then((res) => {
                $(".loadingvideo").hide();
                //    console.log(res.data.data);
                this.others_report = res.data.data;
                this.others_total_profit = res.data.total_sum;
                console.log(res.data.total_sum);
                this.frm_date = frm_date;
                this.to_date = to_date;
            }).catch(e => {
                this.notifmsg = e.response.data
            });
        },
        calculateTotal() {
            const receivingAmount = parseFloat(this.money_report.receiving_amount) || 0;
            const fees = parseFloat(this.money_report.fees) || 0;
            const othersFees = parseFloat(this.money_report.others_fees) || 0;

            return (receivingAmount + fees + othersFees);
        }
    }
};
</script>

<style>
table {
    border-collapse: collapse;
}

table,
th,
td {
    border: 1px solid black;
}

.style8 {
    font-size: 12px;
}

.style13 {
    font-size: 10
}

.style21 {
    font-size: 10;
    font-family: "Times New Roman", Times, serif;
}
</style>
