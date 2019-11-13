<template>
	<div class="row">

		<slot name="back"></slot>

		<div class="col-xl-6 col-lg-8 col-12 inquiry-form plr-90">

			<div class="row d-flex min-height-100 height-auto-mob align-items-center">
				<div class="col-12  px-md-3 px-4">
					<h1 class="mt-4 mb-4 text-center">Connect your account</h1>
					<div class="clearfix d-blcok mt-3"></div>
					<div class="row mt-3">
						<div class="col-12">
							<div class="white-rounded-box">
								<div class="row m-lg-5 m-3">
									<div class="col-12">
										<div class="row">
											<div class="col-lg-2 col-md-3"> <img src="/assets/images/google-logo-lg.png" class="img-fluid"> </div>
											<div class="col-lg-7 col-md-5">
												<p class="font-16 gray_txt font-semi-bold">Connect your Google My Business account and start responding to Google reviews directly from within our platform.</p>
												<p class="font-16 font-italic gray_txt">Please note, the connected Google My Business account must be "owner" of single-GMB account and response ability is limited to post-connection activity.</p>
											</div>
											<div class="col-lg-3 col-md-4 text-center pt-4 mt-2">
											 <a v-if="!url.has('currentStep')" href="#" @click="saveSession"><img src="/assets/images/google-login-btn.png" class="img-fluid"></a>
											  <p v-else href="#" >Authorized</p>
											</div>
										</div>
										<hr class="my-5" style="border-top: 1px dashed #d6d6d7;">
										<div class="row">
											<div class="col-md-2"> <img src="/assets/images/icn-fb-logo-lg.png" class="img-fluid"> </div>
											<div class="col-md-7">
												<p class="font-16 gray_txt font-semi-bold">Connect your Facebook pages account and start responding to Facebook reviews directly from within our platform. Due to security updates by Facebook, integrating your Facebook account is the only way to pull in Facebook reviews and recommendations.</p>
												<p class="font-16 font-italic gray_txt">The connected Facebook account should be an Admin for your brand's page and have permissions to manage each location's business page.</p>
											</div>
											<div class="col-md-3 text-center pt-4 mt-2"> <a href="#"><img src="/assets/images/icn-fb-login-btn.png" class="img-fluid"></a> </div>
										</div>
										<!-- <hr class="my-5" style="border-top: 1px dashed #d6d6d7;">
										<div class="row">
											<div class="col-md-2 pt-4 mt-2"> <img src="/assets/images/booking_logo.png" class="img-fluid"> </div>
											<div class="col-md-7">
												<h3 class="font-16 font-semi-bold">Booking.com</h3>
												<p class="font-16 gray_txt font-semi-bold">Connect your Booking.com account and start responding to Google reviews directly from within our platform.</p>
												<p class="font-16 font-italic gray_txt">Please note, the connected Booking.com account must be "owner" of the-GMB account and response ability is limited to post-connection activity.</p>
											</div>
											<div class="col-md-3 text-center pt-4 mt-2"> <a href="#"><img src="/assets/images/login-with-booking.png" class="img-fluid"></a> </div>
										</div> -->
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

				<div class="col-12 text-center pb-4">
				<a role="button" @click="validateStep">
					<p>
						<button class="btn profile-btn continue-btn mb-0 px-2" style="margin-top: 18px !important;">Complete Profile</button>
					</p>
				</a>
			</div>

			</div>

		</div>
<!--		<div class="col-xl-3 col-lg-2 d-lg-block d-none col-2 blue-bg-col min-height-100"></div>-->
	</div>
</template>

<script>
	export default {
		name: 'Step7',
		props: ['formProp', 'currentStep'],
		data() {
			return {
				url: new URLSearchParams(window.location.search)
			}
		},
		methods: {
			validateStep() {
					this.$emit('get-params', this.formProp)
					this.$emit('change-step', 7)
			},
			saveSession() {
				let data = {
					form: this.formProp,
					currentStep: this.currentStep
				}
				axios.post('/save-data-session', data)
					.then(response => {
						window.location.href = '/integrations/oauth2/google-add'
					})
					.catch(error => {
						console.log(error.response.data.message)
					})
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
