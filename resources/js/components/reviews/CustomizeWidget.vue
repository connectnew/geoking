<template>
	<div class="row mt-3">
		<div class="col-12">
			<h3 class="text-dark font-weight-normal mb-1">Create a new testimonial carousel widget</h3>
			<h4 class="mb-4 text-secondary font-weight-normal mb-4">Customize your widget and select your reviews before receiving your embed code</h4>
			<div class="white-rounded-box testimonial_widget_page p-4 mb-4">
				<div class="row">
					<div class="col-12 form-group">
						<label>Name your widget</label>
						<input type="text" class="form-control" id="Choose" name="Choose" placeholder="Choose a name for your widget" v-model="form.title">
					</div>
					<div class="col-12 form-group mt-3">
						<div class="border-bottom"> <span class="setup">SETUP</span> </div>
					</div>
					<div class="col-12 mt-4">
						<div class="custom-control custom-checkbox mr-sm-2 text-left">
							<input type="checkbox" class="custom-control-input" id="ShowGeoKinglogo" v-model="form.show_logo">
							<label class="custom-control-label text-left font-weight-normal" for="ShowGeoKinglogo">Show GeoKing logo</span></label>
						</div>
					</div>
				</div>
			</div>
			<div class="white-rounded-box testimonial_widget_page p-4">
				<div class="row">
					<div class="col-12 form-group">
						<h3 class="text-dark font-weight-normal mb-2 text-center"> Recommended Reviews</h3>
						<p>Based on averange rating. review sentiment, and review source</p>
						<p class="text-center mt-3">You can remove and add others that you find through <a href="#!"><u>Rating & Reviews</u></a> Your widget will  display 3 reviews at the minimum.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mt-2 text-center">
						<select class="custom-select set-business-input w-auto mr-1 mb-2">
							<option value="0">All locations</option>
						</select>
						<select class="custom-select set-business-input w-auto mr-1 mb-2">
							<option value="0">All sources</option>
						</select>
						<select class="custom-select set-business-input w-auto mr-1 mb-2">
							<option value="0">All ratings</option>
						</select>
						<select class="custom-select set-business-input w-auto mb-2">
							<option value="0">Last 12 months</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-12 form-group mt-3 mb-4">
						<p class="text-center">Setting a filter will replace the currently selected reviews.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-1 form-group text-center">
						<h1 class="text-muted font-weight-normal">1</h1>
					</div>
					<div class="col-11 form-group">
						<div class="add-a-review">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-12 text-left">
									<label>Add a review</label>
								</div>
								<div class="col-md-6 col-sm-6 col-12 form-group text-left text-sm-right">984567138745624</div>
							</div>
							<div class="row">
								<div class="col-12">
									<label class="text-secondary">Paste review ID <a href="#!"><u>View reviews</u></a></label>
									<input type="text" class="form-control" id="PasteReviewID" name="PasteReviewID" v-model="form.review_id">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12 text-right mt-3">
					<a href="/promote-reviews">
						<button class="btn" role="button"><u>Cancel</u></button>
					</a>
					<button class="btn btn-secondary" @click="validateForm">Preview and Get Code</button>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import { required } from 'vuelidate/lib/validators'

	export default {
		name: 'CustomizeWidget',

		props: [],

		data() {
			return {
				form: {}
			}
		},

		validations: {
			form: {
				review_id: {required},
				title: {required}
			}
		},

		methods: {
			validateForm() {
				this.$v.form.$touch();
				let isValid = !this.$v.form.$invalid;

				if(isValid) {
					axios.post('/api/v1', this.form)
					.then(response => {
					
					})
					.catch(error => {
									
					})
				}
			}
		}
	}
</script>