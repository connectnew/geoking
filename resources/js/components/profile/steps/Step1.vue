<template>
	<div class="row">
		<div class="col-md-3 d-md-block d-none blue-bg-col min-height-100"></div>

		<div class="col-md-6 welcome-screen">
			<div class="row min-height-100">
				<div class="col-md-10 offset-md-1 col-12 text-center min-height-100 d-flex align-items-center justify-content-center flex-wrap">
					<div class="d-block">
						<img src="/assets/images/logo-md.jpg">
						<div class="clearfix"></div>
						<h1>Welcome to GeoKing</h1>
						<h2>Please select your business type and complete your profile.</h2>
					</div>

					<div class="d-block w-100">
						<div class="row inquiry-form">
							<div class="col custom-control custom-radio border text-center welcome-radio px-3">
								<div class="welcome-img py-3"> <img src="/assets/images/one-location-icon.png"> </div>
								<div class="clearfix"></div>
								<input type="radio" class="custom-control-input" id="one-location" name="profile_type" value="one_location" v-model="form.type">
								<label class="custom-control-label custom-control-label-1 pb-5" for="one-location"> ONE-LOCATION<br>
								BUSINESS </label>
							</div>

							<div class="col custom-control custom-radio border text-center welcome-radio px-3">
								<div class="welcome-img py-3"> <img src="/assets/images/multi-location-icon.png"> </div>
								<div class="clearfix"></div>
								<input type="radio" class="custom-control-input" id="multi-location" name="profile_type" value="multi_location" v-model="form.type">
								<label class="custom-control-label custom-control-label-1 pb-5" for="multi-location"> MULTI-LOCATION<br>
								BUSINESS </label>
							</div>

							<div class="col custom-control custom-radio border text-center welcome-radio px-3">
								<div class="welcome-img py-3"> <img src="/assets/images/agency-icon.png"> </div>
								<div class="clearfix"></div>
								<input type="radio" class="custom-control-input" id="agency" name="profile_type" value="marketing" v-model="form.type">
								<label class="custom-control-label custom-control-label-1 pb-5" for="agency"> MARKETING<br>
								AGENCY </label>
							</div>
						</div>
					</div>

					<div class="d-block w-100 mt-3">
						<a role="button" class="btn getstarted-btn pointer" @click="validateStep">Get started</a> 
					</div>

				</div>
			</div>
		</div>
		<div class="col-md-3 d-md-block d-none blue-bg-col min-height-100"></div>
	</div>
</template>
<script>
	export default {
		name: 'Step1',

		props: ['formProp'],

		data() {
			return {
				form: {
					type: 'one_location'
				}
			}
		},

		methods: {
			validateStep() {
				this.$emit('get-params', this.form)
				this.$emit('change-step', 2)
			}
		},
		created() {
			let urlParams = new URLSearchParams(window.location.search);
			let myParam = urlParams.get('currentStep');
			if(myParam){
				this.form = this.formProp
			}
			
		}
	}
</script>