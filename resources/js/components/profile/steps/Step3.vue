<template>
	<div class="row">

		<slot name="back"></slot>

		<div class="col-xl-6 col-lg-8 col-12 inquiry-form plr-90">
			<div class="row d-flex min-height-100 height-auto-mob align-items-center">
				<div class="col-12 text-center px-md-3 px-4">
					<h1 class="mt-4 mb-4">Tell us about your location(s)</h1>

					<div class="clearfix d-blcok mt-3"></div>

					<div class="row">
						<div class="col-md-6 col-12 mb-3">
							<div class="row">
								<div class="col-sm-6 col-12 text-left pt-1"> Number of Locations </div>
								<div class="col-sm-6 col-12">
									<div class="select-sec revews-selectbox">
										<select class="form-control font-14" v-model="form.number_locations">
											<option value="" disabled>Please select</option>
											<option value="one_location">One location</option>
											<option value="up_to_9_locations">Up to 9 locations</option>
											<option value="10_and_more">10 and more</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="clearfix"></div>

					<div class="row mt-3 mb-5">
						<div class="col-sm-9 col-12 text-left pt_10-t">
							<span class="d-inline-block align-top mr-4">Are you locations verified on Google my business? </span>
							<span class="d-inline-block">
								<div class="inline-block float-left">
									<div class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" id="customControlValidation1" name="verified" :value="1" v-model="form.verified">
										<label class="custom-control-label custom-control-label-1" for="customControlValidation1"> &nbsp;Yes</label>
									</div>
								</div>
								<div class="inline-block float-left ml-3">
									<div class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" id="customControlValidation2" name="verified" :value="0" v-model="form.verified">
										<label class="custom-control-label custom-control-label-1" for="customControlValidation2"> &nbsp;No</label>
									</div>
								</div>
							</span>
						</div>
						<div class="col-sm-3 col-12 text-md-right text-center">
							<div class="inline-block my-sm-0 my-3"> <a href="#"><img src="/assets/images/verify-bth.png" class="img-fluid"></a> </div>
						</div>
					</div>

					<div class="row">
						<div class="col-12 text-left">
							<span class="d-inline-block">
								<span class="custom-control custom-checkbox inline-block float-left mr-3">
									<input type="checkbox" class="custom-control-input" id="ReviewScore" v-model="form.add_location">
									<label class="custom-control-label" for="ReviewScore">Add  business locations</label>
								</span>
								<div class="inline-block float-left">
									<div class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" id="customControlValidation3" name="location_type" value="single" v-model="form.location_type">
										<label class="custom-control-label custom-control-label-1" for="customControlValidation3"> &nbsp;Single Location</label>
									</div>
								</div>
								<div class="inline-block float-left ml-3">
									<div class="custom-control custom-radio">
										<input type="radio" class="custom-control-input" id="customControlValidation4" name="location_type" value="multi" v-model="form.location_type">
										<label class="custom-control-label custom-control-label-1" for="customControlValidation4"> &nbsp;Multi Locations</label>
									</div>
								</div>
							</span>
						</div>
					</div>
				</div>

				<slot name="next"></slot>

			</div>
		</div>
		<div class="col-xl-3 col-lg-2 d-lg-block d-none col-2 blue-bg-col min-height-100"></div>
	</div>
</template>
<script>
	export default {
		name: 'Step3',

		props: ['formProp'],

		data() {
			return {
				form: {
					number_locations: '',
					verified: 1,
					add_location: false,
					location_type: 'multi'
				}
			}
		},

		methods: {
			validateStep() {
				if(this.form.number_locations) {
					this.$emit('change-step', 4)
					this.$emit('get-params', this.form)
				}
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