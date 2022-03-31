<template>
    <div>
        <div class="card card-default mt-3 mb-0">
            <div class="card-header ">
                <div class="card-title">Product Orders</div>
            </div>
            <div class="card-body">
                <!-- <div class="d-flex">
                    <div class="ml-auto">
                        <button class="btn btn-primary" @click="addAgent"> <span class="fa fa-plus"></span> Add User</button>
                    </div>
                </div>
                <hr> -->
                <table id="productsTable" class="table table-striped table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">ID</th>
                            <th class="th-sm">Ref #</th>
                            <th class="th-sm">Catalog</th>
                            <th class="th-sm">Artist</th>
                            <th class="th-sm">Actual Image</th>
                            <th class="th-sm">Verse</th>
                            <th class="th-sm">Added Date</th>
                            <th class="th-sm text-center">Status</th>
                            <th class="th-sm text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="products">
                            <tr v-for="product in products" :key="product.id">
                                <!-- <td class="text-center"><img :src="'/storage/'+product.image" alt="" style="max-width: 50px;"></td> -->
                                <td class="">{{ product.id }}</td>
                                <td class="">{{ product.ref_num }}</td>
                                <td class="">{{ product.catalog_id }}</td>
                                <td class="">{{ product.artist_id }}</td>
                                <td class="">{{ product.actual_image }}</td>
                                <td class="">{{ product.verse }}</td>
                                <td class="">{{ product.date_added }}</td>
                                <td class="text-center">{{ (product.prototype)? 'Active' : 'Not Active'}}</td>
                                <td class="text-right">
                                    <!-- <a href="#" class="btn btn-sm btn-outline-success" @click.prevent="viewProduct(product.id)"><span class="fa fa-eye"></span></a> -->
                                    <a href="#" class="btn btn-sm btn-outline-success" @click.prevent="editUser(product.id)"><span class="fa fa-edit"></span></a>
                                    <a href="#" class="btn btn-sm btn-outline-danger" @click.prevent="removeUser(product.id)"><span class="fa fa-trash"></span></a>
                                </td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr>
                                <td colspan="5" class="text-center">
                                    No agents found
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Add agent modal -->
        <div class="modal fade" id="addAgent" tabindex="-1" role="dialog" aria-labelledby="addAgentLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <b>Add/Edit Agent</b>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-error mt-3" v-if="error">
                            {{ error }}
                        </div>
                        <form @submit.prevent="saveAgent('add-user-form')" class="p-t-15" data-vv-scope="add-user-form">

                            <div :class="{'form-group form-group-default': true, 'mb-0': errors.has('add-user-form.name') }">
                                <label>Name <span>*</span></label>
                                <div class="controls">
                                    <input v-validate="'required'" class="form-control" type="text" name="name" v-model="form.name" placeholder="User Full Name">
                                </div>
                            </div>
                            <span v-show="errors.has('add-user-form.name')" class="help is-danger">{{ errors.first('add-user-form.name') }}</span>

                            <div :class="{'form-group form-group-default': true, 'mb-0': errors.has('add-user-form.email') }">
                                <label>Email <span>*</span></label>
                                <div class="controls">
                                    <input v-validate="'required|email'" class="form-control" type="email" name="email" v-model="form.email" placeholder="Email Address">
                                </div>
                            </div>
                            <span v-show="errors.has('add-user-form.email')" class="help is-danger">{{ errors.first('add-user-form.email') }}</span>

                            <div :class="{'form-group form-group-default': true, 'mb-0': errors.has('add-user-form.role') }">
                                <label>User Role <span>*</span></label>
                                <select  v-validate="'required'" class="form-control" v-model="form.role" name="role">
                                    <option value="3">Artist</option>
                                    <option value="2">Marketing</option>
                                    <option value="4">Substrate</option>
                                    <option value="5">Laser</option>
                                    <option value="6">Sales</option>
                                </select>
                            </div>
                            <span v-show="errors.has('add-user-form.role')" class="help is-danger">{{ errors.first('add-user-form.role') }}</span>
                            
                            <button class="btn btn-primary btn-block btn-cons m-t-10" type="submit" v-if="!form.id">Save User Details</button>
                            <button class="btn btn-success btn-block btn-cons m-t-10" type="button" v-else @click.prevent="updateUser">Update User Details</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        name: 'admin-products',
        data() {
            return {
                error: null,
                form: {
                    id: null,
                    name: null,
                    email: null,
                    role: null,
                },
                agents: null
            }
        },
        methods: {
            addAgent() {
                this.error = null;
                this.form.id = null;
                this.form.name = null;
                this.form.email = null;
                this.form.role = null;
                this.errors.clear('add-user-form')
                $('#addAgent').modal('show');
            },
            saveAgent(scope) {
                this.$validator.validateAll(scope).then((result) => {
                    if (result) {
                        axios.post('/api/create-user', this.form)
                        .then((response) => {
                            console.log(response.data)
                            if(response.data == 'Success') {
                                toastr.success('New User Added!');
                                $('#addAgent').modal('hide')
                                this.$store.dispatch('dashboard/getUsers')
                            } else {
                                this.error = response.data;
                                this.form.id = null;
                                this.form.name = null;
                                this.form.email = null;
                                this.form.role = null;
                                this.errors.clear('add-user-form')                            
                            }
                        })
                    } 
                });
            },
            editUser(user_id) {
                if(user_id != 1) {
                    let user = this.users.find(x => x.id === user_id);
                    this.form.id = user.id;
                    this.form.name = user.name;
                    this.form.email = user.email;
                    this.form.role = user.role[0].id;
                    console.log(this.form);
                    $('#addAgent').modal('show');
                } else {
                    swal.fire(
                        'Not Allowed!',
                        'Cannot edit own record.',
                        'warning'
                    )
                }
            },
            updateUser() {
                axios.post('/api/update-user', this.form)
                .then((response) => {
                    console.log(response.data)
                    if(response.data == 'Success') {
                        toastr.success('User Updated!');
                        $('#addAgent').modal('hide')
                        this.$store.dispatch('dashboard/getUsers')
                    } 
                })
            },
            removeUser(id) {
                if(id != 1) {
                    swal.fire({
                        title: 'Remove this user?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                        if (result.value) {
                            axios.post('/api/remove-user', {id: id})
                            .then((response) => {
                                if(response.data == 'Success') {
                                    swal.fire(
                                        'Deleted!',
                                        'User has been deleted.',
                                        'success'
                                    )
                                    this.$store.dispatch('dashboard/getUsers')
                                } 
                            })
                        }
                    })
                } else {
                    swal.fire(
                        'Not Allowed!',
                        'Cannot delete own record.',
                        'warning'
                    )
                }
            }
        },
        computed: {
            ...mapGetters({
                products: 'dashboard/products'
            }),
            //  user_first_name: {
            //     get() { return (this.jobseeker)?this.jobseeker.first_name:null },
            //     set(user_first_name) { this.$store.commit('jobSeeker/updateJobSeeker', {first_name: user_first_name}) }
            // },
        },
        mounted() {
            this.$store.dispatch('dashboard/getProducts')
            setTimeout(function() {
                $('#productsTable').DataTable({
                    "scrollY": "400px",
                    "scrollCollapse": true,
                });
                $('.dataTables_length').addClass('bs-select');
            }, 500);
        }
    }
</script>
