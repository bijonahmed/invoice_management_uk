<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Live Streming</div>
                </div>
            </div><br>
            <!-- <span class="loader"></span> -->

            <div class="col-md-12">
                <a href="https://www.fansgame.online:8443/admin" target="_blank"><button>Video Server Admin</button></a>
            </div>
        </div>
    </div>
</div>
</template>

    
<script>
import $ from "jquery";

import {
    useRouter
} from "vue-router"

export default {
    setup() {
        const router = useRouter()
    },
    components: {
       
    },
    data: function () {

        return {
            cdata: {
                userid: "",

            },
            category_id: "",
            users: [],
            post_id: '',
            datatable: {},
            ulist: [],
        };

    },
    mounted() {
        this.default();
    },
    methods: {
        default () {



            
            // axios.get('/api/user/getLiveStreming').then(response => {
            // axios.get('/api/user/getLiveStreming').then(response => {
            //     //this.ulist = response.data.data;
            //     //https://127.0.0.1:8443/api/streams

            // });
        },

    }
};
</script>
