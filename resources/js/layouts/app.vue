<template>
<div v-if="loginUser">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <Sidebar />
            <div id="kt_wrapper">
                <Toolbar />
                <Dashboard />
                <Acivity />
            </div>
        </div>
    </div>
</div>
<div v-else="loginUser !== ''">
</div>
<RouterView></RouterView>
</template>
<script>
import Dashboard from '../pages/Dashboard.vue';
export default {
    data() {
        return {
            authUser: window.authUser,
            loginUser: ""
        }
    },
    created() {
        this.logInChk();
    },
    methods: {
        logInChk() {
            if (authUser !== null) {
                this.loginUser = authUser;
            }
            console.log(authUser);
        }
    },
};
</script>
