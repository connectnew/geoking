<template>
	<div class="row">

		<slot name="back"></slot>

		<div class="col-xl-6 col-lg-8 col-12 inquiry-form plr-90">

			<div class="row d-flex min-height-100 height-auto-mob align-items-center">
				<div class="col-12 text-center px-md-3 px-4">
					<h1 class="mt-4 mb-4">Tell us about your company</h1>
					<div class="clearfix d-blcok mt-3"></div>
					<div class="form-group input-group mb-4 float_lbl">
						<span class="has-float-label">
							<input type="text" class="form-control" id="login-email" name="company_name"
								   placeholder="Business name?" v-model="form.company_name"
								   :class="{'error-shadow': $v.form.company_name.$error}"/>
							<label class="control-label pb-0" for="login-email">Business name?
								<span class="text-danger">*</span>
							</label>
						</span>
					</div>
					<v-select
						:class="{'error-shadow': $v.form.country.$error, 'required-select': $v.form.country.$invalid || $v.form.country.$error}"
						label="name"
						class="form-control p-0 border-0 mb-4 custom-select-profile-country"
						v-model="checkedCountry"
						placeholder="Country"
						:options="countries">
						<template #search="{attributes, events}">
							<input
									class="vs__search"
									v-bind="attributes"
									autocomplete="new-username"
									v-on="events"
							/>
						</template>
					</v-select>
					<div class="form-group input-group mb-4 float_lbl">
						<span class="has-float-label">
							<vue-tel-input
							ref="telInput"
							id="tel-input"
							placeholder="Company telephone?" name="tel"
							v-model="form.company_phone"
							:class="{'error-shadow': $v.form.company_phone.$error || !phoneValid}"
							:mode="'international'"
							@onInput="onInput"></vue-tel-input>
							<!-- <input type="text" class="form-control" id="tel" name="tel" placeholder="Company telephone?"
								   v-model="form.company_phone"
								   :class="{'error-shadow': $v.form.company_phone.$error}"/> -->
							<!-- <label class="control-label pb-0" for="tel">Company telephone?<span
									class="text-danger">*</span></label> -->
						</span>
					</div>
					<div class="form-group input-group mb-4 float_lbl">
						<span class="has-float-label">
							<input type="text" class="form-control" id="address" name="address"
								   placeholder="Company address?" v-model="form.company_address"
								   :class="{'error-shadow': $v.form.company_address.$error}"/>
							<label class="control-label pb-0" for="address">Company address?<span
									class="text-danger">*</span></label>
						</span>
					</div>
					

					<v-select
						:class="{'error-shadow': $v.form.province.$error, 'required-select': $v.form.province.$invalid || $v.form.province.$error}"
						placeholder="Province"
						label="name"
						class="form-control mt-4 p-0 border-0 mb-4 no-after custom-select-profile-province"
						v-model="checkedProvince"
						:options="provinces">
						<template #search="{attributes, events}">
							<input
									class="vs__search"
									autocomplete="new-username"
									v-bind="attributes"
									v-on="events"
							/>
						</template>
					</v-select>

					<v-select
							:class="{'error-shadow': $v.form.city.$error, 'required-select': $v.form.city.$invalid || $v.form.city.$error}"
							placeholder="City"
							label="name"
							class="form-control mt-4 p-0 border-0 mb-4 no-after select-city"
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

					<div class="form-group input-group mb-4 float_lbl" v-show="emptyCitiesList">
						<span class="has-float-label">
							<input type="text" class="form-control" autocomplete="new-username" id="city" name="city" placeholder="City"
								   v-model="form.city" :class="{'error-shadow': $v.form.city.$error}"/>
							<label class="control-label pb-0" for="city">City<span class="text-danger">*</span></label>
						</span>
					</div>

					<div class="form-group input-group mb-4 float_lbl">
						<span class="has-float-label">
							<input type="text" class="form-control" id="postal_code" name="postal_code"
								   placeholder="Postal Code" v-model="form.postal_code"
								   :class="{'error-shadow': $v.form.postal_code.$error}"/>
							<label class="control-label pb-0" for="postal_code">Postal Code<span
									class="text-danger">*</span></label>
						</span>
					</div>

					<div class="form-group input-group mb-4 float_lbl">
						<span class="has-float-label">
							<input type="text" class="form-control" id="website" name="website"
								   placeholder="Company website?" v-model="form.company_website"/>
							<label class="control-label pb-0" for="website">Company website?</label>
						</span>
					</div>
				</div>

				<slot name="next"></slot>

			</div>

		</div>
		<div class="col-xl-3 col-lg-2 d-lg-block d-none col-2 blue-bg-col min-height-100"></div>
	</div>
</template>
<script>
	import {required} from 'vuelidate/lib/validators'
	import { VueTelInput } from 'vue-tel-input'
	import vSelect from "vue-select"

	export default {
		name: 'Step6',

		props: ['formProp'],

		components: {
			vSelect,
			VueTelInput
		},

		data() {
			return {
				phoneValid: true,

				emptyCitiesList: false,

				checkedCountry: '',
				checkedProvince: '',
				checkedCity: '',
				countries: [],
				provinces: [],
				cities: [],
				form: {
					company_name: '',
					company_phone: '',
					company_address: '',
					country: '',
					province: '',
					city: '',
					postal_code: ''
				},
				form_focuses: {
					country_vue_select_focused: false,
					province_vue_select_focused: false,
					city_vue_select_focused: false
				},
				// label_vs: 'Country'+"<span class=\"text-danger\"> * </span>"
			}
		},

		validations: {
			form: {
				company_name: {required},
				company_phone: {required},
				company_address: {required},
				city: {required},
				country: {required},
				province: {required},
				postal_code: {required},
			}
		},

		watch: {
			'checkedCountry'(val) {
				if (val) {
					this.$refs.telInput.choose(val.country)
					this.form.country = val.country

					axios.get('/api/geo/children/' + val.id)
						.then(response => {
							this.form.province = ''
							this.checkedProvince = ''

							this.provinces = response.data
						})
						.catch(error => {
							console.error(error.response.data.message)
						})

					axios.get('/api/geo/cities/' + val.country)
						.then(response => {
							this.form.city = ''
							this.checkedCity = ''

							this.emptyCitiesList = !response.data.length

							this.cities = response.data
						}).catch(error => {
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
				if (val) {
					this.form.province = val.name

				} else {
					this.form.province = ''
					this.checkedProvince = ''
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

		mounted() {
			$('#tel-input input').attr('id', 'ContactPhone')
			$('#tel-input input').attr('class', 'form-control')
			$('#tel-input').append( "<label class='control-label' for='ContactPhone'>Company telephone? <span class='text-danger'>*</span> </label>" )
		},


		methods: {
			onInput({ number, isValid, country }) {
	        this.phoneValid = isValid;
	      },
			onFocus(data) {
				this.$set(this.form_focuses, data + '_vue_select_focused', true);
			},
			onBlur(data) {
				this.$set(this.form_focuses, data + '_vue_select_focused', false);
			},
			validateStep() {
				this.$v.form.$touch();
				let isValid = !this.$v.form.$invalid;

				if (isValid && this.phoneValid) {
					this.$emit('get-params', this.form)
					this.$emit('change-step', 6)
				}
			}
		},

		created() {
			axios.get('/api/geo/countries')
				.then(response => {
					this.countries = response.data
				})
				.catch(error => {
					console.error(error.response.data.message)
				})


			let urlParams = new URLSearchParams(window.location.search);
			let myParam = urlParams.get('currentStep');
			if (myParam) {
				this.form = this.formProp
			}
		}
	}
</script>
<style>
	.has-float-label .form-control:placeholder-shown:not(:focus) + * {
		top: 54%;
	}
</style>
