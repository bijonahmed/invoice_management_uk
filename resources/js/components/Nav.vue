<template>
    <nav class="navbar">
        <a href="#" class="sidebar-toggler">
            <i data-feather="menu"></i>
        </a>
        <div class="navbar-content">
            <form class="search-form">
                <div class="input-group">
                    <div class="input-group-text">
                        <i data-feather="search"></i>
                    </div>
                    <input type="text" class="form-control" id="navbarForm" placeholder="Search here..." />
                </div>
            </form>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-grid">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                    </a>
                    <div class="dropdown-menu p-0" aria-labelledby="appsDropdown">
                        <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
                            <p class="mb-0 fw-bold">Quick Acess</p>
                        </div>
                        <div class="row g-0 p-1">
                            <div class="col-3 text-center">
                                <router-link to="/customer/add-new-customer"
                                    class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-message-square icon-lg mb-1">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                    <p class="tx-12">Customer</p>
                                </router-link>
                            </div>
                            <div class="col-3 text-center">
                                <router-link to="/invoice/addnewinvoice"
                                    class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-message-square icon-lg mb-1">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                    <p class="tx-12">Invoice</p>
                                </router-link>
                            </div>
                            <div class="col-3 text-center">
                                <router-link to="/add-new-user"
                                    class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-message-square icon-lg mb-1">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                    <p class="tx-12">User</p>
                                </router-link>
                            </div>
                            <div class="col-3 text-center">
                                <router-link to="/my-profile"
                                    class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-instagram icon-lg mb-1">
                                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                    </svg>
                                    <p class="tx-12">Profile</p>
                                </router-link>
                            </div>
                            <div class="col-3 text-center">
                                <router-link to="/invoice/addnewinvoiceRefund"
                                    class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-instagram icon-lg mb-1">
                                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                    </svg>
                                    <p class="tx-12">Refund Invoice</p>
                                </router-link>
                            </div>
                        </div>
                        <!-- <div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
                            <a href="javascript:;">View all</a>
                        </div> -->
                    </div>
                </li>
               
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div v-if="user.empImg === null">
                            <img :src="require(`/backend/assets/images/blank_profile.png`)"
                                class="wd-30 ht-30 rounded-circle" alt="image"/> 
                        </div>
                        <div v-else>
                            <img :src="user.empImg" class="wd-30 ht-30 rounded-circle" />
                        </div>
                    </a>
                    <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                        <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                            <div class="mb-3">
                                <div v-if="user.empImg === null">
                                    <img :src="require(`/backend/assets/images/blank_profile.png`)"
                                        class="wd-30 ht-30 rounded-circle" alt="image"/>
                                </div>
                                <div v-else>
                                    <img :src="user.empImg" class="wd-80 ht-80 rounded-circle" />
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="tx-16 fw-bolder">{{ name }}</p>
                                <p class="tx-12 text-muted">{{ email }}</p>
                            </div>
                        </div>
                        <ul class="list-unstyled p-1">
                            <li class="dropdown-item py-2">
                                <router-link to="/my-profile" class="text-body ms-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-user me-2 icon-md">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <span>Profile</span>
                                </router-link>
                            </li>
                            <li class="dropdown-item py-2">
                                <router-link to="/changes-password" class="text-body ms-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-edit me-2 icon-md">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    <span>Change Password</span>
                                </router-link>
                            </li>
                            <li class="dropdown-item py-2">
                                <a href="javascript:;" class="text-body ms-0" @click="destroyLogout">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-log-out me-2 icon-md">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    <span>Log Out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>
<script>
// import face1 from '@/backend/assets/images/faces/face1.jpg'
// import face2 from '@/backend/assets/images/faces/face2.jpg'
// import face3 from '@/backend/assets/images/faces/face3.jpg'
// import face4 from '@/backend/assets/images/faces/face4.jpg'
// import face5 from '@/backend/assets/images/faces/face5.jpg'
// import face6 from '@/backend/assets/images/faces/face6.jpg'
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
            localStorage.removeItem('token');
            delete axios.defaults.headers.common['Authorization'];
            this.$router.push('/login');
        }
        return {
            logout
        }
    },
    data() {
        return {
            authUser: window.authUser,
            user: {
                name: "",
                email: "",
                empImg: ''
            },
        }
    },
    created() {
        if (authUser !== null) {
            this.email = authUser.email;
            this.name = authUser.name;
            this.user.empImg = authUser.image;
            console.log(this.email);
        }
    },
    methods: {
        destroyLogout() {
            this.logout();
            axios.post('/api/logout').then(response => {
                window.location.replace("/");
             
            }).catch(error => {
                router.push({
                    name: 'Login'
                })
            });
        },
        logoutModal() { }
    },
}
</script>
<style>
.modal-backdrop.fade.show {
    display: none;
}
</style>
