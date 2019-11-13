<template>
	<div>
		<!-- If chosen existing location -->
		<template v-if="sendData.exist_item">
			<h1 class="mb-2 position-relative">
				<a role="button" class="back-step position-absolute pointer" @click="$emit('change-step', 1)">
					<i class="fa fa-arrow-left" aria-hidden="true"></i>
				</a>
				This listing has already been claimed
			</h1>

			<div class="map-section inquiry-form">
				<p class="mt-4">This listing has already been verified.</p>

				<p class="mt-2">If you still want to add this listing to your account, you can request access from the current owner. <a href="#!">Learn more</a>.</p>

				<p class="mt-2">If you would like to update this listing's information on Google, you can also <a href="#!">report a problem</a>, which will be reviewed more quickly.</p>
			</div>

			<a href="#!" class="btn btn-submit mt-4">Request Access</a>
		</template>

		<!-- If New Location -->
		<template v-else>
			<h1 class="mb-2 position-relative">
				<a role="button" class="back-step position-absolute pointer" @click="$emit('change-step', 1)">
					<i class="fa fa-arrow-left" aria-hidden="true"></i>
				</a>
				Do you want to add a location customers can visit, like a store or office?
			</h1>

			<div class="map-section inquiry-form">
				<p class="mt-2">This location will show up on Google Maps and Search when 
				customers are looking for your business </p>

				<div class="d-block mb-3">
					<div class="custom-control custom-radio">
						<input type="radio" class="custom-control-input" id="Yes" name="show_google_map" :value="1" v-model="form.show_google_map">
						<label class="custom-control-label custom-control-label-1" for="Yes"> &nbsp;Yes </label>
					</div>
				</div>

				<div class="d-block mb-3">
					<div class="custom-control custom-radio">
						<input type="radio" class="custom-control-input" id="No" name="show_google_map" :value="0" v-model="form.show_google_map">
						<label class="custom-control-label custom-control-label-1" for="No"> &nbsp;No</label>
					</div>
				</div>
			</div>

			<button class="btn btn-submit mt-4" @click="validateStep">Next</button>

			<progress-bar :showStep="showStep"></progress-bar>
		</template>
	</div>
</template>
<script>
	export default {
		name: 'Step2',

		props: ['showStep', 'sendData'],

		data() {
			return {
				form: {
					show_google_map: 1
				}
			}
		},

		methods: {
			validateStep() {
				// if(this.form.show_google_map) {
				// 	// this.$emit('change-step', 3)
				// 	this.$emit('map-choice', 6)
				// } else {
				// 	// this.$emit('change-step', 8)
				// 	this.$emit('map-choice', 3)
				// }

				this.$emit('change-step', 3)

				this.$emit('get-params', this.form)
			}
		},

		created() {
			if(this.sendData.show_google_map) {
				this.form.show_google_map = this.sendData.show_google_map
			}
		}
	}
</script>