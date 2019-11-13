<template>
	<div>
		<h1 class="mb-2 position-relative">
			<a role="button" class="back-step position-absolute pointer" @click="$emit('change-step', 3)">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
			</a>
			Is this your business?
		</h1>

		<div class="map-section inquiry-form">
			<p class="mb-3">It looks like your business might already have a listing on Google Search or Maps. If you see your business below, select and we'll help improve your listing. </p>

			<div class="d-block mb-3 pb-3 border-bottom">
				<div class="custom-control custom-radio">
					<input type="radio" class="custom-control-input" id="Nivaran" name="already_exist" value="x" v-model="form.already_exist">
					<label class="custom-control-label custom-control-label-1" for="Nivaran"> &nbsp;<span class="text-black">Nivaran Pathology & Testing Centre</span><br>
						Badachand Ganj<br>
					0522 232 9060</label>
				</div>
			</div>

			<div class="d-block mb-3 pb-3 border-bottom">
				<div class="custom-control custom-radio">
					<input type="radio" class="custom-control-input" id="None" name="already_exist" :value="0" v-model="form.already_exist">
					<label class="custom-control-label custom-control-label-1" for="None"> &nbsp;<span class="text-black">None of these </span></label>
				</div>
			</div>
		</div>

		<button class="btn btn-submit mt-4" @click="validateStep">Next</button>

		<progress-bar :showStep="showStep"></progress-bar>
	</div>
</template>
<script>
	export default {
		name: 'Step4',

		props: ['showStep'],

		data() {
			return {
				form: {
					already_exist: 0
				}
			}
		},

		methods: {
			validateStep() {
				this.$emit('change-step', 5)
				this.$emit('get-params', this.form)
			}
		}
	}
</script>