<template>
	<div>
	<div class="row mt-4">
				<div class="col-12">
					<div class="manage-locations-page">
						<ul class="nav nav-tabs responsive-tabs" id="myTab" role="tablist">
							<li class="nav-item"> <a class="nav-link pointer" :class="{'active': type == 'all'}" id="profile-tab" @click="type = 'all'">All</a> </li>
							<li class="nav-item"> <a class="nav-link pointer" :class="{'active': type == 'confirmed'}" id="reviews-tab" @click="type = 'confirmed'">Verified </a> </li>
							<li class="nav-item"> <a class="nav-link pointer" :class="{'active': type == 'unconfirmed'}" id="posts-tab" @click="type = 'unconfirmed'">Pending verification</a> </li>
							
						</ul>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
								<div class="row">
									<div class="col-md-2 col-lg-2 col-xl-1 locations-selectbox pb-2">
										<select class="form-control rounded-5 mt-1 w-auto w_75_pixel" v-model="perPage">
											<option :value="10">10</option>
											<option :value="15">15</option>
											<option :value="20">20</option>
											<option :value="25">25</option>
											<option :value="30">30</option>
										</select>
									</div>
									<div class="col-md-1 col-lg-1 col-xl-2 pb-2"></div>
									<div class="col-md-9 col-lg-9 col-xl-9">
										<div class="row_mob mt-1 d-flex align-items-center justify-content-end">
											<a href="/refresh-locations" class="no-link-highlits px-2 mr-3">
												<i class="fa fa-repeat"></i>
											</a>
											<div class="col mx-w-150 px-lg-1 px-2 d-md-inline-block">
												<button class="d-flex align-items-center justify-content-center btn btn-black" @click="scanLocations"><img src="/assets/images/scan-icon.png" class="pr-3"> <span>Scan All</span></button>
											</div>
											<!-- <div class="col mx-w-150 px-lg-1 px-2 d-md-inline-block mb-sm-0 mb-2">
												<button class="d-flex align-items-center justify-content-center btn btn-green" data-toggle="modal" data-target="#CreateLocationGroup"><img src="/assets/images/user-group-icon.png" class="pr-3"> <span>Create group</span></button>
											</div> -->
											<div class="col mx-w-150 px-lg-1 px-2 d-md-inline-block">
												 <a href="/add-location"><button class="d-flex align-items-center justify-content-center btn btn-blue"><img src="/assets/images/location-icon.png" class="pr-3"> <span>Add Location</span></button></a>
											</div>
											<div class="col-lg-3 col-12 mt-lg-0 mt-3 d-md-inline-block">
												<form class="search-location" action="#">
													<span class="position-relative d-inline-block mr-3 mt-1">
													<input type="text" placeholder="Search" name="search" class="form-control rounded-5">
													</span>
												</form>
											</div>
										</div>
									</div>
								</div>
								<div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
									<div class="row">
										<div class="col-sm-12 col-md-6"></div>
										<div class="col-sm-12 col-md-6"></div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="table-responsive pb-3">
												<vuetable class="table mt-3" ref="vuetable"
													:api-url="'/api/v1/locations/' + type + '?paginate=1'"
													:perPage="perPage"
													:fields="fields"
													:sort-order="sortOrder"
													:show-sort-icons="true"
													:multi-sort="true"
													data-path="data"
													pagination-path=""
													pagination-component="VuetablePagination"
													@vuetable:pagination-data="onPaginationData">
														<!-- <template slot="location_ref" slot-scope="props">
															<div class="d-flex align-items-center">
																<i class="fa fa-exclamation-circle text_red font-20 mr-2" v-if="!props.rowData.is_confirmed"></i>
																<i class="fa fa-map-marker text_light_blue font-20 mr-3"></i>
																<p class="mb-0">{{ props.rowData.website }}</p>
															</div>
														</template> -->
														<template slot="title" slot-scope="props">
															<div class="d-flex align-items-center">
																<i class="fa fa-exclamation-circle text_red font-20 mr-2" v-if="!props.rowData.is_confirmed"></i>
																<i class="fa fa-map-marker text_light_blue font-20 mr-3"></i>
																<p class="mb-0">{{ props.rowData.title }}</p>
															</div>
														</template>
														<template slot="city" slot-scope="props">
															<p class="mb-0">{{ props.rowData.raw_data && props.rowData.raw_data.address && props.rowData.raw_data.address.locality ? props.rowData.raw_data.address.locality : props.rowData.city }}</p>
														</template>
														<template slot="rating" slot-scope="props">
															{{ props.rowData.rating }}
														</template>
														<template slot="response_rate" slot-scope="props">
															{{ getResponseRate(props.rowData) }}%
														</template>
														<template slot="actions" slot-scope="props">
															<a :href="'/locations/' + props.rowData.id + '?tab=edit'">
																	<icon-pencil></icon-pencil>
																</a>
																<a href="#" @click="scanLocation(props.rowData)">
																		<icon-search></icon-search>
																</a>
																<!-- no insights
																<a :href="'/locations/' + props.rowData.id + '?tab=insights'">
																		<icon-speed></icon-speed>
																</a>-->
																<a href="#" @click="item = props.rowData" data-toggle="modal" data-target="#deleteModal">
																		<icon-trash></icon-trash>
																</a>
														</template>
													</vuetable>
													<vuetable-pagination ref="pagination"
													@vuetable-pagination:change-page="onChangePage"
													:css="$root.paginationStyle"></vuetable-pagination>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12 col-md-5"></div>
										<div class="col-sm-12 col-md-7"></div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<div class="modal fade manage-reviews-modal" id="deleteModal">
				<div class="modal-dialog modal-lg">
					<div class="modal-content"> 
						<!-- Modal Header -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times-circle-o" aria-hidden="true" style="font-size: 25px; outline: 0px;"></i></button>
						</div>
						<!-- Modal body -->
						<div class="modal-body pb-0">
							<h5 class="text-center mb-4">Are you sure?</h5>

							<div class="d-flex justify-content-around my-3">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
								<button type="button" class="btn btn-primary" @click="deleteLocation" :disabled="disabled">Apply</button>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
</template>
<script>
	import Vuetable from 'vuetable-2'
	import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
	import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
	import PaginationMixin from 'vuetable-2/src/components/VuetablePaginationMixin.vue'

	import IconPencil from '../icons/Pencil'
	import IconTrash from '../icons/Trash'
	import IconSpeed from '../icons/Speed'
	import IconSearch from '../icons/Search'

	export default {
		name: 'Manage',

		components: {
			Vuetable,
			VuetablePagination,
			VuetablePaginationInfo,
			PaginationMixin,

			IconPencil,
			IconTrash,
			IconSpeed,
			IconSearch,
		},

		props: ['user'],

		data () {
			return {
				disabled: false,
				item: {},
				perPage: 10,
				type: 'all',
				loaded: false,
				fields: [
					{
						name: '__checkbox',
						titleClass: 'text-center',
						dataClass: 'text-center pt-21 d-flex justify-content-center align-items-center',
					},
					// {
					// 	name: '__slot:location_ref',
					// 	title: 'Location ref',
					// 	sortField: 'website',
					// 	titleClass: 'text-left',
					// 	dataClass: 'text-left pt-3',
					// },
					{
						name: '__slot:title',
						title: 'Location Name',
						sortField: 'title',
						titleClass: 'text-left',
						dataClass: 'text-left pt-3',
					},
					{
						name: '__slot:city',
						title: 'City',
						sortField: 'city',
						dataClass: 'pt-3',
					},
					{
						name: '__slot:rating',
						title: 'Rating',
						sortField: 'rating',
						dataClass: 'pt-3',
						callback: this.formatPercent,
					},
					{
						name: '__slot:response_rate',
						title: 'Response Rate',
						dataClass: 'pt-3',
					},
					{
						name: 'pending_reviews_count',
						title: 'Pending Reviews',
						dataClass: 'pt-3',
					},
					{
						name: 'locationName',
						title: 'Open Tickets',
						dataClass: 'pt-3',
					},
					{
						name: 'locationName',
						title: 'Posts',
						dataClass: 'pt-3',
					},
					{
						name: 'locationName',
						title: 'Scheduled Posts',
						dataClass: 'pt-3',
					},
					{
						name: '__slot:actions',
						title: 'Action',
						dataClass: 'pt-3',
					},
				],
				sortOrder: [
					// {
					//     field: 'title',
					//     direction: 'asc'
					//   },
					//   {
					//     field: 'email',
					//     direction: 'asc'
					//   }
				],
			}
		},

		watch: {
			'perPage' (val) {
				Vue.nextTick(() => this.$refs.vuetable.refresh())
			},
		},

		methods: {
			deleteLocation() {
				this.disabled = true
				axios.delete('/api/v1/locations/' + this.item.id)
				.then(response => {
					this.$refs.vuetable.reload();
					$('#deleteModal').modal('hide')
					this.disabled = false
				})
				.catch(error => {
					this.disabled = false
				})
			},

			onPaginationData (paginationData) {
				this.$refs.pagination.setPaginationData(paginationData)
			},

			onChangePage (page) {
				this.$refs.vuetable.changePage(page)
			},
			scanLocation (row) {
				let this$Root = this.$root

				axios.post('/scan/account-locations',
					[row.id]
				).then(response => {
					console.log(response, "response account scan", response.data)
					this$Root.$emit('showSimpleAlert', response.data.message)
				}).catch(error => {
					let message = error.toString()
					console.log(message, "mesage")
					try {
						message = error.response.data.error
					} catch (exception) {
						// do nothing
					}
					this$Root.$emit('showSimpleAlert', message)
				})
			},
			scanLocations () {
				let locations = this.$refs.vuetable.selectedTo,
					this$Root = this.$root

				if (locations.length > 0) {
					axios.post('/scan/account-locations',
									locations
					).then(response => {
						this$Root.$emit('showSimpleAlert', response.data.message)
					}).catch(error => {
						let message = error.toString()
						try {
							message = error.response.data.error
						} catch (exception) {
							// do nothing
						}
						this$Root.$emit('showSimpleAlert', message)
					})
				}
			},
			formatPercent (value) {
				return null !== value ? value + '%' : ''
			},
			getResponseRate(location) {
				if (location.reviews_count > 0) {
					return (100 * (location.reviews_count - location.pending_reviews_count) / location.reviews_count).toFixed(1)
				} else {
					return '0.0'
				}
			}
		},
		computed: {

		},
		created () {

		},
	}
</script>