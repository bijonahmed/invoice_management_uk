<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <form @submit.prevent="SearchData()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                <div class="alert-primary" role="alert" style="margin-bottom:10px;">
                    <div class="row">
                        <div class="col-md-8"> Filter Category Wise Video</div>
                        <div class="col-md-4 text-left"> <button type="submit" class="w-100"><i class="fa-solid fa-magnifying-glass"></i>Search</button></div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4" v-for='data in categorys'>
                        <input type="checkbox" id="cat_id" name="cat_id" :value="data.category_id" v-model="cat_id">{{data.category_name}}
                    </div>

                </div>
            </form>
            <div class="d-flex justify-content-center">
                <div class="spinner-border loadingvideo" role="status" style="display:none">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-2" v-for='data in videoList'>
                    <video v-bind:src="'https://test.futuregenit.com/' + data.video_upload" controls class="wd-100 wd-sm-150 me-3">Your browser does
                        not support the video tag.</video>
                    <router-link :to="`/edit-post/${data.post_id}`">
                        <center><i class="fa fa-thumbs-up" aria-hidden="true"></i>(1500)&nbsp;-&nbsp;[ID:{{ data.post_id }}]</center>
                    </router-link>
                </div>
            </div>

            <!-- row -->
        </div>
        <!-- Button trigger modal -->
        <Footer />
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
    data: function () {
        return {
            videoList: [],
            categorys: [],
            category_id: '',
            cat_id: []
        };
    },
    mounted() {
        this.getCategoryList();
    },
    methods: {
        getCategoryList() {
            axios.get('/api/category/getCategoryList').then(response => {
                this.categorys = response.data.data;
            });
        },
        SearchData() {
            $(".loadingvideo").show();
            const formData = new FormData();
            let catid = this.cat_id.join(',');
            console.log(catid);
            //cat_id
            formData.append('category_id', catid);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/post/featchVideo',
                formData, {
                    headers
                }).then((response) => {
                $(".loadingvideo").hide();
                this.videoList = response.data.data;
            });
        },
    }
};
</script>

<style>
video {
    width: 320px;
    -moz-border-radius: 40px;
    -webkit-border-radius: 40px;
    border-radius: 10px;
    overflow: hidden;
}
</style>
