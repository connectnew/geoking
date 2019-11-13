<template>
	<div>
		<h1 class="mb-2 position-relative">Thank you for creating your location!</h1>
		<!-- <p class="mb-3">
			In order to fully manage and represent this business on Google, you'll need to confirm that its yours.<br>
			Select how you'd like to get a verification code. <a href="#!">Learn more</a>
		</p> -->

		<!-- <div class="map-section inquiry-form">
			<div class="row">
				<div class="col-2 col-sm-1">
					<i class="fa fa-envelope mt-2" aria-hidden="true"></i>
				</div>

				<div class="col-10 col-sm-11">
					<p>
						<span class="text-black">Postcard by mail</span><br>
						Have a postcard with your code mailed to this address <br>
						<small class="text-danger">May take to 12 days to arrive</small>
					</p>

					<div class="row">
						<div class="col-md-5 col-sm-8 col-12 mb-2">
							<div class="form-group input-group input-with-icon mb-2">
								<span class="has-float-label">
									<input type="text" class="form-control" id="ContactName" name="ContactName" placeholder="Contact name" v-model="form.contactName" />
									<label class="control-label" for="ContactName">Contact name</label>
								</span>
							</div>
						</div>

						<div class="col-md-7 col-sm-4 col-12 text-left text-md-right mb-2">
							<button class="btn btn-submit px-3" @click="contact">Mail</button>
						</div>
					</div>

					<p class="my-4">
						<span class="text-black">{{ sendData.business_name }}</span><br>
						{{ sendData.province }}, {{ sendData.city }}, {{ sendData.street }} {{ sendData.pincode }}, {{ sendData.country }}
					</p>
				</div>
			</div>
		</div> -->
	</div>
</template>
<script>
	export default {
		name: 'Step11',

		props: ['sendData'],

		data() {
			return {
				form: {
					contactNameL: ''
				}
			}
		},
		
		methods: {
			contact() {

			}
		}
	}
</script>