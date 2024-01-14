<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Log Activity List</div>
                </div>
            </div><br>
            <!-- <span class="loader"></span> -->
            <div class="row">
                <div class="col-md-2">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control frm_date" id="frm_date" v-model="frm_date" placeholder="From Date" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group mb-3">

                        <input type="text" class="form-control to_date" id="datepicker" placeholder="To Date" v-model="to_date" required>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="input-group mb-3">
                        <select class="form-select form-select-solid method">
                            <option value="">All Method</option>
                            <option value="GET">GET</option>
                            <option value="POST">POST</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <select class='form-control form-select user_id'>
                            <option value=''>Select Users</option>
                            <option v-for='data in userlist' :value='data.id'>{{ data.name }} [ID: {{ data.id }}]</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <button class="btn btn-primary w-100" @click="SearchData">Search</button>
                    </div>
                </div>
            </div>
            <!-- START DELETE MODAL -->
            <!-- Button trigger modal -->
             
            <!-- END DELETE MODAL -->
            <div class="col-md-12">
                <div class="table-responsive w-100">
                    <input type="hidden" class="user_id" v-model="user_id" />
                    <button class="btn btn-primary w-100 edit-mode" @click="editMMode" style="display: none;">Edit
                        Mode</button>
                    <table id="datatable" class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Created At</th>
                                <th>Browser History</th>
                                <th>URL</th>
                                <th>IP</th>
                                <th>Method</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import $ from "jquery";
import Datepicker from '../../components/Datepicker.vue';
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import datepickerFactory from 'jquery-datepicker';
import {
    useRouter
} from "vue-router"
import {
    useStore
} from 'vuex'
datepickerFactory($);
export default {
    setup() {
        const router = useRouter()
    },
    components: {
        Datepicker
    },
    data: function () {

        var date = new Date();
        var day = date.getDate();
        var date_ago = day - 5;
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;
        var t_date = year + "-" + month + "-" + day;
        var dateAgo = year + "-" + month + "-" + date_ago;

        return {
            users: [],
             frm_date: dateAgo,
            to_date: t_date,
            user_id: '',
            datatable: {},
            userlist: [],
        };
    },
    mounted() {
        this.defaultLoadingData();
        this.getUserList();
        $('.frm_date,.to_date').datepicker();
    },
    methods: {
        defaultLoadingData() {
            this.datatable = $('#datatable').DataTable({
                'processing': true,
                'serverSide': true,
                //  'destroy': true,
                'retrieve': true,
                'serverMethod': 'GET',
                'searching': false,
                'ajax': {
                    'url': `/api/user/getLogActivity`,
                    'data': function (data) {
                        let info = $('#datatable').DataTable().page.info();

                        data.page = info.page + 1;
                        var method = $('.method').val();
                        var user_id = $('.user_id').val();
                        var frm_date = $('.frm_date').val();
                        var to_date = $('.to_date').val();

                        //Append Data
                        data.user_id = user_id;
                        data.method = method;
                        data.frm_date = frm_date;
                        data.to_date = to_date;

                    },
                },
                'columns': [{
                        data: 'name'
                    },{
                        data: 'created_at'
                    },
                    {
                        data: 'agent'
                    },
                    {
                        data: 'url'
                    },
                    {
                        data: 'ip'
                    },
                    {
                        data: 'method'
                    }
                ],
            });
            let datatable = this.datatable;
            $('body').on('click', '.edit', function () {
                let id = $(this).attr('data-id');
                $(".user_id").val(id);
                $(".edit-mode").click();
            });

            $('.method').change(function () {
                datatable.draw();
            });
            $('.user_id').change(function () {
                datatable.draw();
            });

        },
        getUserList() {
            axios.get('/api/user/getUsersList').then(response => {
                this.userlist = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        },
        SearchData() {
            this.datatable.draw();
        },
         
    }
};
</script>
