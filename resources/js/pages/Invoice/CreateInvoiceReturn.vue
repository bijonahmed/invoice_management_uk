<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">

            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Refund Invoice</div>
                    <div class="col-md-2">
                        <router-link to="/invoice/invoice-refund"><span stye="text-align:center;">Back</span></router-link>
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-10">
                    <input type="text" class="form-control invoice_id" placeholder="Invoice ID" aria-label="Invoice ID">
                </div>
                <div class="col-2">
                    <button class="btn btn-primary" @click="gentInvoiceData"><i class="fa-solid fa-search"></i>&nbsp;Search</button>
                </div>
            </div>
            <br>
            <center>
                <div class="d-flex justify-content-center">
                    <div class="spinner-border loadingbar" role="status" style="display:none">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </center>
            <div class="alert-primary" role="alert">
                Invoice ID: {{ customerInfo.invoice_id }}<br>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <center>
                                        <div v-for="(errorArray, idx) in notifmsg" :key="idx">
                                            <div v-for="(allErrors, idx) in errorArray" :key="idx">
                                                <span class="text-danger">{{ allErrors}} </span>
                                            </div>
                                        </div>
                                    </center>
                                    <form @submit.prevent="addItem()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Return Amount</label>
                                            <div class="col-sm-9">
                                                <input type="hidden" class="form-control  onlyNumbersInput invoice_id" v-model="insertData.invoice_id" id="invoice_id">
                                                <input type="hidden" class="form-control  onlyNumbersInput customer_id" v-model="insertData.customer_id" id="customer_id">
                                                <input type="text" class="form-control  onlyNumbersInput return_amount" v-model="insertData.return_amount" id="return_amount" placeholder="0.00">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary me-2 w-100 submit_btn">Submit</button>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <center><b><u>Invoice Summary</u></b></center>
                                    <table class="table caption-top">
                                        <tbody>
                                            <tr>
                                                <td>Supplier</td>
                                                <td>:&nbsp;{{ customerInfo.suppliername }}</td>
                                            </tr>
                                            <tr>
                                                <td>Net Amount</td>
                                                <td>:&nbsp;{{ customerInfo.net_amount }}</td>
                                            </tr>
                                            <tr>
                                                <td>Customer Amount</td>
                                                <td>:&nbsp;{{ customerInfo.customer_amount }}</td>
                                            </tr>
                                            <tr>
                                                <td>Profit</td>
                                                <td>:&nbsp;{{ customerInfo.profit }}</td>
                                            </tr>
                                            <tr>
                                                <td>Customer Deposit</td>
                                                <td>:&nbsp;{{ customerInfo.customer_deposit }}</td>
                                            </tr>
                                            <tr>
                                                <td>Due Amount</td>
                                                <td>:&nbsp;{{ customerInfo.due_amount }}</td>
                                            </tr>
                                            <tr>
                                                <td>Payment Method</td>
                                                <td>:&nbsp;
                                                    <span v-if="customerInfo.payment_type == 1">
                                                        Bank Transfer
                                                    </span>
                                                    <span v-if="customerInfo.payment_type == 2">
                                                        Card Payment
                                                    </span>
                                                    <span v-if="customerInfo.payment_type == 3">
                                                        Cash
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
            cdata: {
                company_name: '',
                address: '',
                email: '',
                tel: '',
                item_id: '',
                unit: '',
                unit_price: '',
                currentdate: currentdate
            },
            notifmsg: '',
            customerInfo: {
                invoice_id: '',
                customer_id: '',
                customername: '',
                customeraddres: '',
                customerphone: '',
                suppliername: '',
                net_amount: '',
                customer_amount: '',
                profit: '',
                customer_deposit: '',
                due_amount: '',
                payment_type: '',

            },
            insertData: {
                inv_ret_travel_id: '',
                invoice_id: '',
                customer_id: '',
                return_amount: '',
                net_amount:'',

            },
            supplierlist: [],
            cartItem: [],
        }
    },
    created() {
        this.findRowId();

    },
    methods: {
        addItem() {
            const formData = new FormData();
            formData.append('invoice_id', this.insertData.invoice_id);
            formData.append('customer_id', this.insertData.customer_id);
            formData.append('return_amount', this.insertData.return_amount);
            formData.append('net_amount', this.customerInfo.net_amount);

            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/category/saveInvoiceReturn',
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
                //console.log(res.data.customer_id);
                this.$router.push('/invoice/invoice-refund');
                // return false;
                // return false;
            }).catch(e => {
                this.notifmsg = e.response.data
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

        gentInvoiceData() {

            $(".loadingbar").show();
            var invoice_id = $(".invoice_id").val();
            console.log(invoice_id);
            this.axios.get(`/api/category/getInvoiceDataChk/${invoice_id}`).then((response) => {
                $(".loadingbar").hide();
                console.log(response.data.message);
                if (response.data.message == 'success') {
                    this.insertData.customer_id = response.data.data.customer_id;
                    this.insertData.invoice_id = response.data.data.invoice_id;
                    this.customerInfo.customername = response.data.data.customername;
                    this.customerInfo.customeraddres = response.data.data.addres;
                    this.customerInfo.customerphone = response.data.data.phone;
                    this.customerInfo.suppliername = response.data.data.suppliername;

                    this.customerInfo.net_amount = response.data.data.net_amount;
                    this.customerInfo.customer_amount = response.data.data.customer_amount;
                    this.customerInfo.profit = response.data.data.profit;
                    this.customerInfo.customer_deposit = response.data.data.customer_deposit;
                    this.customerInfo.due_amount = response.data.data.due_amount;
                    this.customerInfo.payment_type = response.data.data.payment_type;

                } else {
                    alert("Sorry Invoice ID not found. Please write valid Invoice ID");
                    $(".invoice_id").val("");
                }

            });
        },

    }
}
</script>
