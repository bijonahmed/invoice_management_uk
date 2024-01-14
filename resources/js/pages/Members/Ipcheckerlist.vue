<template>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <Nav />
            <div class="page-content">
                <div class="alert-primary" role="alert">
                    <div class="row">
                        <div class="col-md-10">IP Checker</div>
                        <div class="col-md-2"></div>
                    </div>
                </div><br>
                <div v-for="(errorArray, idx) in notifmsg" :key="idx">
                                                <div v-for="(allErrors, idx) in errorArray" :key="idx">
                                                    <span class="text-danger">{{ allErrors}} </span>
                                                </div>
                                        </div>        
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control ip" name="ip" placeholder="IP" >
                        </div>
                    </div>
    
                    <div class="col-md-2">
                        <div class="input-group mb-3">
                            <button class="btn btn-primary w-100" @click="filter">Search</button>
                        </div>
                    </div>
    
                     
                </div>
               
                <p class="iplist"></p>
            </div>
        </div>
    </div>
    </template>
    
    <script>
    import $ from "jquery";
    import Nav from '../../components/Nav.vue';
    import Sidebar from '../../components/Sidebar.vue';

    import {
        useRouter
    } from "vue-router"
    import {
        useStore
    } from 'vuex'

    export default {
        setup() {
            const router = useRouter()
        },
        components: {
            Nav,
            Sidebar,
        },
        data: function () {
  
            return {
                notifmsg: [],
                user_id: '',
                datatable: {},
                userslist: [],
    
            };
        },
        mounted() {
          
          
        },
        methods: {
            
            filter() {
                let ip = $(".ip").val();
                axios.post(`/api/member/searchIPfinder?ip=${ip}`).then((res) => {
                    console.log(res.data);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Loading....',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $(".iplist").html(res.data);
                    return false;

                }).catch(e => {
                this.notifmsg = e.response.data
            });
            },
            
    
        }
    };
    </script>
    