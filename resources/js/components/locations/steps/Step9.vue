<template>
	<div>
		<h1 class="mb-2 position-relative">
			<a role="button" class="back-step position-absolute pointer" @click="$emit('change-step', 8)">
				<i class="fa fa-arrow-left"></i>
			</a>
			What contact details do you want to show to customers?
		</h1>

		<div class="map-section inquiry-form">
			<p class="mb-4">Help customers get in touch by including this info on your listing (optional) </p>

			<div class="row">
				<div class="col-md-1 col-6 form-group">
					<i class="fa fa-phone mt-2"></i>
				</div>

				<div class="col-md-11 col-12 form-group">
					<div class="form-group input-group input-with-icon mb-2">
						<span class="has-float-label">
							<vue-tel-input
							ref="telInput"
							v-model="form.phone"
							:disabledFetchingCountry="true"
							placeholder="Contact phone number"
							name="ContactPhone"
							id="tel-input"
							:mode="'international'"
							@onInput="onInput"></vue-tel-input>
							<!-- <input type="text" class="form-control" id="ContactPhone" name="ContactPhone" placeholder="Contact phone number " v-model="form.phone" /> -->
							<!-- <label class="control-label" for="ContactPhone">Contact phone number </label> -->
						</span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-1 col-1 form-group">
					<i class="fa fa-globe mt-2"></i>
				</div>

				<div class="col-md-11 col-12 form-group d-flex">
					<div class="custom-control custom-radio mt-1 mr-5">
						<input type="radio" class="custom-control-input" id="cwu" name="website" :value="2" v-model="form.website">
						<label class="custom-control-label custom-control-label-1" for="cwu"></label>
					</div>
			<!-- 	</div>

				<div class="col-md-9 col-11 form-group"> -->
					<div class="form-group input-group input-with-icon mb-2">
						<span class="has-float-label" @click="form.website = 2">
							<input type="text" class="form-control" id="CurrentWebsite" name="CurrentWebsite" placeholder="Current website URL" v-model="form.website_url" />
							<label class="control-label" for="CurrentWebsite">Current website URL</label>
						</span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-1 col-12 form-group"></div>
				<div class="col-md-11 col-12 form-group">
					<div class="d-block">
						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" id="Idont" name="website" :value="0" v-model="form.website">
							<label class="custom-control-label custom-control-label-1 pl-md-5 pl-0" for="Idont"> &nbsp;I don't need a website</label>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-1 col-12"></div>
				<div class="col-md-11 col-12">
					<div class="d-block">
						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" id="GetFree" name="website" :value="1" v-model="form.website">
							<label class="custom-control-label custom-control-label-1 pl-md-5 pl-0" for="GetFree"> &nbsp;Get a free website based on your info. <br>
								<a href="#!">See details</a>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>

		<button class="btn btn-submit mt-4" @click="validateStep">Next</button>

		<progress-bar :showStep="showStep"></progress-bar>
	</div>
</template>
<script>
	import { VueTelInput } from 'vue-tel-input'
	import { required } from 'vuelidate/lib/validators'

	export default {
		name: 'Step9',

		components: {
			VueTelInput
		},

		props: ['showStep', 'country', 'sendData'],

		data() {
			return {
				phoneValid: true,
				form: {
					website: 1,
					phone: '',
					website_url: ''
				}
			}
		},

		watch: {
			'form.website'(val) {
				if(val !== 2) {
					this.form.website_url = '' 
				}
			}
		},

		validations() {
			if (this.form.website == 2) {
				return {
					form: {
						phone: {
							required
						},
						website_url: {
							required
						}
					}
				}
			} else {
				return {
					form: {
						phone: {
							required
						}
					}
				}
			}
		},

		mounted() {
			this.$refs.telInput.choose(this.country)

			if(this.sendData.phone) {
				this.form.phone = this.sendData.phone
				this.form.website_url = this.sendData.website_url
				this.form.website = this.sendData.website
			}

			$('#tel-input input').attr('id', 'ContactPhone')
			$('#tel-input input').attr('class', 'form-control')
			$('#tel-input').append( "<label class='control-label' for='ContactPhone'>Contact phone number </label>" )
		},


		methods: {
			onInput({ number, isValid, country }) {
	        this.phoneValid = isValid;
	      },

			validateStep() {
				this.$v.form.$touch();
				let isValid = !this.$v.form.$invalid;

				if(isValid && this.phoneValid) {
					this.$emit('change-step', 10)
					this.$emit('get-params', this.form)
				}
			}
		}
	}
</script>