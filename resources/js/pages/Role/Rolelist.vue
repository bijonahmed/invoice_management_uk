<template>
<div class="main-wrapper">
    <div class="page-wrapper">
        <Nav />
        <div class="page-content">
            <div class="alert-primary" role="alert">
                <div class="row">
                    <div class="col-md-10">Role List</div>
                    <!-- <div class="col-md-2"><a href="javascript:void(0)" @click="modalOpen">
                        <span stye="text-align:center;">Add
                                New</span></a></div> -->
                </div>
            </div><br>
            <!-- <span class="loader"></span> -->
            <div class="d-flex justify-content-center" style="display: none;">
                <div class="spinner-border loader" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive w-100">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Remarks</th>
                                        <th>Status</th>
                                        <th>Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in rolelist" :key="item.role_id">
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.remarks }}</td>
                                        <td>
                                            <div v-if="(item.status == 1)">
                                                <span class="badge bg-success">Active</span>
                                            </div>
                                            <div v-else>
                                                <span class="badge bg-danger">Inactive</span>
                                            </div>
                                        </td>
                                        <td v-on:click="showData(item.role_id)"><i class="fas fa-edit"></i><a href="#">Edit</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="varyingModal" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form @submit.prevent="saveData()" id="userSubmitFrm" class="forms-sample" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="varyingModalLabel">Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="role_id" id="role_id" v-model="role.role_id" />
                        <label for="recipient-name" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="name" v-model="role.name">
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="form-label">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" v-model="role.remarks"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="form-label">Status</label>
                        <select class="form-select form-select-sm mb-3" name="status" v-model="role.status">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
</template>

<script>
import Nav from '../../components/Nav.vue';
import Sidebar from '../../components/Sidebar.vue';
export default {
    components: {
        Nav,
        Sidebar
    },
    data() {
        return {
            role: {
                role_id: '',
                name: '',
                remarks: '',
                status: '1',
            },
            rolelist: []
        }
    },
    created() {
        this.getRoleList();
    },
    methods: {
        modalOpen() {
            $('#userSubmitFrm')[0].reset();
            $('#varyingModal').modal('show')
        },

        showData(role_id) {
            axios.get('/api/user/role_check/' + role_id).then(response => {
                this.role.name = response.data.data.name;
                this.role.remarks = response.data.data.remarks;
                this.role.status = response.data.data.status;
                this.role.role_id = response.data.data.role_id;
            })

            $('#varyingModal').modal('show')

            //console.log(role_id);
        },
        saveData() {
            const formData = new FormData();
            formData.append('role_id', this.role.role_id);
            formData.append('name', this.role.name);
            formData.append('remarks', this.role.remarks);
            formData.append('status', this.role.status);
            const headers = {
                'Content-Type': 'multipart/form-data'
            };
            axios.post('/api/user/saveRole',
                formData, {
                    headers
                }).then((res) => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.getRoleList();
                $('#varyingModal').modal('hide')
                $('#userSubmitFrm')[0].reset();
              
                return false;
            });
        },
        getRoleList() {
            $(".loader").show();
            axios.get('/api/user/getRoleList').then(response => {
                this.rolelist = response.data.data;
                $(".loader").hide();
            }).catch(error => {
                //  console.log(error);
            });
        },
    },
}
</script>
