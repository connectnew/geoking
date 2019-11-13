<template>
	<div class="modal fade" id="theAlert" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content reset__popup">
				<div class="modal-body">
					<h3 class="mb-3 font-weight-normal text-center py-5">Oauth token required. Please Connect your Google account.</h3>
					<div class="row">
						<div class="col-12 text-right">
							<a href="/integrations" class="btn btn-outline-light text-info border-0 font-16 text-uppercase" ref="redirectConnect">Connect</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import { Bus } from '../../bus.js'

	export default {
		name: 'TheAlert',

		props: [],

		data() {
			return {
				message: ''
			}
		},

		computed: {

		},

		mounted() {
			var self = this
			$('#theAlert').on('hidden.bs.modal', function (e) {
				self.$refs.redirectConnect.click()
			})

			Bus.$on('new-alert', data => {
				this.message = data
				$('#theAlert').modal('show')

				setTimeout(()=>{
					this.$refs.redirectConnect.click()
				},5000);
			})
		},

		methods: {

		},

		created() {

		}

	}
</script>