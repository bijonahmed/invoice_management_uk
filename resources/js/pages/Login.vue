<template>
<div class="page-content d-flex align-items-center justify-content-center">
    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
            <div class="card">
                <div class="row">
                    <div class="col-md-4 pe-md-0">
                        <div class="auth-side-wrapper">
                        </div>
                    </div>
                    <div class="col-md-8 ps-md-0">
                        <div class="auth-form-wrapper px-4 py-5">
                            <center>
                                <a href="#" class="noble-ui-logo d-block mb-2">
                                    <p v-if="error" style="color: red;">{{ error }}</p><span>Account Management</span>
                                </a>

                                <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your account.</h5>

                                <img :src="`/company_logo.jpg`" class="img img-thumbnail" style="height:100px;">

                            </center>
                            <form class="forms-sample" @submit.prevent="login">
                                <div class="mb-3">
                                    <label for="userEmail" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" v-model="form.email" placeholder="Email">
                                </div>
                                <div class="mb-3">
                                    <label for="userPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" v-model="form.password" autocomplete="current-password" placeholder="Password">
                                </div>
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="authCheck">
                                    <label class="form-check-label" for="authCheck">
                                        Remember me
                                    </label>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {

            form: {
                email: '',
                password: ''
            }
        };
    },
    methods: {
        login() {
            axios.post('/api/login', this.form)
                .then(response => {
                    const token = response.data.token;
                    localStorage.setItem('token', token);
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                    this.$router.push('/dashboard');
                    window.location.replace("/dashboard");
                    //             this.$router.push('/item/item-list');
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
};
/*
import { reactive,ref } from 'vue' 
import { useRouter} from "vue-router"

import { useStore } from 'vuex'
import $ from "jquery";

export default {
    setup() {
        const router = useRouter()
        const store = useStore()
        let form = reactive({
            email: '',
            password: ''
        });

        let error = ref('')
        const login = async () => {
            await axios.post('/api/login', form).then(res => {
                if (res.data.success) {
                    console.log("login working....");
                    store.dispatch('setToken', res.data.data.token);
                    window.location.replace("/dashboard");
                } else {
                    error.value = res.data.message;
                }
            })
        }
        return {
            form,
            login,
            //logout,
            error
        }
    },
    created() {
        // this.logout();
    }
}
*/
</script>

<style>
.auth-page .auth-side-wrapper {
    width: 100%;
    height: 100%;
    background-image: url(/backend/assets/images/photos/img6.jpg);
    background-size: cover;
}
</style>
