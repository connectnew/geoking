<template>
	<div class="row add-location-form">
		<div class="col-12">
			<h1 class="mb-2 position-relative">
				<a role="button" class="back-step position-absolute pointer" @click="$emit('change-step', 2)">
					<i class="fa fa-arrow-left" aria-hidden="true"></i>
				</a>
				What's the address?
			</h1>
		</div>

		<div class="col-12 pt-4">
			<div class="row">
				<div class="col-1">
					<i class="fa fa-map-marker address-marker" aria-hidden="true"></i>
				</div>
				<div class="col-11">
					<v-select
					  :class="{'error-shadow': $v.form.country.$error, 'required-select': $v.form.country.$invalid || $v.form.country.$error}"
	              label="name"
	              class="form-control p-0 border-0 select-country"
	              v-model="checkedCountry"
	              placeholder="Country"
	              :options="countries">
		              	<template #search="{attributes, events}">
					       	<input
					       	class="vs__search"
					        	autocomplete="new-username"
					        	v-bind="attributes"
					        	v-on="events"/>
				         </template>
	              </v-select>

					<template v-if="backToMap == 6">
						<label class="p-relative w-100 mt-4 select-street" :class="{'error-shadow': $v.form.street.$error, 'required-select': $v.form.street.$invalid || $v.form.street.$error}">
							<input type="text" class="form-control" placeholder="Street address" v-model="form.street">	
						</label>

						<v-select
							:class="{'error-shadow': $v.form.city.$error, 'required-select': $v.form.city.$invalid || $v.form.city.$error}"
							placeholder="City"
							label="name"
							class="form-control mt-4 p-0 border-0 select-city"
							v-model="checkedCity"
							v-show="!emptyCitiesList"
							:options="cities">
							<template #search="{attributes, events}">
								<input
								class="vs__search"
								autocomplete="new-username"
								v-bind="attributes"
								v-on="events"
								/>
							</template>
						</v-select>
						<template v-if="emptyCitiesList">
							<label class="p-relative w-100 mt-4 select-city" :class="{'error-shadow': $v.form.city.$error, 'required-select': $v.form.city.$invalid || $v.form.city.$error}">
								<input type="text" class="form-control" placeholder="City" v-model="form.city">
							</label>
						</template>
						
						<label class="p-relative w-100 mt-4 select-postal_code">
							<input type="text" class="form-control" placeholder="Postal Code" v-model="form.postal_code" >
						</label>

						<v-select
		              label="name"
		              class="form-control mt-4 p-0 border-0 select-province"
		              v-model="checkedProvince"
		              placeholder="Province"
		              :options="provinces">
			              <template #search="{attributes, events}">
				              	<input
				              	class="vs__search"
				              	autocomplete="new-username"
				              	v-bind="attributes"
				              	v-on="events"/>
			              </template>
		              </v-select>
					</template>
				</div>
			</div>

			<button class="btn btn-submit mt-4" @click="validateStep">Next</button>

			<progress-bar :showStep="showStep"></progress-bar>
		</div>
	</div>
</template>
<script>
	import { required } from 'vuelidate/lib/validators'
	import vSelect from "vue-select";

	export default {
		name: 'Step3',

		components: {
			vSelect
		},

		props: ['showStep', 'backToMap', 'sendData'],

		data() {
			return {
				backInfo: true,
				emptyCitiesList: false,
				checkedCountry: '',
				checkedProvince: '',
				checkedCity: '',
				countries: [],
				provinces: [],
				cities: [],
				form: {
					country: '',
					province: '',
					city: ''
				}
			}
		},

		validations() {
			if (this.backToMap == 6) {
				return {
					form: {
						country: {
							required
						},
						street: {
							required
						},
						city: {
							required
						},
						// postal_code: {
						// 	required
						// },
						// province: {
						// 	required
						// },
					}
				}
			} else {
				return {
					form: {
						country: {
							required
						}
					}
				}
			}
		},

		watch: {
			'checkedCountry'(val) {
				if(val) {
					this.form.country = val.country

					axios.get('/api/geo/children/' + val.id)
					.then(response => {
						this.form.province = ''
						this.checkedProvince = ''
						this.provinces = response.data
						this.form.city = ''
						this.checkedCity = ''

						axios.get('/api/geo/cities/' + val.country)
						.then(response => {
							this.emptyCitiesList = !response.data.length

							this.cities = response.data

							if(this.sendData.postal_address.country_code && !this.backInfo) {
								for (var i = this.provinces.length - 1; i >= 0; i--) {
									if(this.provinces[i].name == this.sendData.postal_address.province) {
										this.checkedProvince = this.provinces[i]
									}
								}

								let validCity = false

								for (var i = this.cities.length - 1; i >= 0; i--) {
									if(this.cities[i].name == this.sendData.postal_address.city) {
										this.checkedCity = this.cities[i]
										validCity = true
									}
								}

								if(!validCity && this.sendData.postal_address.city) {
									this.form.city = this.sendData.postal_address.city
								}

								this.$set(this.form, 'street', this.sendData.postal_address.address)
								this.form.postal_code = this.sendData.postal_address.postal_code

								this.backInfo = true
								this.$v.form.$touch();
							}
						}).catch(error => {
							console.error(error.response.data.message)
						})
					})
					.catch(error => {
						console.error(error.response.data.message)		
					})

				} else {
					this.form.country = ''
					this.form.province = ''
					this.form.city = ''
					this.checkedProvince = ''
					this.checkedCity = ''
				}
			},

			'checkedProvince'(val) {
				if(val) {
					this.form.province = val.name

					let position = {
						lat: Number(val.lat),
						lng: Number(val.long)
					}
					this.$emit('get-position', position)
				} else {
					this.form.province = ''
				}
			},

			'checkedCity'(val) {
				if (val) {
					this.form.city = val.name
				} else {
					this.form.city = ''
					this.checkedCity = ''
				}
			}
		},

		methods: {
			validateStep() {
				this.$v.form.$touch();
				let isValid = !this.$v.form.$invalid;

				if(isValid) {
					let url = this.form.country + ', ' + this.form.city + ', ' + this.form.street
					axios.get('/api/v1/places/geocode/' + url)
					.then(response => {
						if(response.data.results.length > 0) {
							this.$emit('get-position', response.data.results[0].geometry.location)
						}
						// let result = response.data.predictions
						// if(result.length > 0) {
						// 	axios.get('/api/v1/places/' + result[0].place_id + '/details')
						// 	.then(responseDetails => {
						// 		this.$emit('get-position', responseDetails.data.result.geometry.location)
						// 	})
						// 	.catch(error => {
											
						// 	})
						// }
						this.$emit('change-step', 5)
						// if(this.backToMap == 6) {
						// 	this.$emit('change-step', 5)
						// } else {
						// 	this.$emit('change-step', 7)
						// }

						let data = {
							postal_address: {
								country_code: this.form.country,
								postal_code: this.form.postal_code,
								city: this.form.city,
								province: this.form.province,
								address: this.form.street
							}
						}
						this.$emit('get-params', data)
					})
					.catch(error => {
									
					})
				}
			}
		},

		created() {
			axios.get('/api/geo/countries')
			.then(response => {
				this.countries = response.data
				if(this.sendData.postal_address.address) {
					for (var i = 0; i < this.countries.length; i++) {

						if(this.countries[i].country == this.sendData.postal_address.country_code) {
							this.backInfo = false

							this.checkedCountry = this.countries[i]

							this.form.country = this.sendData.postal_address.country_code
						}
					}
				}
			})
			.catch(error => {
				console.error(error.response.data.message)		
			})
		}

	}
</script>