<template>
    <router-view></router-view>
</template>

<script>
    export default {
        name: 'main-app',
        data() {
            return {
                metaTitle: this.$route.meta.metaTitle,
                metaTitleTemplate: '%s - Dashboard' 
            }
        },
        metaInfo() {
            return {
                title: this.$route.meta.metaTitle,
                titleTemplate: this.metaTitleTemplate,
                htmlAttrs: {
                    lang: 'en',
                    amp: true
                }
            }
        },
        components: {
            
        },
        computed: {

        },
        watch: {
            '$route' () {
                this.metaTitle = this.$route.meta.metaTitle;
            }
        }
    }
</script>