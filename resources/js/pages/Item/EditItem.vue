<template>
    <div class="main-wrapper">
        <div class="page-wrapper">
            <Nav />
            <div class="page-content">
                <div class="alert-primary" role="alert">
                    Edit Item
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form @submit.prevent="saveData()" id="formrest" class="forms-sample"
                                    enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Item
                                            Name</label>
                                        <div class="col-sm-9">
                                            <input type="hidden" name="item_id" v-model="cdata.item_id" id="item_id" />
                                            <input type="text" class="form-control item_name" v-model="cdata.item_name"
                                                id="item_name" placeholder="Name" @keyup="checkName">
                                            <span class="v-item_name" style="color:red"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Unit
                                            Price</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control unit_price"
                                                v-model="cdata.unit_price" id="unit_price" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Unit</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control unit" v-model="cdata.unit" id="unit"
                                                placeholder="Unit">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <select name="status" v-model="cdata.status" class="form-select">
                                                <option value="1" selected>Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
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

export default {
    components: {

    },
    data() {
        return {
            cdata: {
                item_id: '',
                item_name: '',
                unit_price: '',
                unit: '',
                status: 1
            },
        }
    },
    created() {
        this.findRowId();
    },
    methods: {
        saveData() {
            const formData = new FormData();
            formData.append('item_id', this.cdata.item_id);
            formData.append('item_name', this.cdata.item_name);
            formData.append('unit_price', this.cdata.unit_price);
            formData.append('unit', this.cdata.unit);
            formData.append('status', this.cdata.status);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/item/saveItem',
                formData, {
                headers
            }).then((res) => {
                $('#formrest')[0].reset();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Data has been saved!',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.$router.push('/item/item-list');
                // return false;
            }).catch((error) => {
                $(".v-unit_price").html(error.response.data.errors.unit_price[0]);
                //$(".v-status").html(error.response.data.errors.status[0]);
            });
        }, checkName() {
            let item_name = $(".item_name").val();
            axios.post(`/api/item/checkItemName?item_name=${item_name}`).then((res) => {
                console.log(res.data.status);
                if (res.data.status == 1) {
                    $(".submit_btn").hide();
                    $(".v-item_name").html("This Item name is already exits");
                } else {
                    $(".submit_btn").show();
                    $(".v-item_name").html("");
                }
            });
        },
        findRowId() {
            this.axios
                .get(`/api/item/editItemId/${this.$route.params.id}`)
                .then((response) => {
                    this.cdata.item_id = response.data.data.item_id;
                    this.cdata.item_name = response.data.data.item_name;
                    this.cdata.unit_price = response.data.data.unit_price;
                    this.cdata.unit = response.data.data.unit;
                    this.cdata.status = response.data.data.status;
                });
        }
    }
}
</script>
