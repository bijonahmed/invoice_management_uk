<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                Edit Live Post
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="saveData()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row mb-3">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Host</label>
                                            <div class="col-sm-9">
                                                <select name="user_id" v-model="cdata.user_id" class="form-select">
                                                    <option value="">Select</option>
                                                    <option v-for='data in hostList' :value='data.id'>{{ data.name }}
                                                    </option>
                                                </select>
                                                <input type="hidden" v-model="cdata.post_id" name="post_id">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control title" v-model="cdata.title" id="title" name="title" placeholder="Title">
                                                <span class="v-sub_category_name" style="color:red"></span>
                                                <input type="hidden" v-model="cdata.post_id" name="post_id">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Description</label>
                                            <div class="col-sm-9">
                                                <textarea type="text" class="form-control description" v-model="cdata.description" id="description" name="description" placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                        <!-- <div class="row mb-3">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Schedular Time</label>
                                            <div class="col-sm-9">
                                                <Datepicker v-model="date" :preview-format="format" class="form-control"/>
                                            </div>
                                        </div> -->

                                    </div>
                                    <div class="col-sm-6">

                                        <div class="row mb-4">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label" style="color:red;"><b>Schedule Date</b></label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control schedule_date" v-model="cdata.schedule_date" id="schedule_date" name="schedule_date" placeholder="00:00:00">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label" style="color:red;"><b>Schedule Time</b></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control schedule_time" v-model="cdata.schedule_time" id="schedule_time" name="schedule_time" placeholder="00:00:00">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Duration</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control durations" v-model="cdata.durations" id="durations" name="durations" placeholder="00:00:00">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">API Source</label>
                                            <div class="col-sm-9">
                                                <textarea type="text" class="form-control source" v-model="cdata.source" id="source" name="source" placeholder="API Source"></textarea>
                                                <!-- <Datepicker v-model="date" :preview-format="format" class="form-control datetime"/> -->
                                            </div>
                                        </div>
                                        <div class="row mb-">
                                            <label for="exampleInputMobile" class="col-sm-3 col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <select name="status" v-model="cdata.status" class="form-select">
                                                    <option value="1" selected>Publish</option>
                                                    <option value="0">Not Publish</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="row mb-4">
                                            <label for="exampleInputMobile" class="col-sm-3 col-form-label">Thumbnail</label>
                                            <div class="col-sm-9">
                                                <input type="file" ref="thumbnail" @change="onFileSelectedThumbnail(); previewFile(this);" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" />
                                                <img id="previewImg" :src="`/examples/images/transparent.png`"
                                                        alt="Preview">
                                                <div v-if="cdata.thumbnail === null">
                                                    <img :src="`/backend/assets/images/blank_profile.png`" style="height:150px; width: 200px;" alt="image" />
                                                </div>
                                                <div v-else>
                                                    <img :src="cdata.thumbnail" style="height:150px; width: 200px;" />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <label for="exampleInputMobile" class="col-sm-3 col-form-label">Video</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control file_multi_video" ref="video_upload" @change="onFileSelectedVideo();" id="video_upload" name="video_upload" accept="video/*" />
                                                <video width="320" height="240" controls id="video_here">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary me-2 w-100 submit_btn">Submit</button>
                            </form>
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
        // In case of a range picker, you'll receive [Date, Date]
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
            category_id: [],
            has_tag_id: [],
            cdata: {
                category_id: "",
                post_id: '',
                thumbnail: '',
                schedule_date: '',
                schedule_time: '',
                title: '',
                source: '',
                durations: '',
                description: '',
                user_id: '',
                video_upload: '',
                status: 1,
            },
            ctegorylist: [],
            selectedCat: [],
            selectedhTag: [],
            hostList: [],
        }
    },
    created() {
        this.findRowId();
        this.getHost();
    },
    methods: {
        onFileSelectedThumbnail() {
            this.thumbnail = this.$refs.thumbnail.files[0];
        },
        onFileSelectedVideo() {
            this.video_upload = this.$refs.video_upload.files[0];
        },
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
        selectVideo(event) {
            document.getElementById("video_upload");
            let file = $("input[type=file]").get(0).files[0]; //event.target.files[0];
            let blobURL = URL.createObjectURL(file);
            document.querySelector("video").src = blobURL;
        },
        saveData() {

            

            let categoryId = this.category_id.join(',');
            const formData = new FormData();

            formData.append('schedule_date', this.cdata.schedule_date);
            formData.append('schedule_time', this.cdata.schedule_time);

            formData.append('category_id', categoryId);
            formData.append('post_id', this.cdata.post_id);
            formData.append('user_id', this.cdata.user_id);
            formData.append('durations', this.cdata.durations);
            formData.append('source', this.cdata.source);
            formData.append('thumbnail', this.thumbnail);
            formData.append('title', this.cdata.title);
            formData.append('description', this.cdata.description);
            formData.append('video_upload', this.video_upload);
            formData.append('status', this.cdata.status);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/post/postUpdateLive',
                formData, {
                    headers
                }).then((res) => {
                $('#formrest')[0].reset();
                this.cdata.post_id = "";
                this.cdata.thumbnail = "";
                this.cdata.title = "";
                this.cdata.source = "";
                this.cdata.description = "";
                this.cdata.video_upload = "";
                this.cdata.durations = "";

                //formrest
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Has been succesfully saved',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.$router.push('/post/live-video-list');
                return false;
            });
        },
        findRowId() {
            this.axios
                .get(`/api/post/editPostId/${this.$route.params.id}`)
                .then((response) => {
                    console.log(response.data.data.source);
                    //this.cdata.category_id = response.data.data.thumbnail;
                    this.cdata.post_id = response.data.data.post_id;
                    this.cdata.user_id = response.data.data.user_id;
                    this.cdata.thumbnail = response.data.data.thumbnail;
                    this.cdata.title = response.data.data.title;
                    this.cdata.durations = response.data.data.durations;

                    this.cdata.schedule_date = response.data.data.schedule_date;
                    this.cdata.schedule_time = response.data.data.schedule_time;

                    this.cdata.description = response.data.data.description;
                    this.cdata.source = response.data.data.source;
                    this.cdata.video_upload = response.data.data.video_upload;
                    this.cdata.status = response.data.data.status;
                });
        },
        getCategoryList() {
            axios.get('/api/category/getCategoryList').then(response => {
                this.ctegorylist = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        },
        selectedCategory() {
            axios.get(`/api/post/selectedCategoryList/${this.$route.params.id}`).then(response => {
                this.selectedCat = response.data.data;
            });
        },
        selectedHasTag() {
            axios.get(`/api/post/selectedHTagList/${this.$route.params.id}`).then(response => {
                this.selectedhTag = response.data.data;
            });
        },
        getHasTag() {
            axios.get('/api/category/getHashTag').then(response => {
                this.hlist = response.data.data;
            });
        },
        deleteCategory(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/api/post/categoryRemove?id=${id}`).then((res) => {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully delete record',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.selectedCategory();
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    });
                }
            })
        },
        getHost() {
            axios.get('/api/user/getActiveHostList').then(response => {
                this.hostList = response.data.data;
            });
        },
        deleteHtag(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/api/post/htagRemove?id=${id}`).then((res) => {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully delete record',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.selectedHasTag();
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    });
                }
            })
        }
    }
}
</script>

<style>
#previewImg {
    width: 300px;
    height: 300px;
}
</style>
