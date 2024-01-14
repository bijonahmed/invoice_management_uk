<template>
<body class="sidebar-dark">
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand">AMSystem</a>
            <div class="sidebar-toggler not-active">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="sidebar-body">
            <ul class="nav">
                <!-- <li class="nav-item nav-category">Main</li> -->
                <li class="nav-item">
                    <router-link class="nav-link" to="/dashboard">
                        <i class="fas fa-home"></i>&nbsp;Dashboard
                    </router-link>
                </li>
                <div v-if="(authUser.role_id == 2)">

                    <li class="nav-item">
                        <router-link class="nav-link" to="/customer/customer-list">
                            <i class="fa-solid fa-list"></i>&nbsp;Customer List
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/supplier/supplier-list">
                            <i class="fa-solid fa-list"></i>&nbsp;Supplier List
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/invoice/invoice-list">
                            <i class="fa-solid fa-list"></i>&nbsp;Travel Invoice
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link class="nav-link" to="/invoice/invoice-list-money-transfer">
                            <i class="fa-solid fa-user"></i>&nbsp;Invoice Money Transfer
                        </router-link>
                    </li>










                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI111cat1" role="button" aria-expanded="false" aria-controls="advancedUI">
                            <i class="link-icon" data-feather="anchor"></i>
                            <span class="link-title">Report</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="advancedUI111cat1">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/report/profit">Report</router-link>
                                </li>
                                <li class="nav-item d-none">
                                    <router-link class="nav-link" to="/report/due">Due</router-link>
                                </li>

                                <!-- <li class="nav-item">
                                    <router-link class="nav-link" to="/report/profit">Profit</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/report/due">Due</router-link>
                                </li> -->

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI111cat" role="button" aria-expanded="false" aria-controls="advancedUI">
                            <i class="link-icon" data-feather="anchor"></i>
                            <span class="link-title">Category Management</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="advancedUI111cat">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/category/category-list">Category</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/category/subcategory-list">Sub
                                        Category</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/category/in-subcategory-list">In
                                        Subcategory</router-link>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI1" role="button" aria-expanded="false" aria-controls="advancedUI">
                            <i class="link-icon" data-feather="anchor"></i>
                            <span class="link-title">User Management</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="advancedUI1">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/role-list">User Role</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/user-list">User</router-link>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI2" role="button" aria-expanded="false" aria-controls="advancedUI">
                            <i class="link-icon" data-feather="anchor"></i>
                            <span class="link-title">Setting</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="advancedUI2">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/bank/bank-list">Bank</router-link>
                                </li>
                                <!-- <li class="nav-item">
                                        <router-link class="nav-link" to="#">Frontend</router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link class="nav-link" to="#">Notification</router-link>
                                    </li> -->
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/log/log-activity">Log Activity</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/company-setting">Company Setting</router-link>
                                </li>
                            </ul>
                        </div>
                    </li>
                </div>
                <div v-if="(this.chkUsers.role_id == 3)">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/customer/customer-list">
                            <i class="fa-solid fa-user"></i>&nbsp;Customer List
                        </router-link>
                    </li>
                    <!-- <li class="nav-item">
                        <router-link class="nav-link" to="/supplier/supplier-due-amt-list">
                            <i class="fa-solid fa-list"></i>&nbsp;Supplier Due Amount
                        </router-link>
                    </li> -->

                    <li class="nav-item">
                        <router-link class="nav-link" to="/supplier/supplier-payment-list">
                            <i class="fa-solid fa-list"></i>&nbsp;Supplier Payment
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/invoice/invoice-list">
                            <i class="fa-solid fa-list"></i>&nbsp;Invoice Travel
                        </router-link>
                    </li>
                    <li class="nav-item">
                         <router-link class="nav-link" to="/invoice/addnewinvoiceRefund">
                            <i class="fa-solid fa-user"></i>&nbsp;Refund
                        </router-link>
                    </li>

                     <li class="nav-item">
                        <router-link class="nav-link" to="/invoice/invoice-refund">
                            <i class="fa-solid fa-user"></i>&nbsp;Refund List
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/invoice/invoice-list-money-transfer">
                            <i class="fa-solid fa-user"></i>&nbsp;Invoice Money Transfer
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link class="nav-link" to="/invoice/invoice-list-others">
                            <i class="fa-solid fa-user"></i>&nbsp;Others Invoice
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI111cat1" role="button" aria-expanded="false" aria-controls="advancedUI">
                            <i class="link-icon" data-feather="anchor"></i>
                            <span class="link-title">Report</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="advancedUI111cat1">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/report/profit">Report</router-link>
                                </li>
                                <li class="nav-item d-none">
                                    <router-link class="nav-link" to="/report/profit">Profit</router-link>
                                </li>
                                <li class="nav-item d-none">
                                    <router-link class="nav-link" to="/report/due">Due</router-link>
                                </li>

                            </ul>
                        </div>
                    </li>
                </div>

                <div v-if="(this.chkUsers.role_id == 6)">

                    <li class="nav-item">
                        <router-link class="nav-link" to="/member/member-list">
                            <i class="fa-solid fa-user"></i>&nbsp;Customer List
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/supplier/supplier-list">
                            <i class="fa-solid fa-list"></i>&nbsp;Supplier List
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/withdraw/withdraw-list">
                            <i class="fa-solid fa-list"></i>&nbsp;Invoice List
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/member/member-list">
                            <i class="fa-solid fa-user"></i>&nbsp;Activity Log
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link class="nav-link" to="/member/member-list">
                            <i class="fa-solid fa-user"></i>&nbsp;Report
                        </router-link>
                    </li>

                </div>
            </ul>
        </div>
    </nav>

     

</body>
</template>

<script>
export default {
    data() {
        return {
            authUser: window.authUser,
            chkUsers: "",

        }
    },
    created() {

        this.logInChk();
    },
    methods: {
        logInChk() {
            if (authUser !== null) {
                this.chkUsers = authUser;
                console.log("roleID:" + this.chkUsers.role_id);
            } else {
                //console.log("user empty");
                //window.location.replace("/login");
            }
        }
    },
};
</script>
