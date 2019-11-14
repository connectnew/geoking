/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// Libs
require('./bootstrap');

require('./dist/libs/perfect-scrollbar.jquery.min');
require('./dist/libs/sparkline');
require('./dist/waves');

// Custom
require('./dist/sidebarmenu');
require('./dist/custom.min');

window.Vue = require('vue');

import { Bus } from './bus.js';

import Vuelidate from 'vuelidate';
import * as VueGoogleMaps from 'vue2-google-maps';
import Clipboard from 'v-clipboard';

Vue.use(Clipboard);
Vue.use(Vuelidate);
Vue.use(VueGoogleMaps, {
  load: {
        key: process.env.MIX_GOOGLE_TOKEN,
        libraries: 'places', // This is required if you use the Autocomplete plugin
        // OR: libraries: 'places,drawing'
        // OR: libraries: 'places,drawing,visualization'
        // (as you require)
    },
  installComponents: true
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Layouts
Vue.component('the-header', require('./components/layouts/TheHeader.vue').default);
Vue.component('the-sidebar', require('./components/layouts/TheSidebar.vue').default);

// Listing
Vue.component('create-location', require('./components/locations/CreateLocation.vue').default);
Vue.component('manage', require('./components/locations/Manage.vue').default);
Vue.component('scan', require('./components/locations/Scan.vue').default);
Vue.component('scan-result', require('./components/locations/ScanResult.vue').default);
Vue.component('edit-location', require('./components/locations/EditLocation.vue').default);
Vue.component('location-analytics', require('./components/locations/Analytics.vue').default);

// Posts
Vue.component('manage-posts', require('./components/posts/ManagePosts.vue').default);

// Reviews
Vue.component('manage-reviews', require('./components/reviews/ManageReviews.vue').default);
Vue.component('generate-reviews', require('./components/reviews/GenerateReviews.vue').default);
Vue.component('promote-reviews', require('./components/reviews/PromoteReviews.vue').default);
Vue.component('smart-response', require('./components/reviews/SmartResponse.vue').default);
Vue.component('customize-widget', require('./components/reviews/CustomizeWidget.vue').default);
Vue.component('analytics-reviews', require('./components/reviews/AnalyticsReviews.vue').default);
Vue.component('review-reply-modal', require('./components/reviews/ReviewReplyModal.vue').default);

// Smart Response
Vue.component('manage-smart-response-modal', require('./components/reviews/smart/ManageModal.vue').default);
Vue.component('smart-response-modal', require('./components/reviews/smart/ResponseModal.vue').default);
Vue.component('vue-smart-layout-left', require('./components/reviews/smart/layout/Left.vue').default);
Vue.component('vue-smart-tab-paginate', require('./components/reviews/smart/tab/Paginate.vue').default);

// User
Vue.component('my-profile', require('./components/profile/MyProfile.vue').default);

// Settings
Vue.component('sources', require('./components/settings/Sources.vue').default);
Vue.component('add-many', require('./components/modals/AddMany.vue').default);

Vue.component('main-map', require('./components/dashboard/MainMap.vue').default);
Vue.component('the-alert', require('./components/modals/TheAlert.vue').default);
Vue.component('simple-alert', require('./components/modals/SimpleAlert.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',

    data() {
    	return {
    		paginationStyle: {
				infoClass: 'pull-left',
				wrapperClass: 'vuetable-pagination text-center',
				activeClass: 'btn btn-primary text-white',
				disabledClass: 'disabled',
				pageClass: 'btn btn-border',
				linkClass: 'btn btn-border',
				icons: {
					first: '',
					prev: '',
					next: '',
					last: '',
				}
			}
    	}
    },

    mounted() {
    	var self = this
	
		axios.interceptors.response.use(function (response) {
			return Promise.resolve(response);
		}, function (error) {
	   	if(error.response.status == 403 && error.response.message == 'Oauth token required. Please Connect your Google account.') {
	    		Bus.$emit('new-alert', error.response.message)
	   	}
	   	return Promise.reject(error);
		});
    }
});
