<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Edit</div>
                    <div class="col-md-2">
                        <router-link to="/invoice/invoice-list-money-transfer"><span stye="text-align:center;">Back</span></router-link>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-12">
                    <select name="customer_id" v-model="insertData.customer_id" class="form-select">
                        <option value="">Select</option>
                        <option v-for='data in customerlist' :value='data.customer_id'>{{
                                                        data.name
                                                }}</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="alert-primary" role="alert">
                <div class="col-md-6">
                    Customer Information:<br>
                    Name : {{ customerInfo.customername }}, Phone :{{ customerInfo.customerphone }}<br>Address : {{ customerInfo.customeraddres }}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div v-for="(errorArray, idx) in notifmsg" :key="idx">
                                <div v-for="(allErrors, idx) in errorArray" :key="idx">
                                    <span class="text-danger">{{ allErrors}} </span>
                                </div>
                            </div>
                            <form @submit.prevent="saveData()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-1">

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
                                            <!-- <input type="hidden" class="form-control" v-model="insertData.customer_id" /> -->
                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Beneficiary name</label>
                                            <div class="col-sm-8">
                                                <input type="hidden" class="form-control mone_transfer_id" v-model="insertData.mone_transfer_id" id="mone_transfer_id" autocomplete="off">
                                                <input type="text" class="form-control beneficiary_name" v-model="insertData.beneficiary_name" id="beneficiary_name" autocomplete="off">
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
                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Rate</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control rate onlyNumbersInput" v-model="insertData.rate" id="rate" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Fees</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control fees onlyNumbersInput" v-model="insertData.fees" id="fees" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Receiving BD Amount</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control receiving_amount onlyNumbersInput" v-model="insertData.receiving_amount" id="receiving_amount" placeholder="0.00" @keyup="calculated">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Total Amount</label>
                                            <div class="col-sm-8">
                                                <input type="text" autocomplete="off" class="form-control total_amount onlyNumbersInput" v-model="insertData.total_amount" id="total_amount" placeholder="0.00">
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

                                                <div class="row mb-1">
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
export default {
    data() {
        return {
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
                invoice_date: '',
                customer_id: '',
                sulipper_id: '',
                transaction_ref: '',
                category_id: '',
                payment_receive: '',
                mone_transfer_id: '',
                acc_no: '',
                beneficiary_name: '',
                total_amount: '',
                others_fees: '',
                beneficiary_city: '',
                beneficiary_country: '',
                beneficary_contact_num: '',
                payment_type: '',
                bkash_number: '',
                bank_name: '',
                branch_name: '',
                p_type: '',
                rate: '',
                fees: '',
                receiving_amount: '',
                net_amount: '',
                profit: '',
                customer_deposit: '',
                due_amount: '',
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
        saveData() {
            const formData = new FormData();
            formData.append('invoice_date', this.insertData.invoice_date);
            formData.append('mone_transfer_id', this.insertData.mone_transfer_id);
            formData.append('beneficiary_name', this.insertData.beneficiary_name);
            formData.append('beneficiary_city', this.insertData.beneficiary_city);
            formData.append('beneficiary_country', this.insertData.beneficiary_country);
            formData.append('beneficary_contact_num', this.insertData.beneficary_contact_num);
            formData.append('rate', this.insertData.rate);
            formData.append('fees', this.insertData.fees);
            formData.append('customer_id', this.insertData.customer_id);
            formData.append('payment_receive', this.insertData.payment_receive);
            formData.append('sulipper_id', this.insertData.sulipper_id);
            formData.append('bkash_number', this.insertData.bkash_number);
            formData.append('bank_name', this.insertData.bank_name);
            formData.append('branch_name', this.insertData.branch_name);
            formData.append('total_amount', this.insertData.total_amount);
            formData.append('transaction_ref', this.insertData.transaction_ref);
            formData.append('acc_no', this.insertData.acc_no);
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
        },
        allSuppliers() {
            axios.get('/api/category/moneySuppliders').then(response => {
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
                .get(`/api/category/editInvoiceMoneyId/${this.$route.params.id}`)
                .then((response) => {
                    this.insertData.invoice_date = response.data.data.invoice_date;
                    this.insertData.mone_transfer_id = response.data.data.mone_transfer_id;
                    this.insertData.beneficiary_name = response.data.data.beneficiary_name;
                    this.insertData.beneficiary_city = response.data.data.beneficiary_city;
                    this.insertData.beneficiary_country = response.data.data.beneficiary_country;
                    this.insertData.beneficary_contact_num = response.data.data.beneficary_contact_num;
                    this.insertData.sulipper_id = response.data.data.sulipper_id;
                    this.insertData.bkash_number = response.data.data.bkash_number;
                    this.insertData.transaction_ref = response.data.data.transaction_ref;
                    this.insertData.bank_name = response.data.data.bank_name;
                    this.insertData.branch_name = response.data.data.branch_name;
                    this.insertData.customer_id = response.data.data.customer_id;
                    this.insertData.payment_type = response.data.data.payment_type;
                    this.insertData.payment_receive = response.data.data.payment_receive;
                    this.insertData.rate = response.data.data.rate;
                    this.insertData.total_amount = response.data.data.total_amount;
                    this.insertData.fees = response.data.data.fees;
                    this.insertData.receiving_amount = response.data.data.receiving_amount;
                    this.insertData.p_type = response.data.data.payment_type;
                    this.customerInfo.customername = response.data.data.customername;
                    this.customerInfo.customeraddres = response.data.data.addres;
                    this.customerInfo.customerphone = response.data.data.phone;
                    this.insertData.acc_no = response.data.data.acc_no;
                    this.insertData.others_fees = response.data.data.others_fees;
                    this.insertData.net_amount = response.data.data.net_amount;
                    this.insertData.profit = response.data.data.profit;
                    this.insertData.customer_deposit = response.data.data.customer_deposit;
                    this.insertData.due_amount = response.data.data.due_amount;
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
