<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />

        <div id="printableArea">
           
            <div class="page-content" style="background-color: white;">
                <center>Money Transfer Invoice</center>
                <center>
                <h3>Transaction Ref:{{ customerInfo.transaction_ref }}</h3>
            </center>
                <table width="100%" border="0" align="center">
                    <tr>
                        <td width="33%">
                            <div align="center"><img :src="`/456.jpg`" width="143" height="100" />
                            </div>
                        </td>
                        <td width="41%">&nbsp;</td>
                        <td width="26%"><strong>{{ customerInfo.customername }}</strong><br />
                            <span class="style1">{{ customerInfo.customeraddres }}<br />
                                {{ customerInfo.customerphone }}</span></td>
                    </tr>

                    <tr>
                        <td bgcolor="#CCCCCC">Invoice For</td>
                        <td colspan="2" rowspan="2">
                            <table width="100%" border="0" align="left">
                                <tr>
                                    <td width="21%"><span class="style4 d-none">Invoice Ref</span></td>
                                    <td width="19%"><span class="style4 d-none">:{{ customerInfo.mone_transfer_id }}</span></td>
                                    <td width="22%">&nbsp;</td>
                                    <td width="18%"><span class="style4"></span></td>
                                    <td width="20%"><span class="style4"></span></td>
                                </tr>
                                <tr>
                                    <td><span class="style4">Invoice Date</span></td>
                                    <td><span class="style4">:{{ customerInfo.date }}</span></td>
                                    <td>&nbsp;</td>
                                    <td><span class="style4"></span></td>
                                    <td><span class="style4"></span></td>
                                </tr>
                                <tr>
                                    <td><span class="style4"></span></td>
                                    <td><span class="style4"></span></td>
                                    <td>&nbsp;</td>
                                    <td><span class="style4"></span></td>
                                    <td><span class="style4"></span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>{{ cdata.company_name }}</strong><br />
                            <span class="style1">{{ cdata.address }}<br />
                                {{ cdata.tel }}</span><br />
                            <span class="style1">Email: {{ cdata.email }}</span></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>

                <table width="100%" border="1">
                    <tr>
                        <td width="35%"><span class="style9">Beneficiary name</span></td>
                        <td width="27%"><span class="style9"><strong>:</strong>{{ customerInfo.beneficiary_name }}</span></td>
                        <td width="16%"><span class="style9">Rate</span></td>
                        <td width="22%"><span class="style9">:{{ customerInfo.rate }}</span></td>
                    </tr>
                    <tr>
                        <td><span class="style9">Beneficiary City</span></td>
                        <td><span class="style9"><strong>:</strong>{{ customerInfo.beneficiary_city }}</span></td>
                        <td><span class="style9">Fees</span></td>
                        <td><span class="style9">:{{ customerInfo.fees }}</span></td>
                    </tr>

                    <tr>
                        <td><span class="style9">Beneficiary Country</span></td>
                        <td><span class="style9">:{{ customerInfo.beneficiary_country }}</span></td>
                        <td>Others Fees</td>
                        <td>:{{ customerInfo.others_fees }}</td>
                    </tr>
                    <tr>
                        <td><span class="style9">Beneficiary Contact Number</span></td>
                        <td><span class="style9">:{{ customerInfo.beneficary_contact_num }}</span></td>
                        <td><span class="style9">Receiving BD Amount</span></td>
                        <td><span class="style9">:{{ customerInfo.receiving_amount }}</span></td>
                    </tr>
                    <tr>
                        <td valign="top"><span class="style9">Payment Receive</span></td>
                        <td valign="top"><span class="style9">:{{ customerInfo.payment_receive }}</span></td>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="2"><span class="style9">Payment Type</span><span class="style9">:<span v-if="customerInfo.payment_type == 1">
                                    <span class="style9">Bkash<br>
                                        Number: {{ customerInfo.bkash_number }}</span>
                                </span>
                                <span v-if="customerInfo.payment_type == 2">
                                    <span class="style9">Bank Transfer<br>
                                        Bank : {{ customerInfo.bank_name }}<br>
                                        Branch : {{ customerInfo.branch_name }}<br>
                                        Account No : {{ customerInfo.acc_no }}<br>
                                    </span> </span>
                                <span v-if="customerInfo.payment_type == 3"> <span class="style9">Cash<br>
                                        Pickup Bank Name : {{ customerInfo.bank_name }}<br>
                                        Pickup Bank Branch : {{ customerInfo.branch_name }}<br>

                                    </span></span>
                            </span> </td>
                        <td><span class="style9">Customer Amount</span></td>
                        <td><span class="style9">:0.00</span></td>
                    </tr>

                    <tr>
                        <td valign="top"><span class="style9">Customer Amount</span></td>
                        <td valign="top"><span class="style9">:{{ customerInfo.total_amount }}</span></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><span class="style9">Net Amount</span></td>
                        <td><span class="style9">:{{ customerInfo.net_amount }}</span></td>
                    </tr>
                    <tr style="display: none;">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><span class="style9">Profit</span></td>
                        <td><span class="style9">:{{ customerInfo.profit }}</span></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><span class="style9">Customer Deposit</span></td>
                        <td><span class="style9">:{{ customerInfo.customer_deposit }}</span></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><span class="style9">Due Amount</span></td>
                        <td><span class="style9">:{{ customerInfo.due_amount }}</span></td>
                    </tr>
                </table>

                <br />

                <p align="right"><strong>Invoice By: {{ customerInfo.entry_by }}</strong></p>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <button type="button" class="btn btn-primary me-2 w-100 submit_btn" @click="printDiv('printableArea')">Print</button>
                </div>
                <div class="col-4">
                    <button type="button" class="btn btn-danger me-2 w-100 submit_btn" @click="reloading">Reload</button>
                </div>
                <div class="col-4">
                    <button type="button" class="btn btn-success me-2 w-100" @click="newInvoice">New Invoice</button>
                </div>
            </div>
        </div>

        <Footer />
    </div>
</div>
</template>

<script>
export default {
    components: {},
    data() {
        return {
            cdata: {
                company_name: '',
                address: '',
                email: '',
                tel: '',
            },
            notifmsg: '',
            customerInfo: {
                payment_receive: '',
                transaction_ref:'',
                entry_by: '',
                beneficiary_name: '',
                beneficiary_city: '',
                beneficiary_country: '',
                beneficary_contact_num: '',
                payment_type: '',
                bkash_number: '',
                bank_name: '',
                branch_name: '',
                acc_no: '',
                others_fees: '',
                rate: '',
                fees: '',
                receiving_amount: '',
                total_amount: '',
                customername: '',
                customeraddres: '',
                customerphone: '',
            },
            itemlist: [],
            cartItem: [],
        }
    },
    created() {
        this.findInvoiceId();
        this.findRowId();
    },
    methods: {
        findInvoiceId() {
            this.axios
                .get(`/api/category/getInvoiceMoneyData/${this.$route.params.id}`)
                .then((response) => {

                    console.log("ddd" + response.data.transaction_ref);
                    //Invoice
                    this.customerInfo.mone_transfer_id = response.data.data.mone_transfer_id;
                    this.customerInfo.date = response.data.invoice_date;
                    this.customerInfo.entry_by = response.data.entry_by;
                    this.customerInfo.transaction_ref = response.data.transaction_ref;
                    //customer 
                    this.customerInfo.customername = response.data.data.name;
                    this.customerInfo.customeraddres = response.data.data.addres;
                    this.customerInfo.customerphone = response.data.data.phone;
                    //end
                    this.customerInfo.payment_receive = response.data.data.payment_receive;
                    this.customerInfo.beneficiary_name = response.data.data.beneficiary_name;
                    this.customerInfo.beneficiary_city = response.data.data.beneficiary_city;
                    this.customerInfo.beneficiary_country = response.data.data.beneficiary_country;
                    this.customerInfo.beneficary_contact_num = response.data.data.beneficary_contact_num;
                    this.customerInfo.payment_type = response.data.data.payment_type;
                    this.customerInfo.bkash_number = response.data.data.bkash_number;
                    this.customerInfo.bank_name = response.data.data.bank_name;
                    this.customerInfo.branch_name = response.data.data.branch_name;
                    this.customerInfo.acc_no = response.data.data.acc_no;
                    this.customerInfo.rate = response.data.data.rate;
                    this.customerInfo.fees = response.data.data.fees;
                    this.customerInfo.receiving_amount = response.data.data.receiving_amount;
                    this.customerInfo.total_amount = response.data.data.total_amount;
                    this.customerInfo.others_fees = response.data.data.others_fees;
                    this.customerInfo.net_amount = response.data.data.net_amount;
                    this.customerInfo.profit = response.data.data.profit;
                    this.customerInfo.customer_deposit = response.data.data.customer_deposit;
                    this.customerInfo.due_amount = response.data.data.due_amount;

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
        printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        },
        newInvoice() {
            this.$router.push('/invoice/addnewinvoiceMoney');
        },
        reloading() {
            location.reload()
        }
    }
}
</script>

<style>
.style1 {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 13px;
}

.style4 {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 11px;
}

.style6 {
    font-size: 12px;
    font-family: Verdana, Arial, Helvetica, sans-serif;
}

.style9 {
    /* font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 12px; */
}
</style>
