<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />

        <div id="printableArea">
            <div class="page-content" style="background-color: white;">
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
                                    <td width="19%"><span class="style4">:{{ customerInfo.inv_id }}</span></td>
                                    <td width="22%">&nbsp;</td>
                                    <td width="18%"><span class="style4">GDS PNR</span></td>
                                    <td width="20%"><span class="style4">: </span></td>
                                </tr>
                                <tr>
                                    <td><span class="style4">Invoice Date</span></td>
                                    <td><span class="style4">:{{ customerInfo.invoice_date }}</span></td>
                                    <td>&nbsp;</td>
                                    <td><span class="style4">Airline</span></td>
                                    <td><span class="style4">:{{ customerInfo.airline }}</span></td>
                                </tr>
                                <tr>
                                    <td><span class="style4">Invoice</span></td>
                                    <td><span class="style4">:Cash on Delivery</span></td>
                                    <td>&nbsp;</td>
                                    <td><span class="style4">VendorPNR</span></td>
                                    <td><span class="style4">:{{ customerInfo.vendorpnr }}</span></td>
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
                <br />
                <table width="100%" border="1" align="left">
                    <tr>
                        <td bgcolor="#CCCCCC" class="style4">DepartFro</td>
                        <td bgcolor="#CCCCCC" class="style4">DepartTo</td>
                        <td bgcolor="#CCCCCC" class="style4">Airline</td>
                        <td bgcolor="#CCCCCC" class="style4">FLNo</td>
                        <td bgcolor="#CCCCCC" class="style4">Clas</td>
                        <td bgcolor="#CCCCCC" class="style4">D.Time</td>
                        <td bgcolor="#CCCCCC" class="style4">D.Date</td>
                        <td bgcolor="#CCCCCC" class="style4">A.Date</td>
                        <td bgcolor="#CCCCCC" class="style4">A.Time</td>
                        <td bgcolor="#CCCCCC" class="style4">Status</td>
                        <td bgcolor="#CCCCCC" class="style4">Duration</td>
                        <td bgcolor="#CCCCCC" class="style4">Baggage</td>
                    </tr>
                    <tr>
                        <td class="style4">{{ customerInfo.depart_from }}</td>
                        <td class="style4">{{ customerInfo.depart_to }}</td>
                        <td class="style4">{{ customerInfo.airline }}</td>
                        <td class="style4">{{ customerInfo.flight_no }}</td>
                        <td class="style4">{{ customerInfo.class }}</td>
                        <td class="style4">{{ customerInfo.departure_time }} </td>
                        <td class="style4">{{ customerInfo.departure_date }}</td>
                        <td class="style4">{{ customerInfo.arrival_date }}</td>
                        <td class="style4">{{ customerInfo.arrival_time }}</td>
                        <td class="style4">OK</td>
                        <td class="style4">{{ customerInfo.duration }}</td>
                        <td class="style4">{{ customerInfo.baggage }}</td>
                    </tr>
                </table>
              
                <p class="style6"><br />
                    Passenger &amp; Ticket Date</p>
                <table width="100%" border="1">
                    <tr>
                        <td bgcolor="#CCCCCC" class="style4">P.Name </td>
                        <td bgcolor="#CCCCCC" class="style4">TicketNo</td>
                        <td bgcolor="#CCCCCC" class="style4">Status</td>
                        <td bgcolor="#CCCCCC" class="style4">Date</td>
                        <td bgcolor="#CCCCCC" class="style4">Fare</td>
                        <td bgcolor="#CCCCCC" class="style4">Disc/Fee</td>
                        <td bgcolor="#CCCCCC" class="style4">ATOL</td>
                        <td bgcolor="#CCCCCC" class="style4">Admin</td>
                        <td bgcolor="#CCCCCC" class="style4">Total</td>
                    </tr>
                    <tr>
                        <td class="style4">{{ customerInfo.customername }}</td>
                        <td class="style4">{{ customerInfo.ticketno }}</td>
                        <td class="style4">ISSUE</td>
                        <td class="style4">{{ customerInfo.date }}</td>
                        <td class="style4">{{ customerInfo.customer_amount }}</td>
                        <td class="style4">0.00</td>
                        <td class="style4">0.00</td>
                        <td class="style4">0.00</td>
                        <td class="style4">{{ customerInfo.customer_amount }}</td>
                    </tr>
                </table>
                <span v-if="customerInfo.add_pesenger">
                <p>Additional Passenger:</p>
                {{ customerInfo.add_pesenger }}
                </span>
                <br />
                <table width="100%" border="1" style="display:none;">
                    <tr>
                        <td width="23%" bgcolor="#CCCCCC" class="style4">Date</td>
                        <td width="14%" bgcolor="#CCCCCC" class="style4">Type</td>
                        <td width="18%" bgcolor="#CCCCCC" class="style4">Amount </td>
                        <td width="45%" bgcolor="#CCCCCC" class="style4">Remark</td>
                    </tr>
                    <tr>
                        <td class="style4">{{ customerInfo.date }}</td>
                        <td class="style4">PAYMENT</td>
                        <td class="style4">0.00</td>
                        <td class="style4">Batch payment: 9000.00 (9000.00)/BANK_TRANSFER</td>
                    </tr>
                </table>
                <br />
                <table width="100%" border="1">
                    
                    <tr>
                        <td class="style4">Customer Amount</td>
                        <td class="style4">:£{{ customerInfo.customer_amount }}</td>
                    </tr>
                    
                    <tr>
                        <td class="style4">Customer Deposit</td>
                        <td class="style4">:£{{ customerInfo.customer_deposit }}</td>
                    </tr>
                    <tr>
                        <td class="style4">Due Amount</td>
                        <td class="style4">:£{{ customerInfo.due_amount }}</td>
                    </tr>
                    <tr>
                        <td class="style4">Payment Method</td>
                        <td class="style4">:<span v-if="customerInfo.payment_type == 1">Bank Transfer</span>
                            <span v-if="customerInfo.payment_type == 2">Card Payment</span>
                            <span v-if="customerInfo.payment_type == 3">Cash</span></td>
                    </tr>
                </table>
                <br />
                <table width="1060" border="1">
                    <tr>
                        <td style="width: 80%;" class="style4">
                            <div align="justify">Dear Traveller,<br />
                                Please check your tickets asap,should you have any queries please contact us immediately.All tickets are subject to a cancellation charge.Non refundable tickets are totally non refundable. For a refundable ticket refund charge is minimum &pound;200.00 befor 72 hours, it varies airlines to airlines. Any reissue/ refund, date change penalty is Airlines charge plus service charge &pound;50.00 for each pax. No show and Part used ticket is non refundable please ensure you have a valid passport and visa for travel. Atleast six months valid passport needed from the date of the travel. you are advised to report at check in counter 4 hours before the schedule time.Also need to check PCR/covid19 requirements.<br />
                                We also advise you to re-confirm your flights at least 72 hours before departure.</div>
                        </td>
                    </tr>
                </table>
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
                inv_id: '',
                add_pesenger:'',
                invoice_date: '',
                net_amount: '',
                customer_amount: '',
                profit: '',
                customer_deposit: '',
                due_amount: '',
                payment_type: '',
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
                .get(`/api/category/getInvoiceData/${this.$route.params.id}`)
                .then((response) => {
                    //Invoice
                    this.customerInfo.inv_id = response.data.data.inv_id;
                    this.customerInfo.invoice_date = response.data.create_date;
                    this.customerInfo.entry_by = response.data.entry_by;
                    this.customerInfo.net_amount = response.data.data.net_amount;
                    this.customerInfo.customer_amount = response.data.data.customer_amount;
                    this.customerInfo.profit = response.data.data.profit;
                    this.customerInfo.customer_deposit = response.data.data.customer_deposit;
                    this.customerInfo.due_amount = response.data.data.due_amount;
                    this.customerInfo.payment_type = response.data.data.payment_type;
                    this.customerInfo.add_pesenger = response.data.data.add_pesenger;
                    //extra
                    this.customerInfo.depart_from = response.data.data.depart_from;
                    this.customerInfo.depart_to = response.data.data.depart_to;
                    this.customerInfo.airline = response.data.data.airline;
                    this.customerInfo.flight_no = response.data.data.flight_no;
                    this.customerInfo.class = response.data.data.class;
                    this.customerInfo.departure_time = response.data.data.departure_time;
                    this.customerInfo.departure_date = response.data.data.departure_date;
                    this.customerInfo.arrival_date = response.data.data.arrival_date;
                    this.customerInfo.arrival_time = response.data.data.arrival_time;
                    this.customerInfo.duration = response.data.data.duration;
                    this.customerInfo.baggage = response.data.data.baggage;
                    this.customerInfo.ticketno = response.data.data.ticketno;
                    this.customerInfo.vendorpnr = response.data.data.vendorpnr;
                    //end 
                    //customer 
                    this.customerInfo.customername = response.data.data.name;
                    this.customerInfo.customeraddres = response.data.data.addres;
                    this.customerInfo.customerphone = response.data.data.phone;
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
            this.$router.push('/invoice/addnewinvoice');
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
</style>
