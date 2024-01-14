<template>
<div id="dShow" v-show="elementVisible">
    <div class="main-wrapper">
        <div class="page-wrapper">
            <Nav />
            <div class="page-content">
                <center>
                    <div class="loader text-center" v-show="elementVisibleLoader"></div>
                </center>
                <div class="row">
                    <div v-if="(authUser.role_id == 2)">

                        <!-- <center><p>Welcome, {{ user.name }}!</p> -->
                        <!-- <center><button @click="logout">Logout</button></center> -->
                        <div class="col-12 col-xl-12 stretch-card">
                            <div class="row flex-grow-1">
                                <div class="col-md-3">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h6 class="card-title mb-0">Total Customer</h6>
                                            </div>
                                            <div class="row">
                                                <p class="mb-2">{{ totalCustomer }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-white bg-danger mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h6 class="card-title mb-0">Total Due</h6>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 col-md-12 col-xl-5">
                                                    <p class="mb-2">{{ totalDue }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 stretch-card">
                                    <div class="card text-dark bg-info mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h6 class="card-title mb-0">Total Profit</h6>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 col-md-12 col-xl-5">
                                                    <p class="mb-2">{{ totalProfit }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 stretch-card">
                                    <div class="card text-light bg-dark mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h6 class="card-title mb-0">Total Users</h6>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 col-md-12 col-xl-5">
                                                    <p class="mb-2">{{ totalusers }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="(authUser.role_id == 3)">
                        <div class="col-12 col-xl-12 stretch-card">
                            <div class="row flex-grow-1">
                                <div class="col-md-3" @click="addInvoice">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h1 class="card-title mb-0">Travel</h1>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3" @click="addInvoiceMoney">
                                    <div class="card text-white bg-success mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h2 class="card-title mb-0">Money Transfer</h2>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3" @click="addInvoiceOthers">
                                    <div class="card text-white bg-info mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <h2 class="card-title mb-0">Other Invoice</h2>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- row -->
            </div>
            <!-- Button trigger modal -->
            <Footer />
        </div>
    </div>
</div>
</template>

<script>
import $ from "jquery";
import {
    useRouter
} from "vue-router"
import {
    useStore
} from 'vuex'
export default {
    setup() {
        const router = useRouter();
        const store = useStore();

        function logout() {
            store.dispatch('removeToken');
            router.push({
                name: 'Login'
            })
        }
        return {
            logout
        }
    },
    data() {
        return {
            authUser: window.authUser,
            chkUsers: "",
            elementVisible: false,
            elementVisibleLoader: true,
            authUser: window.authUser,
            email: "",
            externalLink: "https://test.futuregenit.com",
            post: [],
            tradelist: [],
            totalusers: 0,
            totalCustomer: 0,
            totalProfit: 0,
            totalDue: 0
        }
    },
    created() {
        //this.logInChk();
        setTimeout(() => this.elementVisible = true, 1000)
        setTimeout(() => this.elementVisibleLoader = false, 1200)
        if (authUser !== null) {
            this.email = authUser.email;
            console.log("user now login: " + this.email);
            this.getLastVideo();
            //this.tradehistory();
        }
    },
    methods: {

        logout() {
            axios.post('/api/logout')
                .then(() => {
                    localStorage.removeItem('token');
                    delete axios.defaults.headers.common['Authorization'];
                    this.$router.push('/login');
                })
                .catch(error => {
                    console.error(error);
                });
        },

        logInChk() {
            if (authUser !== null) {
                this.chkUsers = authUser;
                console.log("roleID:" + this.chkUsers.role_id);
            }
        },

        getLastVideo() {
            axios.get('/api/post/getTotalCount').then(response => {
                //this.post = response.data.data;
                this.totalusers = response.data.totalusers;
                this.totalCustomer = response.data.totalCustomer;
                this.totalProfit = response.data.totalProfit;
                this.totalDue = response.data.totalDue;
            }).catch(error => {
                //  console.log(error);
            });
        },
        addInvoice() {
            this.$router.push('invoice/addnewinvoice');
        },

        addInvoiceMoney() {
            this.$router.push('invoice/addnewinvoiceMoney');
        },
        addInvoiceOthers() {
            this.$router.push('invoice/invoice-list-others');
        },
    },
}
</script>

<style>
.loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 120px;
    height: 120px;
    text-align: center;
    -webkit-animation: spin 2s linear infinite;
    /* Safari */
    animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
    }
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
