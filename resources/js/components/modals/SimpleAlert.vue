<template>
	<div class="modal" :id="id" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content reset__popup">
				<div class="modal-body">
					<h3 class="mb-3 font-weight-normal text-center" v-html="message"></h3>
					<template v-if="errors.length > 0">
						<p class="text-right">
							<a href="#collapse-all-errors" class="collapsed" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-all-errors">Learn more</a>
						</p>
						<div class="collapse collapse-errors" id="collapse-all-errors">
							<p v-for="error in errors" v-html="error"></p>
						</div>
					</template>
					<div class="row">
						<div class="col-12 text-right">
							<a role="button" class="btn btn-outline-light text-info border-0 font-16 text-uppercase" data-dismiss="modal">{{ this.button }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>

	export default {
		name: 'SimpleAlert',
		props: ['alert_id', 'alert_btn'],

		data() {
			return {
				id: this.alert_id ? this.alert_id : ('simple-alert-' + Math.floor(1+Math.random() * 10000)),
				message: 'Unknown error',
				errors: [],
				button: this.alert_btn ? this.alert_btn : 'Close',
			}
		},

		mounted() {
			this.$root.$on('showSimpleAlert', (message, errors) => {
				this.message = message ? message : 'Unknown error'
				this.errors = errors ? errors : []
				$('#' + this.id).modal("show")
			})
		}
	}
</script>