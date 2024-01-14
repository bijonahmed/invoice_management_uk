<template>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <Nav />
            <div class="page-content">
                <div class="alert-primary" role="alert">
                    <div class="row">
                        <div class="col-md-10">
                            New Live Post
                        </div>
                        <div class="col-md-2" style="text-align: right;">
                            <router-link to="/post/live-video-list"><i class="fa fa-arrow-left"
                                    aria-hidden="true"></i>Back</router-link>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form @submit.prevent="saveData()" id="formrest" class="forms-sample"
                                    enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="row mb-3">
                                                <label for="exampleInputUsername2"
                                                    class="col-sm-3 col-form-label">Model</label>
                                                <div class="col-sm-9">
                                                    <select name="user_id" v-model="cdata.user_id" class="form-select"
                                                        id="user_id" @change="getVideos(); scheduleList()">
                                                        <option value="">Select</option>
                                                        <option v-for='data in hostList' :value='data.id'>{{ data.name }} [ID:{{ data.id }}]</option>
                                                    </select>
                                                    <input type="hidden" v-model="cdata.post_id" name="post_id">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="exampleInputUsername2"
                                                    class="col-sm-3 col-form-label">Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control title" v-model="cdata.title"
                                                        id="title" name="title" placeholder="Title">
                                                    <span class="v-sub_category_name" style="color:red"></span>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="exampleInputUsername2"
                                                    class="col-sm-3 col-form-label">Description</label>
                                                <div class="col-sm-9">
                                                    <textarea type="text" class="form-control description"
                                                        v-model="cdata.description" id="description" name="description"
                                                        placeholder="Description"></textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <table id="datatable" class="table table-striped table-hover table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Post ID</th>
                                                            <th>File Name</th>
                                                            <th>Schedule Date Time</th>
                                                            <th>Durations</th>
                                                            <th>Count</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for='data in sc_list'>
                                                            <td>{{ data.post_id }}</td>
                                                            <td>{{ data.file_name }}</td>
                                                            <td>{{ data.schedule_date }}</td>
                                                            <td>{{ data.durations }}</td>
                                                            <td>{{ data.view_count }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row mb-4">
                                                <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Schedule
                                                    Datetime</label>
                                                <div class="col-sm-9">
                                                    <Datepicker v-model="date" :preview-format="format"
                                                        class="form-control datetime" />
                                                </div>
                                            </div>
                                            <!-- <div class="row mb-4">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Duration</label>
                                            <div class="col-sm-9">
                                                <input type="text" required="required" pattern="[0-9]{1,3}" class="form-control durations time" v-model="cdata.durations" id="durations" name="durations" placeholder="00" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onpaste="return false">
                                            </div>
                                        </div> -->
                                            <div class="row mb-4 d-none">
                                                <label for="exampleInputUsername2" class="col-sm-3 col-form-label">API
                                                    Source</label>
                                                <div class="col-sm-9">
                                                    <textarea type="url" class="form-control source" v-model="cdata.source"
                                                        id="source" name="source" placeholder="API Source"></textarea>
                                                    <!-- <Datepicker v-model="date" :preview-format="format" class="form-control datetime"/> -->
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="exampleInputMobile" class="col-sm-3 col-form-label">Video
                                                    Source</label>
                                                <div class="col-sm-9">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="spinner-border" role="status" style="display:none">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                    </div>
                                                    <select name="video_upload" v-model="cdata.video_upload"
                                                        class="form-select" id="video_upload" required>
                                                        <option value="">Select</option>
                                                        <option v-for="files in videofiles" :value="files.file_name">{{
                                                            files.file_name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="exampleInputMobile"
                                                    class="col-sm-3 col-form-label">Status</label>
                                                <div class="col-sm-9">
                                                    <select name="status" v-model="cdata.status" class="form-select">
                                                        <option value="1" selected>Publish</option>
                                                        <option value="0">Not Publish</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <button type="submit"
                                                    class="btn btn-primary me-2 w-100 submit_btn">Submit</button>
                                            </div>
                                            <!-- <div class="row mb-4">
                                            <label for="exampleInputMobile" class="col-sm-3 col-form-label">Thumbnail</label>
                                            <div class="col-sm-9">
                                                <input type="file" ref="thumbnail" @change="onFileSelectedThumbnail(); previewFile(this);" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" />
                                                <img id="previewImg" :src="`/examples/images/transparent.png`" alt="Preview">
                                            </div>
                                        </div>
                                         -->
                                        </div>
                                    </div>
                                </form>
                                <!-- sc_list -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    </div>
</template>
<script>
$(document).on("change", ".file_multi_video", function (evt) {
    var $source = $('#video_here');
    $source[0].src = URL.createObjectURL(this.files[0]);
    //  $source.parent()[0].load();
});
import {
    ref
} from 'vue';
import Datepicker from '@vuepic/vue-datepicker';
export default {
    setup() {
        const date = ref(new Date());
        const format = (date) => {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();
            return `Selected date is ${day}-${month}-${year}`;
        }
        return {
            date,
            format,
        }
    },
    data() {
        return {
            images: [],
            user_id: [],
            cdata: {
                post_id: '',
                thumbnail: '',
                time: '',
                datetime: '',
                source: '',
                title: '',
                description: '',
                durations: '',
                video_upload: '',
                user_id: '',
                status: 1,
            },
            hostList: [],
            sc_list: [],
            tiemFormat: [],
            videofiles: [],
        }
    },
    created() {
        this.getHost();
        this.timeFormat();
    },
    methods: {
        getVideos() {
            $(".spinner-border").show();
            let user_id = $("#user_id").val();
            axios.post(`/api/user/getfiles?user_id=${user_id}`).then((res) => {
                $(".spinner-border").hide();
                this.videofiles = res.data.data;
            });
        },
        scheduleList() {
            $(".spinner-border").show();
            let user_id = $("#user_id").val();
            axios.post(`/api/user/getScheduleList?user_id=${user_id}`).then((res) => {
                this.sc_list = res.data.data;
            });
        },
        onFileSelectedThumbnail() {
            this.thumbnail = this.$refs.thumbnail.files[0];
        },
        // onFileSelectedVideo() {
        //     this.video_upload = this.$refs.video_upload.files[0];
        // },
        previewFile(input) {
            var file = $("input[type=file]").get(0).files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function () {
                    $("#previewImg").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        },
        saveData() {
            let dateTime = new Date(this.date).toLocaleString();
            let schedule_time = new Date(this.date).toLocaleString('en-GB');
            schedule_time = schedule_time.slice(12);
            let schedule_date = new Date(this.date).toLocaleDateString();
            console.log(schedule_date);
            console.log(schedule_time);
            console.log(dateTime);
            $(".loadingvideo").show();
            const formData = new FormData();
            formData.append('datetime', dateTime);
            formData.append('schedule_time', schedule_time);
            formData.append('schedule_date', schedule_date);
            formData.append('source', this.cdata.source);
            formData.append('durations', this.cdata.durations);
            formData.append('user_id', this.cdata.user_id);
            formData.append('post_id', this.cdata.post_id);
            formData.append('thumbnail', this.thumbnail);
            formData.append('title', this.cdata.title);
            formData.append('description', this.cdata.description);
            formData.append('video_upload', this.cdata.video_upload);
            formData.append('status', this.cdata.status);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/post/livepostInsert',
                formData, {
                headers
            }).then((res) => {
                if (res.data.error) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: res.data.message,
                        showConfirmButton: false,
                        timer: 5000
                    });
                    // $(".datetime").val(res.data.schedule_date);
                    return;
                }
                $('#formrest')[0].reset();
                this.cdata.post_id = "";
                this.cdata.user_id = "";
                this.cdata.thumbnail = "";
                this.cdata.title = "";
                this.cdata.description = "";
                this.cdata.video_upload = "";
                this.cdata.source = "";
                this.cdata.durations = "";
                $(".loadingvideo").hide();
                //formrest
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Has been succesfully saved',
                    showConfirmButton: false,
                    timer: 1500
                })

                //live-video-list
                this.$router.push('/post/live-video-list');
                return false;

 
            });
        },
        getHost() {
            axios.get('/api/user/getActiveHostList').then(response => {
                this.hostList = response.data.data;
            });
        },
        timeFormat() {
            axios.get('/api/user/getTimeFormat').then(response => {
                this.tiemFormat = response.data.data;
            });
        },
    },
}
</script>
<style>#previewImg {
    width: 300px;
    height: 300px;
}</style>
