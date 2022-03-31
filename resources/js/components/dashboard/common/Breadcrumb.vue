<template>
    <div class="jumbotron" data-pages="parallax">
        <div class=" container-fluid sm-p-l-0 sm-p-r-0">
            <div class="inner">
                <ol class="breadcrumb">
                    <li v-for="item in items" :key="item.index" class="breadcrumb-item">
                        <router-link :to="{name: item.link}">{{item.name}}</router-link>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'dashboard-breadcrumb',
    props: {
        items: {
            type: Array
        }
    }
}
</script>
