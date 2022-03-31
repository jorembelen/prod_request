<template>
    <div id="dashboard">
      	<sidemenu/>
		<div class="page-container">
			<headermenu/>
			<div class="page-content-wrapper">
				<div class="content">
					<!-- <breadcrumb :items="breadcrumbList"/> -->
					<div class="container-fluid sm-padding-10">
						<router-view></router-view>
					</div>
				</div>
				<!-- <div class="container-fluid footer">
					<div class="copyright sm-text-center">
						<p class="small no-margin pull-right sm-pull-reset">
							<a href="#">Hand-crafted</a>
							<span class="hint-text">by Company Name Here</span>
						</p>
						<div class="clearfix"></div>
					</div>
				</div> -->
			</div>
		</div>
    	<quickview/>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Sidemenu from './common/Sidemenu';
import Headermenu from './common/Headermenu';
import Quickview from './common/Quickview';
import Breadcrumb from './common/Breadcrumb';

export default {
	name: 'admin-dashboard',
	data() {
		return {
			breadcrumbList: this.$route.meta.breadcrumb
		}
	},
    components: {
        Sidemenu,
        Headermenu,
		Quickview,
		Breadcrumb
	},
	watch: {
		'$route' () {
			this.breadcrumbList = this.$route.meta.breadcrumb;
		}
	},
	computed: {
		...mapGetters('auth', {
			userDetails: 'userDetails'
		})
	},
	mounted() {
		this.$store.dispatch('auth/getUserDetails')
	}
}
</script>