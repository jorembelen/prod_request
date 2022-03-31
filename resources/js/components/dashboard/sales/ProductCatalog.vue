<template>
    <div>
        <div class="card card-default mt-3 mb-0">
            <div class="card-header ">
                <div class="card-title">Catalogs</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <template v-if="catalogs">
                        <div class="col-ms-6 col-md-2" v-for="catalog in catalogs" :key="catalog.id">
                            <div class="catalog-holder">
                                <img :src="getImgUrlFromStorage(catalog.image)" alt="" style="width:100%;margin-bottom:10px;">
                            </div>
                            <h5 class="semi-bold">{{ catalog.name }}({{catalog.pgd_sku}})</h5>
                        </div>
                    </template>
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
            
        },
        computed: {
            ...mapGetters({
                catalogs: 'dashboard/catalogs'
            }),
        },
        mounted() {
            this.$store.dispatch('dashboard/getCatalogs')
        }
    }
</script>
