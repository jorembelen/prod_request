<template>
    <div>
        <div class="row">
            <div class="col-sm col-md-5">
                <div class="card card-default mt-3 mb-0">
                    <div class="card-header ">
                        <div class="card-title">Category</div>
                    </div>
                    <div class="card-body">
                        <!-- <div class="d-flex">
                            <div class="ml-auto">
                                <button class="btn btn-primary" @click="addCatalog"> <span class="fa fa-plus"></span> Add Catalog</button>
                            </div>
                        </div>
                        <hr> -->
                        <div class="input-group">
                            <input type="text" name="category" v-model="category" class="form-control" placeholder="Category Name">
                            <button class="btn btn-primary" @click="addCategory"><span class="fa fa-plus"></span> Category</button>
                        </div>
                        <hr>
                        <table id="categoryTable" class="table table-striped table-sm" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="th-sm">ID</th>
                                    <th class="th-sm">Category Name</th>
                                    <th class="th-sm">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="categories">
                                    <tr v-for="category in categories" :key="category.id">
                                        <!-- <td class="text-center"><img :src="'/storage/'+product.image" alt="" style="max-width: 50px;"></td> -->
                                        <td class="">{{ category.id }}</td>
                                        <td class="">{{ category.name }}</td>
                                        <td class="text-right">
                                            <a href="#" class="btn btn-sm btn-outline-success" @click.prevent="editCategory(category.id)"><span class="fa fa-edit"></span></a>
                                            <a href="#" class="btn btn-sm btn-outline-danger" @click.prevent="removeCategory(category.id)"><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            No categories found
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm col-md-7">
                <div class="card card-default mt-3 mb-0">
                    <div class="card-header ">
                        <div class="card-title">Catalogs</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="ml-auto">
                                <button class="btn btn-primary" @click="addCatalog"> <span class="fa fa-plus"></span> Add Catalog</button>
                            </div>
                        </div>
                        <hr>
                        <table id="productsTable" class="table table-striped table-sm" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="th-sm">ID</th>
                                    <th class="th-sm">Image</th>
                                    <th class="th-sm">Name</th>
                                    <th class="th-sm">PGDSKU</th>
                                    <th class="th-sm text-center">Category</th>
                                    <th class="th-sm text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="catalogs">
                                    <tr v-for="catalog in catalogs" :key="catalog.id">
                                        <!-- <td class="text-center"><img :src="'/storage/'+product.image" alt="" style="max-width: 50px;"></td> -->
                                        <td class="">{{ catalog.id }}</td>
                                        <td class="">
                                            <img :src="getImgUrlFromStorage(catalog.image)" alt="" style="width:80px;margin-bottom:10px;">
                                        </td>
                                        <td class="">{{ catalog.name }}</td>
                                        <td class="">{{ catalog.pgd_sku }}</td>
                                        <td class="text-center">{{ (catalog.category)? catalog.category.name : ''}}</td>
                                        <td class="text-right">
                                            <!-- <a href="#" class="btn btn-sm btn-outline-success" @click.prevent="viewProduct(product.id)"><span class="fa fa-eye"></span></a> -->
                                            <a href="#" class="btn btn-sm btn-outline-success" @click.prevent="editCatalog(catalog.id)"><span class="fa fa-edit"></span></a>
                                            <a href="#" class="btn btn-sm btn-outline-danger" @click.prevent="removeCatalog(catalog.id)"><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            No catalogs found
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add agent modal -->
        <div class="modal fade" id="addCatalog" tabindex="-1" role="dialog" aria-labelledby="addCatalogLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <b>Add/Edit Catalog</b>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-error mt-3" v-if="error">
                            {{ error }}
                        </div>
                        <form @submit.prevent="saveCatalog('add-catalog-form')" class="p-t-15" data-vv-scope="add-catalog-form">

                            <div class="form-group">
                                <label class="">Image <span>*</span></label>
                                <template v-if="imageUrls">
                                    <div class="row">
                                        <div class="col-sm col-md-6 offset-md-3" v-for="url in imageUrls" :key="url.id">
                                            <!-- <small class="text-center"><i><a href="#" @click.prevent="productRemoveFile(url)">Remove</a></i></small> -->
                                            <img :src="url" alt="" style="width:100%;margin-bottom:10px;">
                                        </div>
                                    </div>
                                </template>
                        
                                <input type="file" class="form-control-file" name="images[]" ref="image_file" id="image_file" @change="addImage()" required>
                            </div>

                            <div class="form-row">
                                <div class="col-sm">
                                    <div :class="{ 'form-group form-group-default': true, 'mb-0': errors.has('add-catalog-form.category') }">
                                        <label class="">Category <span>*</span></label>
                                        <select v-validate="'required'" class="full-width" name="category" v-model="form.category" data-placeholder="Select Category" data-init-plugin="select2" id="category" hidden>
                                            <template v-if="categories">
                                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                            </template>
                                        </select>
                                    </div>
                                    <span v-show="errors.has('add-catalog-form.category')" class="help is-danger">{{ errors.first('add-catalog-form.category') }}</span>
                                </div>
                            </div>

                            <div :class="{'form-group form-group-default': true, 'mb-0': errors.has('add-catalog-form.name') }">
                                <label>Name <span>*</span></label>
                                <div class="controls">
                                    <input v-validate="'required'" class="form-control" type="text" name="name" v-model="form.name" placeholder="Catalog Name">
                                </div>
                            </div>
                            <span v-show="errors.has('add-catalog-form.name')" class="help is-danger">{{ errors.first('add-catalog-form.name') }}</span>

                            <div :class="{'form-group form-group-default': true, 'mb-0': errors.has('add-catalog-form.pgdsku') }">
                                <label>PGD SKU <span>*</span></label>
                                <div class="controls">
                                    <input v-validate="'required'" class="form-control" type="text" name="pgdsku" v-model="form.pgdsku" placeholder="Catalog SKU">
                                </div>
                            </div>
                            <span v-show="errors.has('add-catalog-form.pgdsku')" class="help is-danger">{{ errors.first('add-catalog-form.pgdsku') }}</span>

                            <div :class="{'form-group form-group-default': true, 'mb-0': errors.has('add-catalog-form.description') }">
                                <label>Description <span>*</span></label>
                                <div class="controls">
                                    <textarea v-validate="'required'" class="form-control" type="text" name="description" v-model="form.description" placeholder="Description" style="height: 200px;"></textarea>
                                </div>
                            </div>
                            <span v-show="errors.has('add-catalog-form.description')" class="help is-danger">{{ errors.first('add-catalog-form.description') }}</span>
                            
                            <button class="btn btn-primary btn-block btn-cons m-t-10" type="submit" v-if="!form.id">Save Catalog</button>
                            <button class="btn btn-success btn-block btn-cons m-t-10" type="button" v-else @click.prevent="updateCatalog">Update Catalog</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import { bus } from '@/app'
    import generalMixins from '@/mixins'

    export default {
        name: 'admin-catalogs',
        mixins: [generalMixins],
        data() {
            return {
                error: null,
                form: {
                    id: null,
                    pgdsku: null,
                    name: null,
                    category: null,
                    description: null,
                    image: null
                },
                url: null,
                images: [],
                imageUrls: [],
                agents: null,
                category: null,
                category_id: null
            }
        },
        methods: {
            addCatalog() {
                this.errors.clear('add-catalog-form')
                $('#addCatalog').modal('show')
            },
            saveCatalog(scope) {
                this.$validator.validateAll(scope).then((result) => {
                    if (result) {
                        this.formData = new FormData();
                        this.formData.append('pgdsku', this.form.pgdsku);
                        this.formData.append('name', this.form.name);
                        this.formData.append('category_id', this.form.category);
                        this.formData.append('description', this.form.description);

                        for (var i = 0; i < this.images.length; i++) {
                            let attachment = this.images[i];
                            this.formData.append('images[]', attachment);
                        }

                        axios.post('/api/create-catalog', this.formData, {
                            headers: { 'Content-Type': 'multipart/form-data' }
                        })
                        .then((response) => {
                            console.log(response.data)
                            if(response.data == 'Success') {
                                if(this.reset()) {
                                    this.$store.dispatch('dashboard/getCatalogs')
                                    $('#addCatalog').modal('hide')
                                }
                            } else {
                                this.error = 'Error Saving Catalog'
                                this.reset()
                            }
                        })
                    } 
                });
            },
            addImage() {
                this.images = this.$refs.image_file.files;

                this.imageUrls = [];
                for (var i=0; i < this.images.length; i++){
                    this.imageUrls.push(URL.createObjectURL( this.images[i]));
                }
            },
            editCatalog(id) {
                let catalog = this.catalogs.find(x => x.id === id);
                this.form.id = catalog.id;
                this.form.name = catalog.name;
                this.form.pgdsku = catalog.pgd_sku;
                this.form.category = catalog.category_id;
                this.form.description = catalog.description;
                this.url = catalog.image;
                console.log(this.form);
                $('#addCatalog').modal('show');
            },
            removeCatalog() {

            },
            addCategory() {
                if(this.category_id) {
                    axios.post('/api/update-category', {id: this.category_id,category: this.category})
                    .then((response) => {
                        this.category = null
                        this.category_id = null
                        this.$store.dispatch('dashboard/getCategories')
                    })
                } else {
                    if(this.category) {
                        axios.post('/api/create-category', {category: this.category})
                        .then((response) => {
                            this.category = null
                            this.$store.dispatch('dashboard/getCategories')
                        })
                    }
                }
            },
            editCategory(id) {
                let category = this.categories.find(x => x.id === id);
                this.category = category.name
                this.category_id = id
            },
            removeCategory(id) {
                axios.post('/api/remove-category', {id: id})
                .then((response) => {
                    if(response.data == 'Success') {
                        swal.fire(
                            'Deleted!',
                            'Category has been deleted.',
                            'success'
                        )
                        this.$store.dispatch('dashboard/getCategories')
                    } 
                })
            },
            reset() {
                this.form.id = null
                this.form.pgdsku = null
                this.form.name = null
                this.form.category = null
                this.form.description = null
                this.form.image = null
                this.images = []
                this.imageUrls = []
                $("#image_file").val(null);
                return true;
            }
        },
        computed: {
            ...mapGetters({
                users: 'dashboard/users',
                categories: 'dashboard/categories',
                catalogs: 'dashboard/catalogs'
            }),
            //  user_first_name: {
            //     get() { return (this.jobseeker)?this.jobseeker.first_name:null },
            //     set(user_first_name) { this.$store.commit('jobSeeker/updateJobSeeker', {first_name: user_first_name}) }
            // },
        },
        created() {
            bus.$on('setCategory', (category) => {
                this.form.category = category;
            })
        },
        mounted() {
            this.$store.dispatch( 'dashboard/getUsers')
            this.$store.dispatch('dashboard/getCategories')
            this.$store.dispatch('dashboard/getCatalogs')
            setTimeout(function() {
               $('#productsTable').DataTable({
                    "scrollY": "400px",
                    "scrollCollapse": true,
                });
                 $('#categoryTable').DataTable({
                    "scrollY": "400px",
                    "scrollCollapse": true,
                });
                $('.dataTables_length').addClass('bs-select');
            }, 500);

            this.$nextTick(function () {
                 

                // Set option selected onchange
                $('#category').change(function(){
                    var value = $(this).val();
                    bus.$emit('setCategory', value);
                });

            });

        }
    }
</script>
