<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Company Setting</div>
                    <div class="col-md-2">
                        <router-link to="/dashboard"><span stye="text-align:center;">Back</span></router-link>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-9 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div v-for="(errorArray, idx) in editPassnotifmsg" :key="idx">
                                <div v-for="(allErrors, idx) in errorArray" :key="idx">
                                    <span class="text-danger">{{ allErrors}} </span>
                                </div>
                            </div>
                            <form @submit.prevent="updateprofile()" id="userSubmitFrm" class="forms-sample" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Company Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="company_name" v-model="company.company_name" id="company_name" placeholder="Company Name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Tel</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="tel" v-model="company.tel" autocomplete="off" placeholder="Tel">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="email" v-model="company.email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Emergency Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="emergency" v-model="company.emergency" placeholder="Emergency Phone">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Hotline Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="hotline" v-model="company.hotline" placeholder="Hotline Number">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Address</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="address" v-model="company.address" placeholder="Address"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Currency</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="currency" v-model="company.currency" placeholder="Currency">
                                    </div>
                                </div>
                                <hr>

                             <div class="d-none">
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label" style="color:green; font-weight: bold;">Trade (%)</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control numeric" name="trade_percent" v-model="company.trade_percent" placeholder="0" @keypress="isNumber($event)">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label" style="color:green; font-weight: bold;">Trade Fee</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="trade_fee" v-model="company.trade_fee" placeholder="0" @keypress="isNumber($event)">
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label" style="color:green; font-weight: bold;">Min. Deposit Amount</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="min_deposit" v-model="company.min_deposit" placeholder="0" @keypress="isNumber($event)">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label" style="color:green; font-weight: bold;">Maxi. Deposit Amount</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="max_deposit" v-model="company.max_deposit" placeholder="0" @keypress="isNumber($event)">
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label" style="color:rgb(2, 58, 2); font-weight: bold;">Min. Withdraw Amount</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="min_withdraw" v-model="company.min_withdraw" placeholder="0" @keypress="isNumber($event)">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label" style="color:rgb(2, 58, 2); font-weight: bold;">Max. Withdraw Amount</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="max_withdraw" v-model="company.max_withdraw" placeholder="0" @keypress="isNumber($event)">
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label" style="color:rgb(252, 75, 5); font-weight: bold;">Min. Trade Amount</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="min_trade_amount" v-model="company.min_trade_amount" placeholder="0" @keypress="isNumber($event)">
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label" style="color:rgb(214, 64, 4); font-weight: bold;">Mining Profit Amount</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="mining_profit" v-model="company.mining_profit" placeholder="0" @keypress="isNumber($event)">
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label" style="color:rgb(54, 16, 1); font-weight: bold;">Mining Duration (Hours)</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="mining_duration" v-model="company.mining_duration" placeholder="0" @keypress="isNumber($event)">
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label" style="color:rgb(45, 2, 114); font-weight: bold;">Upline Comission (%)</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="upline_comission" v-model="company.upline_comission" placeholder="0" @keypress="isNumber($event)">
                                    </div>
                                </div>
                            </div>
                                <hr>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Business Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="description" v-model="company.description" placeholder="Business Description"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Logo</label>
                                    <div class="col-sm-9">
                                        <input type="file" ref="file" @change="onFileSelected" class="form-control" id="file" name="file" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Facebook Link</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="fblink" v-model="company.fblink" placeholder="Facebook Link">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Twitter Link</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="twitterlink" v-model="company.twitterlink" placeholder="Twitter Link">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Linkdin Link</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="linkdinlink" v-model="company.linkdinlink" placeholder="Linkdin Link">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Crypto Wallet Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="crypto_wallet_address" v-model="company.crypto_wallet_address" placeholder="Crypto Wallet Address">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2 w-100">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div v-if="company.empImg === null">
                        <img :src="`/backend/assets/images/blank_profile.png`" style="height:150px; width: 200px;" alt="image" />
                    </div>
                    <div v-else>
                        <img :src="company.empImg" style="height:150px; width: 200px;" />
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</div>
</template>
<script>
import Nav from '../components/Nav.vue';
import Sidebar from '../components/Sidebar.vue';
export default {
    components: {
        Nav,
        Sidebar
    },
    data() {
        return {
            company: {
                company_name: '',
                email: '',
                address: '',
                hotline: '',
                emergency: '',
                trade_percent: '',
                trade_fee: '',
                min_deposit: '',
                max_deposit: '',
                min_withdraw: '',
                max_withdraw: '',
                min_trade_amount: '',
                mining_profit: '',
                mining_duration: '',
                upline_comission: '',
                description: '',
                country_id: '',
                tel: '',
                currency: '',
                fblink: '',
                twitterlink: '',
                linkdinlink: '',
                crypto_wallet_address: '',
                file: '',
                empImg: ''
            },
            editPassnotifmsg: '',
            countrylist: [],
        }
    },
    created() {
        this.defaultShowing();
        this.getCountryList();
    },
    methods: {
        onFileSelected() {
            this.file = this.$refs.file.files[0];
        },
        updateprofile() {
            const formData = new FormData();
            formData.append('file', this.file);
            formData.append('company_name', this.company.company_name);
            formData.append('email', this.company.email);
            formData.append('address', this.company.address);
            formData.append('hotline', this.company.hotline);
            formData.append('emergency', this.company.emergency);
            formData.append('country_id', this.company.country_id);
            formData.append('fblink', this.company.fblink);
            formData.append('tel', this.company.tel);
            formData.append('min_deposit', this.company.min_deposit);
            formData.append('max_deposit', this.company.max_deposit);
            formData.append('min_withdraw', this.company.min_withdraw);
            formData.append('max_withdraw', this.company.max_withdraw);
            formData.append('min_trade_amount', this.company.min_trade_amount);
            formData.append('mining_profit', this.company.mining_profit);
            formData.append('mining_duration', this.company.mining_duration);
            formData.append('upline_comission', this.company.upline_comission);
            formData.append('trade_percent', this.company.trade_percent);
            formData.append('trade_fee', this.company.trade_fee);
            formData.append('twitterlink', this.company.twitterlink);
            formData.append('linkdinlink', this.company.linkdinlink);
            formData.append('crypto_wallet_address', this.company.crypto_wallet_address);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/user/updateCompanySetting',
                formData, {
                    headers
                }).then((res) => {
                //console.log("Image: " + res.data.imagelink);
                this.loadImage(res.data.imagelink);
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                })
                return false;
            }).catch(e => {
                this.editPassnotifmsg = e.response.data
            });
        },
        getCountryList() {
            axios.get('/api/getcountryList').then(response => {
                this.countrylist = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        },
        isNumber: function (evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
            } else {
                return true;
            }
        },
        defaultShowing() {
            axios.get('/api/user/getCompanySetting').then(response => {
                this.company.company_name = response.data.data.company_name;
                this.company.email = response.data.data.email;
                this.company.tel = response.data.data.tel;
                this.company.address = response.data.data.address;
                this.company.hotline = response.data.data.hotline;
                this.company.emergency = response.data.data.emergency;
                this.company.trade_percent = response.data.data.trade_percent;
                this.company.trade_fee = response.data.data.trade_fee;
                this.company.min_deposit = response.data.data.min_deposit;
                this.company.max_deposit = response.data.data.max_deposit;
                this.company.min_withdraw = response.data.data.min_withdraw;
                this.company.max_withdraw = response.data.data.max_withdraw;
                this.company.min_trade_amount = response.data.data.min_trade_amount;
                this.company.mining_profit = response.data.data.mining_profit;
                this.company.mining_duration = response.data.data.mining_duration;
                this.company.upline_comission = response.data.data.upline_comission;
                this.company.country_id = response.data.data.country_id;
                this.company.currency = response.data.data.currency;
                this.company.description = response.data.data.description;
                this.company.fblink = response.data.data.fblink;
                this.company.twitterlink = response.data.data.twitterlink;
                this.company.linkdinlink = response.data.data.linkdinlink;
                this.company.crypto_wallet_address = response.data.data.crypto_wallet_address;
                this.company.empImg = response.data.data.logo;
            }).catch(error => {
                //  console.log(error);
            });
        },
        loadImage(imagelink) {
            this.company.empImg = imagelink;
        }
    },
}
</script>
