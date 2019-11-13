<template>
	<div class="row">
		<div class="col-12">
			<div class="bottom_icon" v-if="showStep > 7">
				<img src="/assets/images/scrutiny_icon.png" class="img-fluid" v-if="showStep == 8 || showStep == 10 || showStep == 11">
				<img src="/assets/images/phone_icon.png" class="img-fluid" v-if="showStep == 9">
			</div>
			<div class="white-rounded-box rounded-0 my-business-page page-min-height" style="background-image: url('/assets/images/buildings-bg.png'); background-position: bottom; background-repeat: repeat-x;">
				<div class="row justify-content-center">
					<div class="col-md-12 col-lg-4">
						
						<transition name="fade" mode="out-in">
							<component
							v-for="(item, index) in multiFormComponents"
							:key="index + 1"
							:is="item"
							v-if="showStep == index + 1"
							:center="center"
							:country="form.postal_address.country_code"
							:showStep="showStep"
							:backToMap="backToMap"
							:sendData="form"
							:disabled="disabled"
							@change-step="changeStep"
							@get-params="setParams"
							@get-position="getPosition">
							</component>
						</transition>

					</div>
				</div>
			</div>
		</div> 

		<!-- Error modal -->
		<div class="modal fade" id="error_modal" tabindex="-1" role="dialog" aria-labelledby="error_modal" aria-hidden="true">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					</div>
					<div class="modal-body">
						<div class="row inquiry-form flex-column">
							<p class="text-center mb-4">{{ errorMsg }}</p>
							<small class="mb-3 pl-4" v-for="item in errorDetails">{{ item }}</small>
						</div>
					</div>
					<div class="modal-footer flex-wrap">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
					</div>
				</div>
			</div>
		</div> 
	</div>
</template>
<script>
	import Step1 from './steps/Step1'
	import Step2 from './steps/Step2'
	import Step3 from './steps/Step3'
	import Step4 from './steps/Step4'
	import Step5 from './steps/Step5'
	import Step6 from './steps/Step6'
	import Step7 from './steps/Step7'
	import Step8 from './steps/Step8'
	import Step9 from './steps/Step9'
	import Step10 from './steps/Step10'
	import Step11 from './steps/Step11'
	Vue.component('progress-bar', require('./ProgressBar.vue').default);

	export default {
		name: 'CreateLocation',

		components: {
			Step1,
			Step2,
			Step3,
			Step4,
			Step5,
			Step6,
			Step7,
			Step8,
			Step9,
			Step10,
			Step11
		},

		props: [],

		data() {
			return {
				errorMsg: null,
				errorDetails: [],
				country: 'CA',
				disabled: false,
				multiFormComponents: ['Step1', 'Step2','Step3','Step4','Step5','Step6','Step7','Step8','Step9','Step10','Step11'],
				form: {
					postal_address: {
						country_code: 'CA'
					},
					website_url: '',
					name: '',
					category: {},
					places: [],
					exist_item: null,
					website: 1,
				},
				showStep: 1,
				backToMap: 6,
				center: {
					lat: 0,
					lng: 0
				}
			}
		},

		methods: {
			getPosition(position) {
				this.center = position
			},

			backMap(step) {
				this.backToMap = step
			},

			changeStep(step) {
				if(step == 11) {

					let data = JSON.parse(JSON.stringify(this.form));
					
					if(data.places && data.places.length == 0) {
						delete data.places
					}

					if(data.website !== 2) {
						data.website_url = null
					}

					delete data.exist_item
					delete data.website
					delete data.servecustomers
					delete data.show_google_map

					console.log(data)
					this.disabled = true
					axios.post('/api/v1/listing', data)
					.then(response => {
						this.showStep = step
						this.disabled = false
					})
					.catch(error => {
						try {
							let errorJSON = JSON.parse(error.response.data.message)
							this.errorMsg = errorJSON && errorJSON.error && errorJSON.error.message ? errorJSON.error.message : error.response.data.message
							this.errorDetails = []
							if(errorJSON && errorJSON.error && errorJSON.error.details)
							for (var i = 0; i < errorJSON.error.details.length; i++) {
								if(errorJSON.error.details[i].errorDetails) {
									for (var x = 0; x < errorJSON.error.details[i].errorDetails.length; x++) {
										let msg = errorJSON.error.details[i].errorDetails[x].field + ' - ' + errorJSON.error.details[i].errorDetails[x].message
										this.errorDetails.push(msg)
									}
								}
							}
							$('#error_modal').modal('show')
							this.disabled = false	
						} catch (e) {
							this.$set(this, 'errorMsg', error.response.data.message);
							$('#error_modal').modal('show')
							this.disabled = false
							return false;
						}
						this.disabled = false
					})
				} else {
					this.showStep = step
				}
			},

			setParams(data) {
				for (var prop in data) {
                this.form[prop] = data[prop]
            }

            if(data.lat || data.lng) {
            	this.$set(this.form, 'lat', data.lat)
            	this.$set(this.form, 'lng', data.lng)
            	this.center = {
						lat: data.lat,
						lng: data.lng
					}
            }
			}
		}
	}
</script>