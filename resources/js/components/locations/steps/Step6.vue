<template>
	<div>
		<h1 class="mb-2 position-relative">
			<a role="button" class="back-step position-absolute pointer" @click="$emit('change-step', 5)">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
			</a>
			Do you also serve customers outside this location?
		</h1>

		<p class="mb-3">
			For example, if you visit or deliver to your customers, you can let them know where you are to go
		</p>

		<div class="map-section inquiry-form">
			<div class="d-block mb-3">
				<div class="custom-control custom-radio">
					<input type="radio" class="custom-control-input" id="customControlValidation1" name="serve_customers" v-model="form.serve_customers" :value="1">
					<label class="custom-control-label custom-control-label-1" for="customControlValidation1"> &nbsp;Yes, I also serve them outside my location</label>
				</div>
			</div>

			<div class="d-block">
				<div class="custom-control custom-radio">
					<input type="radio" class="custom-control-input" id="customControlValidation2" name="serve_customers" v-model="form.serve_customers" :value="0">
					<label class="custom-control-label custom-control-label-1" for="customControlValidation2"> &nbsp;No, I don't</label>
				</div>
			</div>
		</div>

		<button class="btn btn-submit mt-4" @click="validateStep">Next</button>

		<progress-bar :showStep="showStep"></progress-bar>
	</div>
</template>
<script>
	export default {
		name: 'Step6',

		props: ['showStep', 'sendData'],

		data() {
			return {
				form: {
					serve_customers: 1
				}
			}
		},

		methods: {
			validateStep() {
				if(this.form.serve_customers == 1) {
					this.$emit('change-step', 7)
				} else {
					this.$emit('change-step', 8)
				}
				this.$emit('get-params', this.form)
			}
		},

		created() {
			if(this.sendData.serve_customers == 0) {
				this.form.serve_customers = this.sendData.serve_customers
			}
		}
	}
</script>