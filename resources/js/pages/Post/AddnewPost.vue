<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                New Post
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="saveData()" id="formrest" class="forms-sample" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border loadingvideo" role="status" style="display:none">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row mb-3">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Host</label>
                                            <div class="col-sm-9">
                                                <select name="user_id" v-model="cdata.user_id" class="form-select">
                                                    <option value="">Select</option>
                                                    <option v-for='data in hostlist' :value='data.id'>{{data.name}}</option>
                                                </select>
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
                                        <div class="row mb-3">
                                            <label for="exampleInputMobile" class="col-sm-3 col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <select name="status" v-model="cdata.status" class="form-select">
                                                    <option value="1" selected>Publish</option>
                                                    <option value="0">Not Publish</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- <div class="row mb-4">
                                            <label for="exampleInputMobile" class="col-sm-3 col-form-label">Thumbnail</label>
                                            <div class="col-sm-9">
                                                <input type="file" ref="thumbnail" @change="onFileSelectedThumbnail(); previewFile(this);" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" required />
                                                <img id="previewImg" :src="`/examples/images/transparent.png`" alt="Thumbnail Preview">
                                            </div>
                                        </div> -->
                                        <div class="row mb-3">
                                            <label for="exampleInputMobile" class="col-sm-3 col-form-label">Video</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control file_multi_video" required ref="video_upload" @change="onFileSelectedVideo();" id="video_upload" name="video_upload" accept="video/*" />
                                                <video width="320" height="240" controls id="video_here">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label>Category List:</label>
                                    <hr>
                                    <div class="col-md-2" v-for='data in ctegorylist'>
                                        <input type="checkbox" id="category_id" name="category_id" :value="data.category_id" v-model="category_id">{{ data.category_name }}
                                    </div>
                                    <hr>
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
export default {
    components: {
        // Nav,
        // Sidebar
    },
    data() {
        return {
            images: [],
            category_id: [],
            progress: 0,
            has_tag_id: [],
            cdata: {
                post_id: '',
                user_id: '',
                thumbnail: '',
                title: '',
                description: '',
                video_upload: '',
                status: 1,
            },
            ctegorylist: [],
            hostlist: [],
            hlist: [],
        }
    },
    created() {
        this.getCategoryList();
        this.getHasTag();
        this.hosterList();
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
        saveData() {
            $(".loadingvideo").show();
            let categoryId = this.category_id.join(',');
            //  let has_tag_id = this.has_tag_id.join(',');
            const formData = new FormData();
            formData.append('category_id', categoryId);
            //formData.append('has_tag_id', has_tag_id);
            formData.append('post_id', this.cdata.post_id);
            formData.append('user_id', this.cdata.user_id);
            formData.append('thumbnail', this.thumbnail);
            formData.append('title', this.cdata.title);
            formData.append('description', this.cdata.description);
            formData.append('video_upload', this.video_upload);
            formData.append('status', this.cdata.status);
            const headers = {
                'Content-Type': 'multipart/form-data'
            }
            axios.post('/api/post/postInsert',
                formData, {
                    headers
                }).then((res) => {
                $('#formrest')[0].reset();
                this.cdata.post_id = "";
                this.cdata.thumbnail = "";
                this.cdata.title = "";
                this.cdata.description = "";
                this.cdata.video_upload = "";
                $(".loadingvideo").hide();
                //formrest
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Has been succesfully saved',
                    showConfirmButton: false,
                    timer: 1500
                })
                return false;
            });
        },
        getCategoryList() {
            axios.get('/api/category/getCategoryList').then(response => {
                this.ctegorylist = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        },
        hosterList() {
            axios.get('/api/user/getActiveHostList').then(response => {
                this.hostlist = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        },
        getHasTag() {
            axios.get('/api/category/getHashTag').then(response => {
                this.hlist = response.data.data;
            }).catch(error => {
                //  console.log(error);
            });
        },
    },
}
</script>
<style>
#previewImg {
    width: 300px;
    height: 300px;
}
</style>
