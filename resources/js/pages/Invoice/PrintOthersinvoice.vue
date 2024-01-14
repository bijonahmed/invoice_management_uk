<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />

        <div id="printableArea">
            <div class="page-content" style="background-color: white;">
                <center>Monetry Transfer Invoice</center>
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
                                    <td width="21%"><span class="style4">Invoice Ref</span></td>
                                    <td width="19%"><span class="style4">:{{ customerInfo.others_inv_id }}</span></td>
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
                        <td colspan="2" rowspan="2"><span class="style9">Purpose</span><span class="style9">: 
                                        Number: {{ customerInfo.purpose }}</span>
                               
                         </td>
                        <td><span class="style9">Customer Amount</span></td>
                        <td><span class="style9">:{{  customerInfo.customer_amount  }}</span></td>
                    </tr>
                    <tr>
                        <!-- <td valign="top"><span class="style9">Net Amount</span></td>
                        <td valign="top"><span class="style9">:{{ customerInfo.net_amount }}</span></td> -->
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><span class="style9">Amount Paid</span></td>
                        <td><span class="style9">:{{ customerInfo.amount_paid }}</span></td>
                    </tr>
                    <tr>
                        <!-- <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><span class="style9">Profit</span></td>
                        <td><span class="style9">:{{ customerInfo.profit }}</span></td> -->
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
                entry_by: '',
                purpose: '',
                net_amount: '',
                customer_amount: '',
                amount_paid: '',
                profit: '',
                due_amount: '',
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
                .get(`/api/category/getInvoiceOthersData/${this.$route.params.id}`)
                .then((response) => {
                    //Invoice
                    this.customerInfo.others_inv_id = response.data.data.others_inv_id;
                    this.customerInfo.date = response.data.data.invoice_date;
                    this.customerInfo.entry_by = response.data.entry_by;
                    //customer 
                    this.customerInfo.customername = response.data.data.name;
                    this.customerInfo.customeraddres = response.data.data.addres;
                    this.customerInfo.customerphone = response.data.data.phone;
                    //end
                    this.customerInfo.purpose = response.data.data.purpose;
                    this.customerInfo.net_amount = response.data.data.net_amount;
                    this.customerInfo.customer_amount = response.data.data.customer_amount;
                    this.customerInfo.amount_paid = response.data.data.amount_paid;
                    this.customerInfo.profit = response.data.data.profit;
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
            this.$router.push('/invoice/invoice-list-money-transfer');
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
