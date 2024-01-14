<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <select name="customer_id" id="customer_id" v-model="insertData.customer_id" class="form-select">
                        <option value="">Select</option>
                        <option v-for='data in customerlist' :value='data.customer_id'>{{
                                                        data.name
                                                }}</option>
                    </select>
                </div>

            </div>
            <br>
            <!-- Modal -->

            <!-- END Modal -->
            <center>
                <div class="d-flex justify-content-center">
                    <div class="spinner-border loadingbar" role="status" style="display:none">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </center>
            <div class="alert-primary" role="alert">
                Invoice : {{ insertData.inv_id }}<br>
                <div class="row">
                    <div class="col-md-7">
                        Date: {{ cdata.created_at }}<br>
                        [Company Name: {{ cdata.company_name }}, Email: {{ cdata.email }},
                        Phone:{{ cdata.tel }}]<br>Address: {{ cdata.address }}
                    </div>
                    <div class="col-md-5">
                        Customer Information:<br>
                        Name : {{ customerInfo.customername }}, Phone :{{ customerInfo.customerphone }}<br>Address : {{ customerInfo.customeraddres }}
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <div v-for="(errorArray, idx) in notifmsg" :key="idx">
                                    <div v-for="(allErrors, idx) in errorArray" :key="idx">
                                        <span class="text-danger">{{ allErrors}} </span>
                                    </div>
                                </div>
                            </center>
                            <form @submit.prevent="addItem()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="row mb-1">

                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Invoice Date</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control invoice_date" v-model="insertData.invoice_date" id="invoice_date" placeholder="Invoice Date" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Supplier</label>
                                            <div class="col-sm-9">
                                                <select name="sulipper_id" v-model="insertData.sulipper_id" class="form-select sulipper_id">
                                                    <option value="">Select</option>
                                                    <option v-for='data in supplierlist' :value='data.sulipper_id'>{{data.name}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Addi. passenger </label>
                                            <div class="col-sm-9">
                                                <textarea type="text" class="form-control add_pesenger" v-model="insertData.add_pesenger" id="add_pesenger" placeholder="Additional Passenger" autocomplete="off"></textarea>
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Depart From</label>
                                            <div class="col-sm-9">
                                                <input type="hidden" class="form-control invoice_id" v-model="insertData.invoice_id" id="invoice_id">
                                                <input type="text" class="form-control depart_from" v-model="insertData.depart_from" id="depart_from" placeholder="Depart From" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Depart To</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control depart_to" v-model="insertData.depart_to" id="depart_to" placeholder="Depart To" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Airline</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control airline" v-model="insertData.airline" id="airline" placeholder="Airline" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Flight No</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control flight_no" v-model="insertData.flight_no" id="flight_no" placeholder="Flight No" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Class</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control class" v-model="insertData.class" id="class" placeholder="Class" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Departure Time</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control departure_time" v-model="insertData.departure_time" id="departure_time" placeholder="Departure Time" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Departure Date</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control departure_date" v-model="insertData.departure_date" id="departure_date" placeholder="Departure Date" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Arrival Date</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control arrival_date" v-model="insertData.arrival_date" id="arrival_date" placeholder="Arrival Date" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Arrival Time</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control arrival_time" v-model="insertData.arrival_time" id="arrival_time" placeholder="Arrival Time" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Duration</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control duration" v-model="insertData.duration" id="duration" placeholder="Duration" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Baggage</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control baggage" v-model="insertData.baggage" id="baggage" placeholder="Baggage" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Ticket No.</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control ticketno" v-model="insertData.ticketno" id="ticketno" placeholder="Ticket No" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Vendor PNR</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control vendorpnr" v-model="insertData.vendorpnr" id="vendorpnr" placeholder="Vendor PNR" autocomplete="off">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Net Amount</label>
                                            <div class="col-sm-7">
                                                <input type="hidden" class="form-control customer_id" name="customer_id" id="customer_id">
                                                <input type="text" class="form-control net_amount onlyNumbersInput" v-model="insertData.net_amount" id="net_amount" placeholder="0.00" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Customer Amount</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control customer_amount onlyNumbersInput" v-model="insertData.customer_amount" id="customer_amount" autocomplete="off" placeholder="0.00" @keyup="getProfit()">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Profit</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control profit onlyNumbersInput" v-model="insertData.profit" id="profit" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Customer Deposit</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control customer_deposit onlyNumbersInput" v-model="insertData.customer_deposit" id="customer_deposit" placeholder="0.00" @keyup=getDueAmt()>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Due Amount</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control due_amount onlyNumbersInput" v-model="insertData.due_amount" id="due_amount" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Payment Method</label>
                                            <div class="col-sm-7">
                                                <select name="payment_type" v-model="insertData.payment_type" class="form-select payment_type">
                                                    <option value="1" selected>Bank Transfer</option>
                                                    <option value="2">Card Payment</option>
                                                    <option value="3">Cash</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary me-2 w-100 submit_btn">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</div>
</template>

<script>
// import Nav from '../../components/Nav.vue';
// import Sidebar from '../../components/Sidebar.vue';
export default {
    components: {
        // Nav,
        // Sidebar
    },
    data() {
        return {
            newcus_data: {
                customer_id: '',
                name: '',
                phone: '',
                addres: '',
                type: 1,
                destination: '',
                status: 1,
            },
            cdata: {
                company_name: '',
                address: '',
                email: '',
                tel: '',
            },
            customerInfo: {
                customer_id: '',
                customername: '',
                customeraddres: '',
                customerphone: '',
            },
            insertData: {
                invoice_date:'',
                add_pesenger: '',
                invoice_id: '',
                inv_id: '',
                customer_id: '',
                sulipper_id: '',
                net_amount: '',
                customer_amount: '',
                profit: '',
                customer_deposit: '',
                depart_from: '',
                depart_to: '',
                airline: '',
                flight_no: '',
                class: '',
                departure_time: '',
                departure_date: '',
                arrival_date: '',
                arrival_time: '',
                duration: '',
                baggage: '',
                ticketno: '',
                vendorpnr: '',
                due_amount: '',
                payment_type: 1,
            },
            notifmsg: '',
            customerlist: [],
            supplierlist: [],
        }
    },
    created() {
        this.findRowId();
        this.getCustomerlist();
        this.selectCompany();
        this.allSuppliers();
    },
    methods: {
        addItem() {
            const formData = new FormData();
            var customer_id = $("#customer_id").val();
            console.log("Customer" + customer_id + " added");
            formData.append('invoice_date', this.insertData.invoice_date);
            formData.append('invoice_id', this.insertData.invoice_id);
            formData.append('customer_id', customer_id);
            formData.append('add_pesenger', this.insertData.add_pesenger);
            formData.append('depart_from', this.insertData.depart_from);
            formData.append('depart_to', this.insertData.depart_to);
            formData.append('airline', this.insertData.airline);
            formData.append('flight_no', this.insertData.flight_no);
            formData.append('class', this.insertData.class);
            formData.append('departure_time	', this.insertData.departure_time);
            formData.append('departure_date', this.insertData.departure_date);
            formData.append('arrival_date', this.insertData.arrival_date);
            formData.append('arrival_time', this.insertData.arrival_time);
            formData.append('duration', this.insertData.duration);
            formData.append('baggage', this.insertData.baggage);
            formData.append('ticketno', this.insertData.ticketno);
            formData.append('vendorpnr', this.insertData.vendorpnr);
            formData.append('net_amount', this.insertData.net_amount);
            formData.append('customer_amount', this.insertData.customer_amount);
            formData.append('sulipper_id', this.insertData.sulipper_id);
            formData.append('profit', this.insertData.profit);
            formData.append('customer_deposit', this.insertData.customer_deposit);
            formData.append('due_amount', this.insertData.due_amount);
            formData.append('payment_type', this.insertData.payment_type);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/category/saveInvoice',
                formData, {
                    headers
                }).then((res) => {
                $('#formrest')[0].reset();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Data has been saved!',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.$router.push({
                    name: "print-preview-invoice",
                    params: {
                        id: res.data.customer_id
                    }
                })
                console.log(res.data.customer_id);
                // this.$router.push('/customer/customer-list');
                // return false;
                // return false;
            }).catch(e => {
                this.notifmsg = e.response.data
            });
        },
        allSuppliers() {
            axios.get('/api/category/allsuppliders').then(response => {
                this.supplierlist = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        },
        selectCompany() {
            this.axios
                .get(`/api/user/getCompanySetting`)
                .then((response) => {
                    this.cdata.company_name = response.data.data.company_name;
                    this.cdata.address = response.data.data.address;
                    this.cdata.email = response.data.data.email;
                    this.cdata.tel = response.data.data.tel;
                });
        },
        findRowId() {
            this.axios
                .get(`/api/category/editInvoiceTravelId/${this.$route.params.id}`)
                .then((response) => {
                    this.insertData.invoice_date = response.data.data.invoice_date;
                    this.insertData.invoice_id = response.data.data.invoice_id;
                    this.insertData.inv_id = response.data.data.inv_id;
                    this.insertData.customer_id = response.data.data.customer_id;
                    this.insertData.sulipper_id = response.data.data.sulipper_id;
                    this.insertData.net_amount = response.data.data.net_amount;
                    this.insertData.customer_amount = response.data.data.customer_amount;
                    this.insertData.profit = response.data.data.profit;
                    this.insertData.customer_deposit = response.data.data.customer_deposit;
                    this.insertData.depart_from = response.data.data.depart_from;
                    this.insertData.depart_to = response.data.data.depart_to;
                    this.insertData.airline = response.data.data.airline;
                    this.insertData.flight_no = response.data.data.flight_no;
                    this.insertData.class = response.data.data.class;
                    this.insertData.departure_time = response.data.data.departure_time;
                    this.insertData.departure_date = response.data.data.departure_date;
                    this.insertData.arrival_date = response.data.data.arrival_date;
                    this.insertData.arrival_time = response.data.data.arrival_time;
                    this.insertData.duration = response.data.data.duration;
                    this.insertData.baggage = response.data.data.baggage;
                    this.insertData.ticketno = response.data.data.ticketno;
                    this.insertData.add_pesenger = response.data.data.add_pesenger;
                    this.insertData.vendorpnr = response.data.data.vendorpnr;
                    this.insertData.due_amount = response.data.data.due_amount;
                    this.insertData.payment_type = response.data.data.payment_type;
                    this.cdata.created_at = response.data.data.invoice_date;
                    this.customerInfo.customername = response.data.data.customername;
                    this.customerInfo.customeraddres = response.data.data.addres;
                    this.customerInfo.customerphone = response.data.data.phone;
                });
        },
        payType() {
            let payment_type = this.insertData.payment_type
            this.insertData.p_type = payment_type;
        },
        getCustomerlist() {
            axios.get(`/api/category/allCustomerslist`).then(response => {
                this.customerlist = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        }
    }
}
</script>
