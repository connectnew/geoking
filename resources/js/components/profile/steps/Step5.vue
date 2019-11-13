<template>
	<div class="row">

		<slot name="back"></slot>

		<div class="col-xl-8 col-lg-8 col-12 inquiry-form plr-50">
			<h1 class="mt-4">Tell us about your team</h1>
			<div class="table-responsive">
				<table class="table table-borderless team-table">
					<thead>
						<tr>
							<th></th>
							<th class="name-email-col"></th>
							<th class="text-left">Action</th>
							<th class="text-left">Frequency</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item, index) in form.team">

							<td class="text-center">
								<avatar-cropper
								@uploaded="handleUploaded(index)"
								:trigger="'#pick-avatar-' + index"
								:labels="cropper.labels"
								output-mime="image/png"
								:output-options="cropper.options"
								:upload-url="'/api/v1/images/members'" />

								<button :id="'pick-avatar-' + index" class="btn" v-if="!item.photo">Add Photo</button>
								<img :src="item.photo" :alt="item.name" :id="'team-photo-' + index" v-else>
							</td>

							<td class="text-left text-nowrap">
								<div class="row">
									<div class="col-12 pr-4">
										<div class="d-inline-block pr-2 w-50">
											<input type="text" class="form-control" placeholder="Name" v-model="item.name">
										</div>
										<div class="d-inline-block w-50">
											<input type="text" class="form-control" placeholder="Email" v-model="item.email">
										</div>
									</div>
									<div class="col-12 text-wrap">
										<p class="mb-0">{{ item.position }}</p>
									</div>
								</div>
							</td>

							<td class="text-left text-nowrap">
								<div class="d-inline-block action-col">
									<div class="custom-control custom-checkbox mr-sm-2 rtl-lbl">
										<input type="checkbox" class="custom-control-input" :id="'customControlAutosizing-' + index" v-model="item.alerts">
										<label class="custom-control-label" :for="'customControlAutosizing-' + index"> Instant alerts</label>
									</div>
								</div>
								<div class="d-inline-block action-col">
									<div class="custom-control custom-checkbox mr-sm-2 rtl-lbl">
										<input type="checkbox" class="custom-control-input" :id="'customControlAutosizing2-' + index" v-model="item.summary">
										<label class="custom-control-label" :for="'customControlAutosizing2-' + index"> Exec summary</label>
									</div>
								</div>
							</td>

							<td class="text-center">
								<select class="form-control" v-model="item.frequency">
									<option value="daily">Daily</option>
									<option value="weekly">Weekly</option>
									<option value="monthly">Monthly</option>
								</select>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="row">
				<slot name="next"></slot>
			</div>

		</div>
		<div class="col-xl-2 col-lg-2 d-lg-block d-none col-2 blue-bg-col min-height-100"></div>
	</div>
</template>
<script>
	import AvatarCropper from "vue-avatar-cropper"

	export default {
		name: 'Step5',

		components: {
			AvatarCropper
		},

		props: ['formProp'],

		data() {
			return {
				cropper: {
					labels: {
						submit: 'Submit',
						cancel: 'Cancel'
					},
					options: {
						minWidth: 640,
						minHeight: 640,
						maxWidth: 4048,
						maxHeight: 4048,
					}
				},
				form: {
					team: [
					{
						position: 'Marketing Manager',
						photo: '',
						name: '',
						email: '',
						alerts: false,
						summary: false,
						frequency: 'daily'
					},
					{
						position: 'Sales Manager',
						photo: '',
						name: '',
						email: '',
						alerts: false,
						summary: false,
						frequency: 'daily'
					},
					{
						position: 'Operations Manager',
						photo: '',
						name: '',
						email: '',
						alerts: false,
						summary: false,
						frequency: 'daily'
					},
					{
						position: 'HR Manager',
						photo: '',
						name: '',
						email: '',
						alerts: false,
						summary: false,
						frequency: 'daily'
					},
					{
						position: 'IT',
						photo: '',
						name: '',
						email: '',
						alerts: false,
						summary: false,
						frequency: 'daily'
					},
					{
						position: 'Brand Experience',
						photo: '',
						name: '',
						email: '',
						alerts: false,
						summary: false,
						frequency: 'daily'
					},
					{
						position: 'Customer Support',
						photo: '',
						name: '',
						email: '',
						alerts: false,
						summary: false,
						frequency: 'daily'
					},
					]
				}
			}
		},

		methods: {
			handleUploaded(index, resp) {
				this.form.team[index].photo = resp.image_url
				Vue.nextTick(function () {
					document.getElementById("team-photo-" + index).src = resp.image_url;
				})
			},

			validateStep() {
				this.$emit('get-params', this.form)
				this.$emit('change-step', 5)
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