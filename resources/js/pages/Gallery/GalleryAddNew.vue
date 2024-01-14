<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">New</div>
                    <div class="col-md-2"><div align="right"><router-link class="nav-link" to="/gallery/hoster-gallery">Back</router-link></div></div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="saveData()" id="formrest" class="forms-sample" enctype="multipart/form-data">

                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border loadingvideo" role="status" style="display:none">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row mb-2">
                                        <label for="exampleInputUsername2" class="col-sm-2 col-form-label">Host</label>
                                        <div class="col-sm-10">
                                            <select name="user_id" v-model="cdata.user_id" class="form-select">
                                                <option value="">Select</option>
                                                <option v-for='data in hostList' :value='data.id'>{{ data.name }}
                                                </option>
                                            </select>
                                            <input type="hidden" v-model="cdata.post_id" name="post_id">
                                        </div>
                                    </div>

                                    <div class="row mb-12">
                                        <label for="exampleInputMobile" class="col-sm-2 col-form-label">Thumbnail</label>
                                        <div class="col-sm-10">
                                            <input type="file" ref="file" multiple class="form-control" id="files" accept="image/*" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-12 mt-2">
                                    <label for="exampleInputMobile" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select name="status" v-model="cdata.status" class="form-select">
                                            <option value="1" selected>Publish</option>
                                            <option value="0">Not Publish</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-2 me-2 w-100 submit_btn">Submit</button>
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
$(document).ready(function () {
    if (window.File && window.FileList && window.FileReader) {
        $("#files").on("change", function (e) {
            var files = e.target.files,
                filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
                var f = files[i]
                var fileReader = new FileReader();
                fileReader.onload = (function (e) {
                    var file = e.target;
                    $("<span class=\"pip\">" +
                        "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                        "<br/><span class=\"remove\">Remove</span>" +
                        "</span>").insertAfter("#files");
                    $(".remove").click(function () {
                        $(this).parent(".pip").remove();
                    });
                });
                fileReader.readAsDataURL(f);
            }
            console.log(files);
        });
    } else {
        alert("Your browser doesn't support to File API")
    }
});
 
export default {
    components: {
        // Nav,
        // Sidebar
    },
    data() {
        return {
            images: [],
            user_id: [],
            cdata: {
                user_id: '',
                file: '',
                file: '',
                status: 1,
            },
            hostList: [],
        }
    },
    created() {
        this.getHost();
    },
    methods: {

        saveData() {
            $(".loadingvideo").show();
            const formData = new FormData();

            for (var i = 0; i < this.$refs.file.files.length; i++) {
                let file = this.$refs.file.files[i];
                formData.append('files[' + i + ']', file);
            }

            formData.append('user_id', this.cdata.user_id);
            //   formData.append('thumbnail', this.thumbnail);
            formData.append('status', this.cdata.status);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/post/gallaryInsert',
                formData, {
                    headers
                }).then((res) => {
                $('#formrest')[0].reset();
                this.cdata.user_id = "";
                this.cdata.thumbnail = "";
                $(".loadingvideo").hide();
                //formrest
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Has been succesfully saved',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.$router.push('/gallery/hoster-gallery');
                return false;
            });
        },
        getHost() {
            axios.get('/api/user/getActiveHostList').then(response => {
                this.hostList = response.data.data;
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

input[type="file"] {
    display: block;
}

.imageThumb {
    max-height: 75px;
    border: 2px solid;
    padding: 1px;
    cursor: pointer;
}

.pip {
    display: inline-block;
    margin: 10px 10px 0 0;
}

.remove {
    display: block;
    background: #444;
    border: 1px solid black;
    color: white;
    text-align: center;
    cursor: pointer;
}

.remove:hover {
    background: white;
    color: black;
}
</style>
