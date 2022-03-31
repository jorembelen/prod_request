<template>
    <!-- BEGIN SIDEBPANEL-->
    <nav :class="(slug != 'job-seeker'? 'page-sidebar' : 'page-sidebar page-sidebar-2')" data-pages="sidebar">
		<!-- BEGIN SIDEBAR MENU HEADER-->
		<div class="sidebar-header">
			<div class="brand text-center">
				<img :src="getImgUrl('logo-white.png')" alt="logo-white" :data-src="getImgUrl('logo-white.png')" :data-src-retina="getImgUrl('logo-white-small.png')">
			</div>
		</div>
		<!-- END SIDEBAR MENU HEADER-->
		<!-- START SIDEBAR MENU -->
		<div class="sidebar-menu">
			<!-- BEGIN SIDEBAR MENU ITEMS-->
			
			<template v-if="slug == 'admin'">
				<ul class="menu-items">
					<li :class="(currentRoute == 'home')? 'm-t-30 active':'m-t-30'">
						<router-link :to="{ name: 'home' }"><span class="title">Home</span></router-link>
						<span class="icon-thumbnail"><i class="fa fa-home"></i></span>
					</li>
					<li :class="(currentRoute == 'admin-manage-users')? 'active':''">
						<router-link :to="{ name: 'admin-manage-users' }"><span class="title">Users</span></router-link>
						<span class="icon-thumbnail"><i class="fa fa-users"></i></span>
					</li>
					<li :class="(currentRoute == 'admin-catalogs')? 'active':''">
						<router-link :to="{ name: 'admin-catalogs' }"><span class="title">Catalog</span></router-link>
						<span class="icon-thumbnail"><i class="fa fa-tasks"></i></span>
					</li>
					<li :class="(currentRoute == 'admin-products')? 'active':''">
						<router-link :to="{ name: 'admin-products' }"><span class="title">Products</span></router-link>
						<span class="icon-thumbnail"><i class="fa fa-credit-card-alt"></i></span>
					</li>
				</ul>
			</template>
			<template v-if="slug == 'sales'">
				<ul class="menu-items">
					<li :class="(currentRoute == 'home')? 'm-t-30 active':'m-t-30'">
						<router-link :to="{ name: 'home' }"><span class="title">Home</span></router-link>
						<span class="icon-thumbnail"><i class="fa fa-home"></i></span>
					</li>
					<li :class="(currentRoute == 'sales-catalogs')? 'active':''">
						<router-link :to="{ name: 'sales-catalogs' }"><span class="title">Catalogs</span></router-link>
						<span class="icon-thumbnail"><i class="fa fa-users"></i></span>
					</li>
					<li :class="(currentRoute == 'sales-products')? 'active':''">
						<router-link :to="{ name: 'sales-products' }"><span class="title">Products</span></router-link>
						<span class="icon-thumbnail"><i class="fa fa-credit-card-alt"></i></span>
					</li>
				</ul>
			</template>
			<template v-if="slug == 'artist'">
				<ul class="menu-items">
					<li :class="(currentRoute == 'home')? 'm-t-30 active':'m-t-30'">
						<router-link :to="{ name: 'home' }"><span class="title">Home</span></router-link>
						<span class="icon-thumbnail"><i class="fa fa-home"></i></span>
					</li>
					<li :class="(currentRoute == 'artist-products')? 'active':''">
						<router-link :to="{ name: 'artist-products' }"><span class="title">Products</span></router-link>
						<span class="icon-thumbnail"><i class="fa fa-users"></i></span>
					</li>
				</ul>
			</template>
        	<div class="clearfix"></div>
      	</div>
      <!-- END SIDEBAR MENU -->
    </nav>
</template>

<script>
	import {mapGetters} from 'vuex'
    import generalMixins from '@/mixins'

    export default {
		name: 'dashboard-sidemenu',
		data() {
			return {
				currentRoute: this.$route.name
			}
		},
		mixins: [generalMixins],
		computed: {
			...mapGetters('auth', {
				slug: 'currentUserSlug'
			}),
		},
		watch: {
            '$route' () {
                this.currentRoute = this.$route.name;
            }
		}
    }
</script>
