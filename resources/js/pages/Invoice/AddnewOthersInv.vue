<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Others Invoice</div>
                    <div class="col-md-2">
                        <router-link to="/invoice/invoice-list-others"><span stye="text-align:center;">Back</span></router-link>
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
                                            <option value="3">Others</option>
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
                                        <input type="hidden" class="form-control customer_id" name="customer_id" id="customer_id">

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
                type: 3,
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
                others_inv_id: '',
                purpose: '',
                net_amount: '',
                customer_amount: '',
                amount_paid: '',
                profit: '',
                due_amount: '',
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
                    return false;
                }
            })
        },
        allSuppliers() {
            axios.get('/api/category/allsuppliders').then(response => {
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
