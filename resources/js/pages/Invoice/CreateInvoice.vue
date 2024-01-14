<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="row">
                <div class="col-10">
                    <input type="text" class="form-control customer_phone" placeholder="Customer Phone" aria-label="Customer Phone" @keyup="getcustomerInfo()">
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" @click="resetfrm"><i class="fa-solid fa-plus"></i>&nbsp;New Customer</button>
                </div>
            </div>
            <br>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form @submit.prevent="saveNewCustomer()" id="formrest_customer" class="forms-sample" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add New Customer</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <center>
                                    <div v-for="(errorArray, idx) in notifmsg_customer" :key="idx">
                                        <div v-for="(allErrors, idx) in errorArray" :key="idx">
                                            <span class="text-danger">{{ allErrors}} </span>
                                        </div>
                                    </div>
                                </center>
                                <div class="row mb-1">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control name" v-model="newcus_data.name" id="name" placeholder="">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Phone Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control phone" v-model="newcus_data.phone" id="phone" placeholder="">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Addres</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control addres" v-model="newcus_data.addres" id="addres" placeholder="">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Type</label>
                                    <div class="col-sm-9">
                                        <select name="status" v-model="newcus_data.type" class="form-select">
                                            <option value="1" selected>Travel</option>
                                            <!-- <option value="2">Money Transfer</option> -->
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-1 d-none">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Destination</label>
                                    <div class="col-sm-9">
                                        <select name="destination" v-model="newcus_data.destination" class="form-select">
                                            <option value="">Select</option>
                                            <option>London Stansted</option>
                                            <option>Manchester</option>
                                            <option>London City</option>
                                            <option>Heathrow</option>
                                            <option>Gateway </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary me-2" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END Modal -->
            <center>
                <div class="d-flex justify-content-center">
                    <div class="spinner-border loadingbar" role="status" style="display:none">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </center>
            <div class="alert-primary" role="alert">
                Invoice <br>
                <div class="row">
                    <div class="col-md-7">
                        Date: {{ cdata.currentdate }}<br>
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
$(document).ready(function () {
    $(".onlyNumbersInput").on('keyup keydown blur', function (event) {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
});
export default {
    components: {},
    data() {
        const current = new Date();
        const currentdate = `${current.getDate()}/${current.getMonth() + 1}/${current.getFullYear()}`;
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
                add_pesenger: '',
                address: '',
                email: '',
                tel: '',
                item_id: '',
                unit: '',
                unit_price: '',
                currentdate: currentdate
            },
            notifmsg: '',
            notifmsg_customer: '',
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
            supplierlist: [],
            cartItem: [],
        }
    },
    created() {
        this.findRowId();
        this.allSuppliers();
        this.carttemHistory();
    },
    methods: {
        addItem() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    var customer_id = $("#customer_id").val();
                    console.log("Customer" + customer_id + " added");
                    formData.append('invoice_date', this.insertData.invoice_date);
                    formData.append('invoice_id', this.insertData.invoice_id);
                    formData.append('add_pesenger', this.insertData.add_pesenger);
                    formData.append('customer_id', customer_id);
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
                }
            })
            return false;
        },
        resetfrm() {
            $('#formrest_customer')[0].reset();
        },
        saveNewCustomer() {
            const formData = new FormData();
            formData.append('customer_id', this.newcus_data.customer_id);
            formData.append('name', this.newcus_data.name);
            formData.append('phone', this.newcus_data.phone);
            formData.append('addres', this.newcus_data.addres);
            formData.append('type', this.newcus_data.type);
            formData.append('destination', this.newcus_data.destination);
            formData.append('status', this.newcus_data.status);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/category/saveCustomer',
                formData, {
                    headers
                }).then((res) => {
                $('#formrest_customer')[0].reset();
                $("#exampleModal").modal('hide');
                // return false;
                // return false;
            }).catch(e => {
                this.notifmsg_customer = e.response.data
            });
        },
        findRowId() {
            this.axios
                .get(`/api/user/getCompanySetting`)
                .then((response) => {
                    this.cdata.company_name = response.data.data.company_name;
                    this.cdata.address = response.data.data.address;
                    this.cdata.email = response.data.data.email;
                    this.cdata.tel = response.data.data.tel;
                });
        },
        allSuppliers() {
            axios.get('/api/category/allsuppliders').then(response => {
                this.supplierlist = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        },
        getItems() {
            let item_id = $(".item_id").val();
            this.axios.get(`/api/item/editItemId/${item_id}`).then((response) => {
                this.cdata.unit = response.data.data.unit;
                this.cdata.unit_price = response.data.data.unit_price;
            });
        },
        carttemHistory() {
            this.axios.get(`/api/item/getItemHistory`).then((response) => {
                console.log(response.data);
                this.cartItem = response.data.data;
            });
        },
        getcustomerInfo() {
            $(".loadingbar").show();
            var customerphone = $(".customer_phone").val();
            this.axios.get(`/api/user/customerRow/${customerphone}`).then((response) => {
                $(".loadingbar").hide();
                //this.customerInfo.customer_id = response.data.data.customer_id;
                $("#customer_id").val(response.data.data.customer_id);
                console.log("Customer ID: " + response.data.data.customer_id);
                this.customerInfo.customername = response.data.data.name;
                this.customerInfo.customeraddres = response.data.data.addres;
                this.customerInfo.customerphone = response.data.data.phone;
            });
        },
        getProfit() {
            var customer_amount = $(".customer_amount").val();
            var net_amount = $(".net_amount").val() ? $(".net_amount").val() : 0;
            var result = parseInt(customer_amount) - parseInt(net_amount);
            this.insertData.profit = result;
            //$(".profit").val(result);
        },
        getDueAmt() {
            var cus_amount = $(".customer_amount").val();
            var cus_deposit = $(".customer_deposit").val();
            var dueamt = parseInt(cus_amount) - parseInt(cus_deposit);
            this.insertData.due_amount = dueamt;
            // $(".due_amount").val(dueamt);
        }
    }
}
</script>
