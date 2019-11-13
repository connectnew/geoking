<template>
	<div>
		<h1 class="mb-2 position-relative">
			<a role="button" class="back-step position-absolute pointer" @click="$emit('change-step', 6)">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
			</a>
			Add the areas you serve (optional)
		</h1>

		<p class="mb-3">You can list your service areas below. They will show up on your listing and help bring relevant customers. </p>

		<div class="map-section inquiry-form">
			<div class="row mb-4">
				<div class="col-2 col-sm-1">
					<i class="fa fa-search mt-3" aria-hidden="true"></i>
				</div>

				<div class="col-10 col-sm-11 dropdown select--wrapper">
					<div class="form-group input-group input-with-icon mb-2">
						<span class="has-float-label">
							<input type="text" class="form-control" id="address" name="address" placeholder="Select areas" v-model="address" />
							<label class="control-label" for="address">Search and select areas</label>
						</span>
					</div>

					<p class="font-12"> you can change and add more later </p>

					<ul class="dropdown-menu custome-dropdown custom-autocomplete" :class="{'show': address && addressList.length > 0}" aria-labelledby="dLabel">
						<li v-for="item in addressList" @click="addAddress(item)">
							<!-- <p class="font-weight-bold m-0">{{ item.description }}</p> -->
							<p class="tagline">{{ item.description }}</p>
						</li>
					</ul>
				</div>

			</div>

			<div class="row mb-4" v-for="(address, index) in form.places">
				<div class="col-2 col-sm-1"></div>
				<div class="col-10 col-sm-11 d-flex align-items-center">
					<p class="mb-0">{{ address.description }}</p>
					<a role="button" class="pointer" @click="removeAddress(index)">
						<i class="fa fa-times pl-3"></i>
					</a>
				</div>
			</div>
		</div>

		<button class="btn btn-submit mt-4" @click="validateStep">Next</button>

		<progress-bar :showStep="showStep"></progress-bar>
	</div>
</template>
<script>
	export default {
		name: 'Step7',

		props: ['showStep', 'sendData'],

		data() {
			return {
				addressList: [],
				address: '',
				form: {
					places: [],
				}
			}
		},

		watch: {
			'address'(val) {
				if(val) {
					axios.get('/api/v1/places/search/' + val)
					.then(response => {
						this.addressList = response.data.predictions
					})
					.catch(error => {
									
					})
				}
			},
		},

		methods: {
			removeAddress(index) {
				this.form.places.splice(index, 1)
			},

			addAddress(item) {
				this.address = ''

				if(this.checkAddress(item)) {
					this.form.places.push(item)
				}
			},

			checkAddress(item) {
				for (var i = 0; i < this.form.places.length; i++) {
					if(this.form.places[i].description == item.description) {
						return false
					}
				}

				return true
			},

			validateStep() {
				this.$emit('change-step', 8)
				this.$emit('get-params', this.form)
			}
		},

		created() {
			if(this.sendData.places.length > 0) {
				this.form.places = this.sendData.places
			}
		}
	}
</script>