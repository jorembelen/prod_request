<template>
    <!-- START HEADER -->
    <div class="header ">
    <!-- START MOBILE SIDEBAR TOGGLE -->
    <a href="#" class="btn-link toggle-sidebar d-lg-none pg pg-menu" data-toggle="sidebar">
    </a>
    <!-- END MOBILE SIDEBAR TOGGLE -->
    <div class="">
        <div class="brand inline m-l-20">
            <img :src="getImgUrl('logo.png')" alt="logo" :data-src="getImgUrl('logo.png')" :data-src-retina="getImgUrl('logo.png')">
        </div>
        <!-- START NOTIFICATION LIST -->
        <ul class="d-lg-inline-block d-none notification-list m-l-25 d-lg-inline-block b-grey b-l no-style p-l-30 p-r-20">
            <li class="p-r-10 inline">
                <div class="dropdown">
                    <a href="javascript:;" id="notification-center" class="header-icon fa fa-bell" data-toggle="dropdown">
                        <span class="bubble"></span> <small class="font-heading">Notification</small>
                    </a>
                    <div class="dropdown-menu notification-toggle" role="menu" aria-labelledby="notification-center">
                        <div class="notification-panel">
                            <div class="notification-body scrollable">
                                <div class="notification-item  clearfix">
                                    <div class="heading">
                                        <a href="#" class="text-danger pull-left">
                                            <i class="fa fa-exclamation-triangle m-r-10"></i>
                                            <span class="bold">98% Server Load</span>
                                            <span class="fs-12 m-l-10">Take Action</span>
                                        </a>
                                        <span class="pull-right time">2 mins ago</span>
                                    </div>
                                    <div class="option">
                                        <a href="#" class="mark"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="d-flex align-items-center">
        <!-- START User Info-->
        <div class="pull-left p-r-10 fs-14 font-heading d-lg-block d-none">
            <span class="semi-bold">{{currentUser.name}}</span>
        </div>
        <div class="dropdown pull-right d-lg-block d-none">
            <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="thumbnail-wrapper d32 circular inline">
                    <img :src="getImgUrl('avatar.png')" alt="" :data-src="getImgUrl('avatar.png')" :data-src-retina="getImgUrl('avatar.png')" width="32" height="32">
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
                <a href="#" class="dropdown-item"><i class="pg-settings_small"></i> Settings</a>
                <a href="#" class="dropdown-item"><i class="pg-outdent"></i> Feedback</a>
                <a href="#" class="dropdown-item"><i class="pg-signals"></i> Help</a>
                <a href="#" @click.prevent="logout" class="clearfix bg-master-lighter dropdown-item">
                    <span class="pull-left">Logout</span>
                    <span class="pull-right"><i class="pg-power"></i></span>
                </a>
            </div>
        </div>
        <!-- END User Info-->
        <a href="#" class="header-icon pg pg-alt_menu btn-link m-l-10 sm-no-margin d-inline-block" data-toggle="quickview" data-toggle-element="#quickview"></a>
    </div>
    </div>
</template>

<script>
    import generalMixins from '@/mixins'
    import { mapGetters } from 'vuex'

    export default {
        name: 'dashboard-headermenu',
        mixins: [generalMixins],
        methods: {
            logout() {
                this.$store.dispatch('auth/logout')
            }
        },
        computed: {
            ...mapGetters('auth', {
                isLoggedIn: 'isLoggedIn',
                currentUser: 'currentUser'
            })
        }
    }
</script>
