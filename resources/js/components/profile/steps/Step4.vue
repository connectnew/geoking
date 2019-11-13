<template>
	<div class="row">
		
		<slot name="back"></slot>

		<div class="col-xl-6 col-lg-8 col-12 inquiry-form plr-60">
			<div class="row d-flex min-height-100 height-auto-mob align-items-center">
				<div class="col-12 px-md-3 px-4">
					<h1 class="text-center mt-5">Tell us about your competition</h1>

					<div class="clearfix"></div>

					<div class="competitors">
						<p class="mb-1">Add competitors <a href="#!" class="blueLink"><i class="fa fa-question-circle font-14"></i></a></p>
						<div id="custom-search-input">
							<div class="input-group col-md-12">
								<v-select class="custom-v-select form-control border-0"
							placeholder="Search"
							label="description"
							:resetOnOptionsChange="true"
							:filterable="false"
							v-model="search"
							:options="competitors"
							@search="searchCompetitors">
								<template #search="{attributes, events}">
									<input
										class="vs__search"
										autocomplete="new-username"
										v-bind="attributes"
										v-on="events"/>
								</template>
							</v-select>

								<!-- <input type="text" class=" search-query form-control" placeholder="Search" v-model="search"/>
								<span class="input-group-btn">
									<button class="btn mt-2" type="button"> <i class="fa fa-search text-muted"></i></button>
								</span> -->
							</div>
						</div>

						<div class="row mb-4">
							<div class="col-md-12 pt-3 d-flex align-items-center" v-for="(item, index) in form.competitions">
								<h4 class="mb-0 pr-4">{{ item.description }}</h4>

								<a role="button" class="pointer" @click="form.competitions.splice(index, 1)">
									<i class="fa fa-times"></i>
								</a>
								<!-- <textarea class="form-control"></textarea> -->
							</div>
						</div>

						<!-- <div class="clearfix"></div>

						<p class="mb-1 mt-3">Your competitors <a href="#!" class="blueLink"><i class="fa fa-question-circle font-14"></i></a></p>

						<textarea class="form-control" v-model="form.competition"></textarea>

						<div class="clearfix mt-2"></div> -->

						<span class="smalltext">Added {{ form.competitions.length }} out of 10 competitors</span>
						<div class="gray-strip">If you can’t find your competitors by using the search field above,  to add it as a new hotel or contact us at service@geoking.com</div>

						<hr>

					</div>
				</div>

				<slot name="next"></slot>

			</div>
		</div>
		<div class="col-xl-3 col-lg-2 d-lg-block d-none col-2 blue-bg-col min-height-100"></div>
	</div>
</template>
<script>
	import vSelect from 'vue-select'

	export default {
		name: 'Step4',

		components: {
			vSelect
		},

		props: ['formProp'],

		data() {
			return {
				competitors: [],
				search: '',
				form: {
					competitions: []
				}
			}
		},

		watch: {
			'search'(val) {
				if(val && val.id && this.form.competitions.length < 10) {
					this.form.competitions.push(val)
					this.search = ''
					this.competitors = []
				}
			}
		},

		methods: {
			searchCompetitors(search, loading) {
				if(search.length > 1) {
					loading(true);
					this.searchCompetitor(loading, search, this);
				} else {
					loading(false);
				}
			},

			searchCompetitor: _.debounce((loading, search, vm) => {
				vm.competitors = []

				axios.get('/api/v1/businesses/search/' + search)
				.then(response => {
					console.log(response.data.predictions)
					vm.competitors = response.data.predictions;
					loading(false);
				})
				.catch(error => {
					loading(false);
				})
			}, 300),

			validateStep() {
				this.$emit('get-params', this.form)
				this.$emit('change-step', 4)
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