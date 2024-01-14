<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Edit</div>
                    <div class="col-md-2">
                        <router-link to="/invoice/invoice-list-others"><span stye="text-align:center;">Back</span></router-link>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-12">
                    <select name="customer_id" v-model="insertData.customer_id" class="form-select">
                        <option value="">Select</option>
                        <option v-for='data in customerlist' :value='data.customer_id'>{{data.name }}</option>
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

                            <form @submit.prevent="addItem()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                                <div class="row">
                                    <input type="hidden" class="form-control others_inv_id" v-model="insertData.others_inv_id" id="others_inv_id" autocomplete="off">
                                    <input type="hidden" class="form-control customer_id" name="customer_id" id="customer_id">
                                    <div class="col-md-6">
                                        <div class="row mb-1">

                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Invoice Date</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control invoice_date" v-model="insertData.invoice_date" id="invoice_date" placeholder="Invoice Date" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">Purpose</label>
                                            <div class="col-sm-8">
                                                <select name="purpose" v-model="insertData.purpose" class="form-select purpose">
                                                    <option value="">Select</option>
                                                    <option value="NRV">NRV</option>
                                                    <option value="MRP">MRP</option>
                                                    <option value="Other">Other</option>

                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Customer Amount</label>
                                            <div class="col-sm-7">
                                                <input type="text" autocomplete="off" class="form-control customer_amount onlyNumbersInput" v-model="insertData.customer_amount" id="customer_amount" placeholder="0.00">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Net Amount</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control net_amount onlyNumbersInput" v-model="insertData.net_amount" id="net_amount" autocomplete="off" placeholder="0.00" @keyup="getProfit">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Amount Paid</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control amount_paid onlyNumbersInput" v-model="insertData.amount_paid" id="amount_paid" autocomplete="off" placeholder="0.00" @keyup=dueAmount>
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Profit</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control profit onlyNumbersInput" v-model="insertData.profit" id="profit" placeholder="0.00" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <label for="exampleInputUsername2" class="col-sm-5 col-form-label">Due</label>
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
// import Nav from '../../components/Nav.vue';
// import Sidebar from '../../components/Sidebar.vue';
export default {
    components: {
        // Nav,
        // Sidebar
    },
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
                invoice_date:'',
                customer_id: '',
                others_inv_id: '',
                purpose: '',
                net_amount: '',
                customer_amount: '',
                amount_paid: '',
                profit: '',
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
        addItem() {
            const formData = new FormData();
            var cus_id = $('.customer_id').val();
            formData.append('invoice_date', this.insertData.invoice_date);
            formData.append('others_inv_id', this.insertData.others_inv_id);
            formData.append('purpose', this.insertData.purpose);
            formData.append('net_amount', this.insertData.net_amount);
            formData.append('customer_id', cus_id);
            formData.append('customer_amount', this.insertData.customer_amount);
            formData.append('amount_paid', this.insertData.amount_paid);
            formData.append('profit', this.insertData.profit);
            formData.append('due_amount', this.insertData.due_amount);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/category/saveInvoiceOthers',
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
                this.$router.push('/invoice/invoice-list-others');
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
                .get(`/api/category/editInvoiceOthersInvId/${this.$route.params.id}`)
                .then((response) => {
                    this.insertData.customer_id = response.data.data.customer_id;
                    this.insertData.others_inv_id = response.data.data.others_inv_id;
                    this.insertData.purpose = response.data.data.purpose;
                    this.insertData.net_amount = response.data.data.net_amount;
                    this.insertData.customer_amount = response.data.data.customer_amount;
                    this.insertData.amount_paid = response.data.data.amount_paid;
                    this.insertData.profit = response.data.data.profit;
                    this.insertData.due_amount = response.data.data.due_amount;
                    this.insertData.invoice_date = response.data.data.invoice_date;
                    $(".customer_id").val(response.data.data.customer_id);
                    //header
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
            axios.get(`/api/category/allCustomerOthers`).then(response => {
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
        getProfit() {
            let result = parseFloat(this.insertData.customer_amount) - parseFloat(this.insertData.net_amount);
            console.log(result.toFixed(2));
            if (typeof result == "number" && result >= 0) {
                this.insertData.profit = result.toFixed(2);
            }
        },
        dueAmount() {
            let result = parseFloat(this.insertData.customer_amount) - parseFloat(this.insertData.amount_paid);
            console.log(result.toFixed(2));

            if (typeof result == "number" && result >= 0) {
                this.insertData.due_amount = result.toFixed(2);
            }

        }

    }
}
</script>
