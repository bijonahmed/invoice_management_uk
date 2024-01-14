<template>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <Nav />
            <div class="page-content">
                <div class="alert-primary" role="alert">
                    Edit Post
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
                                                    class="col-sm-3 col-form-label">Host</label>
                                                <div class="col-sm-9">
                                                    <select name="user_id" v-model="cdata.user_id"
                                                        class="form-select user_id">
                                                        <option value="">Select</option>
                                                        <option v-for='data in hostlist' :value='data.id'>{{
                                                            data.name
                                                        }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="exampleInputUsername2"
                                                    class="col-sm-3 col-form-label">Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control title" v-model="cdata.title"
                                                        id="title" name="title" placeholder="Title">
                                                    <span class="v-sub_category_name" style="color:red"></span>
                                                    <input type="hidden" v-model="cdata.post_id" name="post_id">
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
                                                <label for="exampleInputMobile"
                                                    class="col-sm-3 col-form-label">Status</label>
                                                <div class="col-sm-9">
                                                    <select name="status" v-model="cdata.status" class="form-select">
                                                        <option value="1">Publish</option>
                                                        <option value="0">Not Publish</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- <div class="row mb-4">
                                                <label for="exampleInputMobile"
                                                    class="col-sm-3 col-form-label">Thumbnail</label>
                                                <div class="col-sm-9">
                                                    <input type="file" ref="thumbnail"
                                                        @change="onFileSelectedThumbnail(); previewFile(this);"
                                                        class="form-control" id="thumbnail" name="thumbnail"
                                                        accept="image/*" />
                                                    <br>
                                                    <img id="previewImg"
                                                        :src="`/backend/assets/images/blank_profile.png`"
                                                        style="height:150px; width: 200px;" alt="Preview">
                                                    <br><br><br>
                                                    <img :src="cdata.thumbnail" style="height:150px; width: 200px;" />
                                                </div>
                                            </div> -->
                                            <div class="row mb-3">
                                                <label for="exampleInputMobile"
                                                    class="col-sm-3 col-form-label">Video</label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control file_multi_video"
                                                        ref="video_upload" @change="onFileSelectedVideo();"
                                                        id="video_upload" name="video_upload" accept="video/*" />
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
                                            <input type="checkbox" id="category_id" name="category_id"
                                                :value="data.category_id" v-model="category_id">{{ data.category_name }}
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="row">
                                        <label style="color: green;">Selected Category List:</label>
                                        <hr>
                                        <div class="col-md-2" v-for='data in selectedCat'>
                                            <i class="fa fa-trash" aria-hidden="true" style="color:red;"
                                                @click="deleteCategory(data.category_id)"></i>{{ data.category_name }}
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
                user_id: '',
                title: '',
                description: '',
                video_upload: '',
                status: '',
            },
            ctegorylist: [],
            hostlist: [],
            selectedCat: [],
            selectedhTag: [],
            hlist: [],
        }
    },
    created() {
        this.findRowId();
        this.getCategoryList();
        this.selectedCategory();
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
        selectVideo(event) {
            document.getElementById("video_upload");
            let file = $("input[type=file]").get(0).files[0]; //event.target.files[0];
            let blobURL = URL.createObjectURL(file);
            document.querySelector("video").src = blobURL;
        },
        saveData() {
            let categoryId = this.category_id.join(',');
            const formData = new FormData();
            formData.append('category_id', categoryId);
            formData.append('post_id', this.cdata.post_id);
            formData.append('user_id', this.cdata.user_id);
            formData.append('thumbnail', this.thumbnail);
            formData.append('title', this.cdata.title);
            formData.append('description', this.cdata.description);
            formData.append('video_upload', this.video_upload);
            formData.append('status', this.cdata.status);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/post/postUpdate',
                formData, {
                headers
            }).then((res) => {
                $('#formrest')[0].reset();
                this.cdata.post_id = "";
                this.cdata.thumbnail = "";
                this.cdata.title = "";
                this.cdata.description = "";
                this.cdata.video_upload = "";
                this.cdata.user_id = "";
                //formrest
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Has been succesfully saved',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.$router.push('/post/post-list');
                return false;
            });
        },
        findRowId() {
            this.axios
                .get(`/api/post/editPostId/${this.$route.params.id}`)
                .then((response) => {
                    this.cdata.post_id = response.data.data.post_id;
                    this.cdata.thumbnail = response.data.data.images;
                    this.cdata.title = response.data.data.title;
                    this.cdata.description = response.data.data.description;
                    this.cdata.video_upload = response.data.data.video_upload;
                    this.cdata.user_id = response.data.data.user_id;
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
        hosterList() {
            axios.get('/api/user/getActiveHostList').then(response => {
                this.hostlist = response.data.data;
            }).catch(error => {
                //  console.log(error);
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
    }
}
</script>
