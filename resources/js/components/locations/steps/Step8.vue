<template>
	<div>
		<h1 class="mb-2 position-relative">
			<a role="button" class="back-step position-absolute pointer" @click="$emit('change-step', sendData.serve_customers == 1 ? 7 : 6)">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
			</a>
			Choose the category that fits your business best
		</h1>

		<p class="mb-3">
			This helps customers find you if they are looking for a business like yours. <a href="#!">Learn more</a>
		</p>

		<div class="map-section inquiry-form">
			<div class="row">
				<div class="col-2 col-sm-1"><i class="fa fa-search mt-3" aria-hidden="true"></i></div>
				<div class="col-10 col-sm-11">

					<div class="dropdown select--wrapper">
						<button id="dLabel" class="select-value text-left fontSize--12 d-inline pull-left mr-1 max--w220" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @click="focusInput">
							<!-- <i class="fa fa-building" aria-hidden="true"></i> -->
							{{ form.primaryCategory ? form.primaryCategory : 'Business category' }}
						</button>
						<ul class="dropdown-menu custome-dropdown" aria-labelledby="dLabel">
							<li>
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Enter business name" aria-label="Enter business name" aria-describedby="basic-addon2"
									ref="nameInput"
									v-model="form.primaryCategory"
									@keyup.enter="$refs.closeBtn.click()">
									<div class="input-group-append">
										<button class="btn btn-outline-secondary" type="button" ref="closeBtn"><i class="fa fa-search" aria-hidden="true"></i></button>
									</div>
								</div>
							</li>
							<li v-for="item in categoriesList" @click="choseItem(item)">
								<p class="tagline">{{ item.displayName }}</p>
							</li>
						</ul>
					</div>



					<!-- <div class="form-group input-group input-with-icon mb-2">
						<span class="has-float-label">                                               
							<input type="text" class="form-control" id="primaryCategory" name="primaryCategory" placeholder="Type here" v-model="form.primaryCategory" />
							<label class="control-label" for="primaryCategory">Business category</label>
						</span> 
					</div>

					<p class="font-12">
						you can change and add more later
					</p>

					<ul class="dropdown-menu custome-dropdown custom-autocomplete"
					aria-labelledby="dLabel"
					:class="{'show': form.primaryCategory && categoriesList.length > 0 && checkList}">

						<li v-for="(item, index) in categoriesList" @click="form.primaryCategory = item.displayName">
							<p class="tagline px-2" :class="{'mt-3': index !== 0}">{{ item.displayName }}</p>
						</li>

					</ul> -->
				</div>
			</div>
		</div> 

		<button class="btn btn-submit mt-4" @click="validateStep">Next</button>

		<progress-bar :showStep="showStep"></progress-bar>
	</div>
</template>
<script>
	import { required } from 'vuelidate/lib/validators'

	export default {
		name: 'Step8',

		props: ['showStep', 'backToMap', 'sendData'],

		data() {
			return {
				list: [],
				form: {
					primaryCategory: ''
				}
			}
		},

		validations: {
			form: {
				primaryCategory: {
					required
				},
			}
		},

		watch: {
			'form.primaryCategory'(val) {
				if(val) {
					axios.get('/api/v1/categories/' + val)
					.then(response => {
						console.log(typeof response.data)
						if(response.data && response.data.length) {
							this.list = response.data
						} else {
							this.list = []
						}
					})
					.catch(error => {
									
					})
				}
			}
		},

		computed: {
			categoriesList() {
				if(this.list.length > 0) {
			      return this.list.filter((item) => {
			        return this.form.primaryCategory.toLowerCase().split(' ').every(v => item.displayName.toLowerCase().includes(v));
			      });
				}
		    }
		},

		methods: {
			choseItem(item) {
				this.form.primaryCategory = item.displayName
			},

			focusInput() {
				setTimeout(()=>{
					this.$refs.nameInput.focus()
				},200);
			},

			validateStep() {
				this.$v.form.$touch();
				let isValid = !this.$v.form.$invalid;

				if(isValid) {
					axios.get('/api/v1/categories/' + this.form.primaryCategory)
					.then(response => {
						for (var i = 0; i < response.data.length; i++) {
							if(response.data[i].displayName == this.form.primaryCategory) {
								let data = {
									category: {
										categoryId: response.data[i].categoryId,
										displayName: response.data[i].displayName
									}
								}
								this.$emit('change-step', 9)
								this.$emit('get-params', data)
							}
						}
					})
				}
			}
		},

		created() {
			if(this.sendData.category && this.sendData.category.categoryId) {
				this.form.primaryCategory = this.sendData.category.displayName
			}
		}

	}
</script>