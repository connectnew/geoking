<template>
	<div>
		<div class="row">
			<div class="col-md-12 col-xllg-3 col-lg-4">
				<div class="white-rounded-box filter-section h-100 rounded-0">
					<div class="row d-flex">
						<div class="col text-left">
							<span class="font-weight-bold text-blue">Filters</span>
						</div>
					</div>

					<hr class="mt-2 mb-2">

					<span class="review-title-heading">Type</span>

<!-- 					<hr class="mt-2 mb-2">

					<div class="row my-2">
						<div class="col-6 text-left font-weight-bold txt-gray"> Language </div>
						<div class="col-6 text-right">
							<select class="border-0 select-small" v-model="form.lang">
								<option value="all">All</option>
								<option value="en">English</option>
								<option value="de">German</option>
								<option value="fr">French</option>
							</select>
						</div>
					</div> -->

					<hr class="mt-2 mb-2">

					<div class="row mt-2">
						<div class="col-6 col-xl-8 text-left font-weight-bold txt-gray"> Sources </div>
						<div class="col-6 col-xl-4 text-right">
							<v-select
									label="name"
									:clearable="false"
									class="border-0 select-small select-label"
									v-model="form.sources"
									:options="sources">
									<template #search="{attributes, events}">
										<input
										class="vs__search"
										autocomplete="new-username"
										v-bind="attributes"
										v-on="events"/>
									</template>
								</v-select>
						</div>
					</div>

					<hr class="mt-2 mb-2">
					<span class="review-title-heading">Status</span>

					<hr class="mt-2 mb-2">
					<div class="d-flex justify-content-between align-items-center pointer" @click="toggleStatus('unresponded')">
						<span class="font-weight-bold txt-gray">Unresponded</span>
						<i class="fa fa-check" v-if="form.status.includes('unresponded')"></i>
					</div>

					<hr class="mt-2 mb-2">
					<div class="d-flex justify-content-between align-items-center pointer" @click="toggleStatus('responded')">
						<span class="font-weight-bold txt-gray">Responded</span>
						<i class="fa fa-check" v-if="form.status.includes('responded')"></i>
					</div>
					<hr class="mt-2 mb-2">



					<span class="review-title-heading">Other</span>
					<hr class="mt-2 mb-2">
					<div class="row">
						<div class="col-6 text-left font-weight-bold txt-gray"> Location </div>
						<div class="col-6 text-right">
							<custom-select
							:allCheckbox="true"
							:options="entities"
							label="title"
							v-model="form.entity"></custom-select>	
							<!-- <v-select
									label="title"
									:clearable="false"
									class="border-0 select-small select-label multiselect"
									v-model="form.entity"
									:multiple="true"
									:options="entities">
									<template #search="{attributes, events}">
										<input
										class="vs__search"
										autocomplete="new-username"
										v-bind="attributes"
										v-on="events"/>
									</template>
								</v-select> -->
						</div>
					</div>

					<hr class="mt-2 mb-2">
					<div class="row">
						<div class="col-12 col-md-6 col-lg-4 col-xl-5 font-weight-bold txt-gray"> Period </div>
						<div class="col-12 col-md-6 col-lg-8 col-xl-7 d-flex flex-column align-items-end">
							<!-- <div class="w-100 mb-3">
								<span class="float-left float-sm-right">
									<div class="d-inline-block float-left mt-1 mr-2 text-muted">Presets</div>
									<div class="toggle listing-switch toggle_small d-inline-block float-left mr-2 mt-2">
										<label class="switch">
											<input type="checkbox" class="primary" v-model="presets"/>
											<span class="slider round"></span>
										</label>
									</div>
								</span>
							</div> -->

							<v-select
								label="title"
								:clearable="false"
								class="border-0 select-small select-label w-100"
								v-model="form.preset"
								:options="periods">
								<template #search="{attributes, events}">
									<input
									class="vs__search"
									autocomplete="new-username"
									v-bind="attributes"
									v-on="events"/>
								</template>
							</v-select>

							<v-date-picker v-show="!presetPeriod"
							class="w-100 input-date-range mt-2"
							mode='range'
							v-model='form.period'
							show-caps></v-date-picker>
						</div>
					</div>

					<hr class="mt-2 mb-2">

					<div class="row font-weight-bold txt-gray mt-2">
						<div class="col-12">
							<span>Score Range: {{ form.score[0] }} - {{ form.score[1] }}</span>
						</div>
					</div>

					<div class="row mb-5 mt-2">
						<div class="col-12">
							<vue-slider
								class="border-0 bold-txt txt-gray px-2"
						      v-model="form.score"
						      :dot-style="{ backgroundColor: 'rgb(51, 148, 214)', borderColor: 'rgb(51, 148, 214)' }"
						      :process-style="{ backgroundColor: 'rgb(51, 148, 214)' }"
						      :min="0"
						      :max="5"
						      :tooltip="'none'">
						   </vue-slider>
						</div>
					</div>

					<div class="row mb-2">
						<div class="col-12 text-right">
							<button type="button" class="btn btn-light bold-txt py-1" @click="reset">Reset</button>
							<button type="button" class="btn btn-apply" @click="updateTable()">Apply</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Right side -->
			<div class="col-md-12 col-xllg-9 col-lg-8">
				<div class="gray-bg pb-0 h-100 mt-md-0 mt-3">
					<div class="row">
						<div class="col-12 reviews_tabs">
							<div class="bg-white p-3 m-3">
								<div class="d-flex flex-wrap">
									<a role="button" class="nav-link  bg-info text-white mr-2 pointer" @click="updateTable('all')">
										<strong class="text-white fs-20">{{ counters.all }}</strong>
										All
									</a>
									<a role="button" class="nav-link  bg-red text-white mr-2 pointer" @click="updateTable('negative')">
										<strong class="text-white fs-20">{{ counters.negative }}</strong>
										Negative reviews
									</a>
									<a role="button" class="nav-link bg-green text-white mr-2 pointer" @click="updateTable('positive')">
										<strong class="text-white fs-20">{{ counters.positive }}</strong>
										Positive reviews
									</a>
									<a role="button" class="nav-link bg-black text-white pointer" @click="updateTable('overdue')">
										<strong class="text-white fs-20">{{ counters.overdue }}</strong>
										Overdue Response
									</a>
								</div>

								<!--<h4 class="mb-3 review-title-heading mt-3">Entities</h4>

								<ul id="tabs" class="nav nav-tabs d-flex flex-wrap" role="tablist">
									<li class="nav-item" v-for="item in entities">
										<a role="button" class="nav-link pointer"
										:class="{active: checkEntity(item)}"
										@click="updateEntity(item)">{{ item.title }}</a>
									</li>
								</ul>-->

								<div class="card-body p-0 pt-3">

									<div class="gray-strip text-white mb-2 d-flex justify-content-between"
									:class="{'bg-info': reviewType == 'all', 'bg-red': reviewType == 'negative', 'bg-green': reviewType == 'positive', 'bg-black': reviewType == 'overdue' }">
									<span v-if="reviewType == 'all'">
										All reviews
									</span>
									<span v-else-if="reviewType == 'negative'">
										Negative reviews
									</span>
									<span v-else-if="reviewType == 'positive'">
										Positive reviews
									</span>
									<span v-else>
										Overdue response
									</span>

									<!--<a role="button" class="pointer" data-target="#replyModal" data-toggle="modal">
										<i class="fa fa-download"></i>
									</a>-->
								</div>

								<div class="table-responsive review_tbl">
									<vuetable class="table table-hover reviews-table" ref="vuetable"
									:api-url="'/reviews'"
									:append-params="tableParams"
									:fields="fields"
									:sort-order="sortOrder"
									:multi-sort="true"
									data-path="data"
									pagination-path=""
									pagination-component="VuetablePagination"
									@vuetable:pagination-data="onPaginationData">
									<template slot="review" slot-scope="props">
										<p class="mb-0">{{ $options.filters.truncate(props.rowData.comment) }}</p>
									</template>
									<template slot="source" slot-scope="props">
										<img :src="'/assets/images/' + props.rowData.source_name + '-logo.png'" :alt="props.rowData.source_name" class="source-img">
									</template>
									<template slot="by" slot-scope="props">
										<div class="d-flex flex-column justify-content-center align-items-center">
											<h5>{{ props.rowData.reviewer_name }}</h5>
											<span class="txt-gray">{{ props.rowData.stats }}</span>
										</div>
									</template>
									<template slot="responded" slot-scope="props">
										<div class="d-flex justify-content-center align-items-center">
											<span class="status-circle mr-1 mb-1" :class="[props.rowData.responded ? 'bg-green' : 'bg-red']"></span>
											<h5>{{ props.rowData.responded ? 'Responded' : 'Unresponded' }}</h5>
										</div>
									</template>
									<template slot="actions" slot-scope="props">
										<!--<div class="sharethis-inline-share-buttons"></div>-->
										<a class="pointer p-1" @click="shareLinks(props.rowData)">
											<i class="fa fa-share-alt"></i>
										</a>
										<a role="button" class="pointer p-1" data-target="#replyModal" data-toggle="modal" @click="reviewReply(props.rowData)">
											<i class="fa fa-reply"></i>
										</a>
										<a role="button" class="pointer p-1 text_yellow font-18" @click="showSmartResponse(props.rowData)">
											<i class="fa fa-lightbulb-o"></i>
										</a>
									</template>
								</vuetable>
								<vuetable-pagination ref="pagination"
								@vuetable-pagination:change-page="onChangePage"
								:css="$root.paginationStyle"></vuetable-pagination>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<div class="modal" id="share-links" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content reset__popup">
			<div class="modal-body">
				<social-sharing :url="shareData.location.website"
								:title="shareData.location.title"
								:description="shareData.comment"
								:quote="shareData.comment"
								hashtags="seoking"
								inline-template>
					<div class="d-flex justify-content-around">
						<network network="email">
							<i class="fa fa-envelope"></i> Email
						</network>
						<network network="facebook">
							<i class="fa fa-facebook"></i> Facebook
						</network>
						<network network="twitter">
							<i class="fa fa-twitter"></i> Twitter
						</network>
					</div>
				</social-sharing>
			</div>
		</div>
	</div>
</div>
</div>
</template>
<script>
	import CustomSelect from '../CustomSelect.vue'
	import { setupCalendar } from 'v-calendar'
	import vSelect from "vue-select"
	import vueSlider from 'vue-slider-component'
	import 'vue-slider-component/theme/antd.css'
	import Vuetable from 'vuetable-2'
	import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
	import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
	import PaginationMixin from 'vuetable-2/src/components/VuetablePaginationMixin.vue'
	import moment from 'moment'
	import SocialSharing from 'vue-social-sharing'

	export default {
		name: 'ManageReviews',

		components: {
			CustomSelect,
			vSelect,
			vueSlider,
			Vuetable,
			VuetablePagination,
			VuetablePaginationInfo,
			PaginationMixin,
			SocialSharing
		},

		props: [],

		data() {
			return {
				shareData: {
					location: {}
				},
				presets: false,
				presetPeriod: true,
				tableParams: {},
				replyForm: {},
				entities: [],
				sources: ['google'],
				locations: [],
				counters: {
					all: 0,
					negative: 0,
					positive: 0,
					overdue: 0,
				},
				periods: ['all', 'last 30 days', 'last 3 month', 'last year', 'choose period'],
				form: {
					sources: 'google',
					status: ['unresponded', 'responded'],
					entity: [],
					period: null,
					preset: 'all',
					score: [0, 5],
					// lang: 'all',
				},
				reviewType: 'all',
				entityType: null,
				sortOrder: [],
				fields: [
				{
					name: '__slot:review',
					title: 'Review',
					sortField: 'comment',
					dataClass: 'pt-3',
				},
				{
					name: 'rating',
					title: 'Rating',
					sortField: 'rating',
					dataClass: 'pt-3',
				},
				{
					name: '__slot:source',
					title: 'Source',
					dataClass: 'pt-3',
				},
				{
					name: 'location.title',
					title: 'Store',
					dataClass: 'pt-3',
				},
				{
					name: '__slot:by',
					title: 'By',
					sortField: 'reviewer_name',
					dataClass: 'pt-3',
				},
				{
					name: '__slot:responded',
					title: 'Responded?',
					sortField: 'responded',
					dataClass: 'pt-3',
				},
				{
					name: 'created_at_for_humans',
					title: 'When',
					sortField: 'created_at',
					dataClass: 'pt-3'
				},
				{
					name: '__slot:actions',
					title: 'Action',
					dataClass: 'pt-3',
				},
				],
			}
		},

		watch: {
			'form.preset': function (newVal, oldVal) {
				if (oldVal === 'choose period') {
					this.presetPeriod = true
				} else if (newVal === 'choose period') {
					this.presetPeriod = false
				}
			}
		},

		filters: {
			truncate: function(value) {
				if (!value) return ''
					value = value.toString()
				if(value.length >= 45) {
					return value.split(" ").splice(0, 5).join(" ") + ' ...';
				} else {
					return value
				}
			}
		},

		methods: {
			checkEntity(item) {
				for (var i = 0; i < this.form.entity.length; i++) {
					if(this.form.entity[i].id == item.id) {
						return true
					}
				}
				return false
			},

			updateEntity(item) {
				for (var i = 0; i < this.form.entity.length; i++) {
					if(this.form.entity[i].id == item.id) {
						this.form.entity.splice(i, 1)
						return false
					}
				}
				this.form.entity.push(item)
			},

			updateTable(reviewType) {
				if (typeof reviewType !== 'undefined') {
					this.reviewType = reviewType;
				}
				let period = null
				if (this.form.period != null) {
					period = [
						moment(this.form.period.start).format('YYYY-MM-DD'),
						moment(this.form.period.end).format('YYYY-MM-DD')
					]
				}

				this.$set(this.tableParams, 'type', this.reviewType)

				let entityId = this.form.entity.map(item => (item.id)).join(',')

				if(this.form.entity.length == this.locations.length) {
					this.$set(this.tableParams, 'entity', '')
				} else {
					this.$set(this.tableParams, 'entity', entityId)
				}
				

				this.$set(this.tableParams, 'preset', this.form.preset)
				this.$set(this.tableParams, 'period', period)
				this.$set(this.tableParams, 'status', this.form.status)
				this.$set(this.tableParams, 'score', this.form.score)

				this.$refs.vuetable.refresh();
			},

			reset() {
				this.form = {
					sources: 'google',
					status: ['unresponded', 'responded'],
					entity: [],
					period: null,
					preset: 'all',
					score: [0, 5],
					// lang: 'all'
				}
				this.updateTable()
			},

			onPaginationData (paginationData) {
				this.$refs.pagination.setPaginationData(paginationData)
			},

			onChangePage (page) {
				this.$refs.vuetable.changePage(page)
			},

			reviewReply (review) {
				this.$root.$emit('showReviewReplyModal', review)
			},

            showSmartResponse(review) {
                this.$root.$emit('showSmartResponseModal', review);
			},

			toggleStatus(status) {
				let i = this.form.status.indexOf(status);
				if (i === -1)
					this.form.status.push(status);
				else
					this.form.status.splice(i, 1);
			},
			shareLinks(review) {
				this.shareData = review
				$('#share-links').modal('show');
			}
		},

		created() {
			setupCalendar({
				firstDayOfWeek: 1,
				datePickerTintColor: '#043e88', 
			})

			axios.get('/api/v1/locations')
			.then(response => {
				this.locations = response.data
				for (var i = 0; i < response.data.length; i++) {
					this.entities.push(response.data[i])
				}
			})
			.catch(error => {
							
			})
			axios.post('/reviews-counters')
			.then(response => {
				this.counters = response.data
			})
			.catch(error => {

			})
		},

		mounted () {
			this.$root.$on('updateReviewsTable', () => {
				this.$refs.vuetable.reload();
			});
		},
	}
</script>