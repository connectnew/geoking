<template>
	<div>
		<h1 class="mb-4">What's the name of your business?</h1>

		<div class="dropdown select--wrapper">
			<button id="dLabel" class="select-value text-left fontSize--12 d-inline pull-left mr-1 max--w220" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @click="focusInput">
				<i class="fa fa-building" aria-hidden="true"></i>
				{{ form.business_name ? form.business_name : 'Business Name' }}
			</button>
			<ul class="dropdown-menu custome-dropdown" aria-labelledby="dLabel">
				<li>
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Enter business name" aria-label="Enter business name" aria-describedby="basic-addon2"
						ref="nameInput"
						v-model="form.business_name"
						@keyup.enter="$refs.closeBtn.click()">
						<div class="input-group-append">
							<button class="btn btn-outline-secondary" type="button" ref="closeBtn"><i class="fa fa-search" aria-hidden="true"></i></button>
						</div>
					</div>
				</li>
				<li v-for="item in filteredList" @click="choseItem(item)">
					<p class="font-weight-bold m-0">{{ item.structured_formatting.main_text }}</p>
					<p class="tagline">{{ item.description }}</p>
				</li>
			</ul>
		</div>

		<p class="mt-4">By continuing you agree to the following <a href="#">Terms of Services</a> and <a href="#">Privacy Policy</a>.</p>

		<p>
			<button class="btn btn-submit" @click="validateStep">Next</button>
		</p> 

		<progress-bar :showStep="showStep"></progress-bar>
	</div>
</template>
<script>
	export default {
		name: 'Step1',

		props: ['showStep', 'sendData'],

		data() {
			return {
				form: {
					business_name: '',
					exist_item: null
				},
				list: []
			}
		},

		watch: {
			'form.business_name'(val) {
				if(val) {
					axios.get('/api/v1/businesses/search/' + val)
					.then(response => {
						this.list = response.data.predictions
					})
					.catch(error => {
									
					})
				}
			},
		},

		computed: {
			filteredList() {
		      return this.list.filter((item) => {
		        return this.form.business_name.toLowerCase().split(' ').every(v => item.structured_formatting.main_text.toLowerCase().includes(v));
		      });
		    }
		},

		methods: {
			choseItem(item) {
				this.form.business_name = item.structured_formatting.main_text
			},

			focusInput() {
				setTimeout(()=>{
					this.$refs.nameInput.focus()
				},200);
			},

			validateStep() {
				if(this.form.business_name) {

					this.form.exist_item = null

					axios.get('/api/v1/businesses/search/' + this.form.business_name)
					.then(response => {
						let result = response.data.predictions
						if(result.length > 0) {
							for (var i = 0; i < result.length; i++) {
								if(result[i].structured_formatting.main_text == this.form.business_name) {
									this.form.exist_item = result[i]
								}
							}
						}

						let data = {
							name: this.form.business_name,
							exist_item: this.form.exist_item
						}

						this.$emit('get-params', data)
						this.$emit('change-step', 2)
					})
					.catch(error => {
									
					})
				}
			}
		},

		created() {
			if(this.sendData.name) {
				this.form.business_name = this.sendData.name
			}
		}
	}
</script>