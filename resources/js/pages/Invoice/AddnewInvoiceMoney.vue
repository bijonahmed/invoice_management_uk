<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Money Transfer Create Invoice</div>
                    <div class="col-md-2">
                        <router-link to="/invoice/invoice-list-money-transfer"><span stye="text-align:center;">Back</span></router-link>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-10">
                    <input type="text" class="form-control customer_phone" placeholder="Customer Phone" aria-label="Customer Phone" @keyup="getcustomerInfo()">
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" @click="resetfrm"><i class="fa-solid fa-plus"></i>&nbsp;New Customer</button>
                </div>
            </div>
            <br>
            <div class="alert-primary" role="alert">
                Invoice <br>
                <div class="row">
                    <div class="col-md-7">
                        <!-- Date: {{ cdata.currentdate }}<br> -->
                        [Company Name: {{ cdata.company_name }}, Email: {{ cdata.email }},
                        Phone:{{ cdata.tel }}]<br>Address: {{ cdata.address }}
                    </div>
                    <div class="col-md-5">
                        Customer Information:<br>
                        Name : {{ customerInfo.customername }}, Phone :{{ customerInfo.customerphone }}<br>Address : {{ customerInfo.customeraddres }}
                    </div>
                </div>
            </div>
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
                                            <option value="2">Money Transfer</option>
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
                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Transaction Ref.</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control transaction_ref" v-model="insertData.transaction_ref" id="transaction_ref" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Invoice Date</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control invoice_date" v-model="insertData.invoice_date" id="invoice_date" placeholder="Invoice Date" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Supplier</label>
                                            <div class="col-sm-8">
                                                <select name="sulipper_id" v-model="insertData.sulipper_id" class="form-select sulipper_id">
                                                    <option value="">Select</option>
                                                    <option v-for='data in supplierlist' :value='data.sulipper_id'>{{data.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control customer_id" name="customer_id" id="customer_id">
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Beneficiary name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control beneficiary_name" v-model="insertData.beneficiary_name" id="beneficiary_name" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Bene. City</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control beneficiary_city" v-model="insertData.beneficiary_city" id="beneficiary_city" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Bene. Country</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control beneficiary_country" v-model="insertData.beneficiary_country" id="beneficiary_country" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Bene. Contact Number</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control beneficary_contact_num" v-model="insertData.beneficary_contact_num" id="beneficary_contact_num" placeholder="XXXXXX" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Payment Receive</label>
                                            <div class="col-sm-8">
                                                <select name="payment_receive" v-model="insertData.payment_receive" class="form-select payment_receive">
                                                    <option value="Cash">Cash</option>
                                                    <option value="Bank transfer">Bank Transfer</option>
                                                    <option value="Small world">Small world</option>
                                                    <option value="Card Payment">Card Payment</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Payment Type</label>
                                            <div class="col-sm-8">
                                                <select name="payment_type" v-model="insertData.payment_type" class="form-select payment_type" @change="payType">
                                                    <option value="1">Bkash</option>
                                                    <option value="2">Bank Transfer</option>
                                                    <option value="3">Cash</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div v-if="insertData.p_type == 1">
                                            <!-- {{ insertData.p_type }} -->
                                            <div class="row mb-1">
                                                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Bkash Number</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control bkash_number" v-model="insertData.bkash_number" id="bkash_number">
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="insertData.p_type == 2">
                                            <!-- {{ insertData.p_type }} -->
                                            <div class="level_bank_details">
                                                <div class="row mb-1">
                                                    <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Bank Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control bank_name" v-model="insertData.bank_name" id="bank_name">
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Bank Branch</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control branch_name" v-model="insertData.branch_name" id="branch_name">
                                                    </div>
                                                </div>
                                                <div class="row mb-1 level_bkash_num">
                                                    <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Account No</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control acc_no" v-model="insertData.acc_no" id="acc_no">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="insertData.p_type == 3">
                                            <!-- {{ insertData.p_type }} -->
                                            <div class="row mb-1">
                                                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Pickup Bank Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control bank_name" v-model="insertData.bank_name" id="bank_name">
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Pickup Bank Branch</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control branch_name" v-model="insertData.branch_name" id="branch_name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Rate</label>
                                            <div class="col-sm-7">
                                                <input type="text" autocomplete="off" class="form-control rate onlyNumbersInput" v-model="insertData.rate" id="rate" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Fees</label>
                                            <div class="col-sm-7">
                                                <input type="text" autocomplete="off" class="form-control fees onlyNumbersInput" v-model="insertData.fees" id="fees" placeholder="0.00">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Others Fees</label>
                                            <div class="col-sm-7">
                                                <input type="text" autocomplete="off" class="form-control others_fees onlyNumbersInput" v-model="insertData.others_fees" id="others_fees" placeholder="0.00">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Receiving BD Amount</label>
                                            <div class="col-sm-7">
                                                <input type="text" autocomplete="off" class="form-control receiving_amount onlyNumbersInput" v-model="insertData.receiving_amount" id="receiving_amount" placeholder="0.00" @keyup="calculated">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Customer Amount</label>
                                            <div class="col-sm-7">
                                                <input type="text" autocomplete="off" class="form-control total_amount onlyNumbersInput" v-model="insertData.total_amount" id="total_amount" placeholder="0.00">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Net Amount</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control net_amount onlyNumbersInput" v-model="insertData.net_amount" id="net_amount" autocomplete="off" placeholder="0.00">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Profit</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control profit onlyNumbersInput" v-model="insertData.profit" id="profit" placeholder="0.00" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Customer Deposit</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control customer_deposit onlyNumbersInput" v-model="insertData.customer_deposit" id="customer_deposit" autocomplete="off" placeholder="0.00" @keyup=getDueAmt()>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Due Amount</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control due_amount onlyNumbersInput" v-model="insertData.due_amount" id="due_amount" placeholder="0.00" autocomplete="off">
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
        var $this = $(this);
        $this.val($this.val().replace(/[^\d.]/g, ''));
    });
});
export default {
    components: {},
    data() {
        return {
            notifmsg: '',
            newcus_data: {
                customer_id: '',
                name: '',
                phone: '',
                addres: '',
                type: 1,
                destination: '',
                status: 1,
            },
            customerInfo: {
                customer_id: '',
                customername: '',
                customeraddres: '',
                customerphone: '',
            },
            cdata: {
                company_name: '',
                address: '',
                email: '',
                tel: '',
            },
            insertData: {
                invoice_date: '',
                customer_id: '',
                mone_transfer_id: '',
                beneficiary_name: '',
                net_amount: '',
                payment_receive: '',
                profit: '',
                customer_deposit: '',
                due_amount: '',
                others_fees: '',
                total_amount: '',
                acc_no: '',
                sulipper_id: '',
                transaction_ref: '',
                beneficiary_city: '',
                beneficiary_country: 'Bangladesh',
                beneficary_contact_num: '',
                bkash_number: '',
                bank_name: '',
                branch_name: '',
                p_type: '',
                payment_type: '',
                rate: '',
                fees: '',
                receiving_amount: '',
            },
            supplierlist: [],
            cartItem: [],
            customerlist: [],
        }
    },
    created() {
        this.getCustomerlist();
        this.findRowId();
        this.allSuppliers();
    },
    methods: {
        resetfrm() {
            $('#formrest_customer')[0].reset();
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
                    var cus_id = $('.customer_id').val();
                    formData.append('invoice_date', this.insertData.invoice_date);
                    formData.append('mone_transfer_id', this.insertData.mone_transfer_id);
                    formData.append('beneficiary_name', this.insertData.beneficiary_name);
                    formData.append('beneficiary_city', this.insertData.beneficiary_city);
                    formData.append('customer_id', cus_id);
                    formData.append('payment_receive', this.insertData.payment_receive);
                    formData.append('sulipper_id', this.insertData.sulipper_id);
                    formData.append('beneficiary_country', this.insertData.beneficiary_country);
                    formData.append('beneficary_contact_num', this.insertData.beneficary_contact_num);
                    formData.append('bkash_number', this.insertData.bkash_number);
                    formData.append('total_amount', this.insertData.total_amount);
                    formData.append('bank_name', this.insertData.bank_name);
                    formData.append('acc_no', this.insertData.acc_no);
                    formData.append('branch_name', this.insertData.branch_name);
                    formData.append('rate', this.insertData.rate);
                    formData.append('transaction_ref', this.insertData.transaction_ref);
                    formData.append('fees', this.insertData.fees);
                    formData.append('net_amount', this.insertData.net_amount);
                    formData.append('receiving_amount', this.insertData.receiving_amount);
                    formData.append('payment_type', this.insertData.payment_type);
                    formData.append('others_fees', this.insertData.others_fees);
                    formData.append('net_amount', this.insertData.net_amount);
                    formData.append('profit', this.insertData.profit);
                    formData.append('customer_deposit', this.insertData.customer_deposit);
                    formData.append('due_amount', this.insertData.due_amount);

                    const headers = {
                        'Content-Type': 'multipart/form-data'
                    };
                    axios.post('/api/category/saveInvoiceMoney',
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
                        this.$router.push('/invoice/invoice-list-money-transfer');
                    }).catch(e => {
                        this.notifmsg = e.response.data
                    });
                    return false;
                }
            })
        },
        allSuppliers() {
            axios.get('/api/category/moneySuppliders').then(response => {
                this.supplierlist = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        },
        getcustomerInfo() {
            $(".loadingbar").show();
            var customerphone = $(".customer_phone").val();
            this.axios.get(`/api/user/customerRow/${customerphone}`).then((response) => {
                $(".loadingbar").hide();
                //this.customerInfo.customer_id = response.data.data.customer_id;
                if (response.data.data !== null) {
                    $("#customer_id").val(response.data.data.customer_id);
                    console.log("Customer ID: " + response.data.data.customer_id);
                    this.customerInfo.customername = response.data.data.name;
                    this.customerInfo.customeraddres = response.data.data.addres;
                    this.customerInfo.customerphone = response.data.data.phone;
                }
            });
        },
        payType() {
            let payment_type = this.insertData.payment_type
            this.insertData.p_type = payment_type;
        },
        getCustomerlist() {
            axios.get(`/api/category/allCustomerMoney`).then(response => {
                this.customerlist = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        },
        calculated() {
            //total_amount
            let result = parseFloat(this.insertData.receiving_amount) / parseFloat(this.insertData.rate) + parseFloat(this.insertData.fees) + parseFloat(this.insertData.others_fees);
            console.log(result.toFixed(2));
            this.insertData.total_amount = result.toFixed(2);
            this.profitCalculate();
        },
        profitCalculate() {
            const percentage = 50;
            const fees = parseFloat(this.insertData.fees);
            const res = (percentage / 100) * fees;
            const othersfee = this.insertData.others_fees ? this.insertData.others_fees : 0;
            console.log(`Fee ${fees} & ${percentage} % Result is: ${res}%`);
            let result = parseFloat(res) + parseFloat(othersfee);
            console.log(result.toFixed(2));
            this.insertData.profit = result.toFixed(2);
        },

        getDueAmt() {
            const customer_deposit = this.insertData.customer_deposit ? parseFloat(this.insertData.customer_deposit) : 0;
            const total_amount = this.insertData.total_amount ? parseFloat(this.insertData.total_amount) : 0;
            let result = customer_deposit - total_amount;
            this.insertData.due_amount = result;
            // $(".due_amount").val(dueamt);
        }
    }
}
</script>
