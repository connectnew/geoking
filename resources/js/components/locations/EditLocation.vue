<template>
	<div class="row business-scan">
		<div class="col-md-12 col-lg-12 col-xllg-4 max-h-890">
			<div class="row">
				<div class="col-12">
					<div class="btn-blue" v-if="form.raw_data">{{ form.raw_data.locationName }} <img v-if="location.is_confirmed" src="/assets/images/checked_icon.svg" class="ml-2 img-fluid height_36"></div>
				</div>
				<div class="col-12"> 

					<div class="d-block">
						<GmapMap
						ref="location"
						:center="center"
						:zoom="12"
						style="width: 100%; height: 760px">
						<GmapMarker v-if="isValidLatLong(position.lat, position.lng)"
						:position="position"
						:icon="icon"
						:clickable="true"/>
					</GmapMap>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-lg-12 col-xllg-8 mt-xllg-0 mt-4">
			<div class="manage-locations-page business-scan">
				<ul class="nav nav-tabs responsive-tabs" id="myTab" role="tablist">
					<li class="nav-item"> <a class="nav-link active" id="menu-tab" data-toggle="tab" href="#menu" role="tab" aria-controls="menu" aria-selected="true">Listing</a> </li>
					<!-- no insights
					<li class="nav-item"> <a class="nav-link" id="zones-tab" data-toggle="tab" href="#zones" role="tab" aria-controls="zones" aria-selected="false">Insights</a> </li>
					-->
					<li  v-if="location.source_count > 0" class="nav-item"> <a class="nav-link" id="scan-report-tab" data-toggle="tab" href="#scan-report" role="tab" aria-controls="scan-report" aria-selected="false">Scan report</a> </li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show p-4 active padding-bottom-40 pt-5" id="menu" role="tabpanel" aria-labelledby="menu-tab">
						<div class="row">

							<div class="col-md-4 rating-numeric d-flex align-items-center">
								<span class="pr-3">{{ location.rating ? location.rating : 0 }}</span>
								<img :src="[index + 1 <= location.rating ? '/assets/images/active-geo.png' : '/assets/images/inactive-geo.png']" class="img-fluid pr-2" v-for="(item, index) in 5">
							</div>

							<div class="col-md-8 d-flex justify-content-end align-items-center">
								<button class="btn btn-publish w-auto px-5 mr-3 text-white" @click="updateLocation" :disabled="disabled">Publish</button>
								<div class="inline-block float-left"><img src="/assets/images/google_icon.svg" class="img-fluid height_28"></div>
								<div class="inline-block float-left ml-2"><i class="fa fa-facebook-official font-28 text-secondary"></i></div>
								<div class="inline-block float-left ml-2"><img src="/assets/images/bing_icon.svg" class="img-fluid height_28"></div>
								<div class="inline-block float-left ml-2"><i class="fa fa-foursquare font-28 text-secondary"></i></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-lg-6">
								<div class="row margin-top-70">
									<div class="col-10 d-flex align-items-center">
										<img src="/assets/images/new-location-icon.png" alt="location" class="pr-3 font-30">
										<div v-if="showCountry && form.raw_data.address">{{ form.raw_data.address.addressLines[0] }} {{ form.raw_data.address.locality }}, {{ form.raw_data.address.administrativeArea }}<br>
										{{ showCountry }} ({{ form.raw_data.address.regionCode }}) </div>
									</div>
									<div class="col-2 d-flex justify-content-end">
										<a href="#" data-toggle="modal" data-target="#edit_location" @click="showLocation">
											<img src="/assets/images/new-edit-icon.png" alt="edit">
										</a>
									</div>
								</div>
								<div class="row margin-top-70">
									<div class="col-10 d-flex align-items-start">
										<img src="/assets/images/new-clock-icon.png" alt="location" class="pr-3 font-28">
										<div v-if="form.raw_data && form.raw_data.regularHours && form.raw_data.regularHours.periods.length > 0">
											<template v-for="(item, index) in form.raw_data.regularHours.periods">
												<div class="inline-block float-left width-112 text-capitalize">{{ item.openDay }}</div>
												<div class="inline-block float-left">
													<template v-if="item.active">
														<template v-if="(item.openTime == '00:00' && item.closeTime == '24:00') || (item.openTime == 'Fullday' || item.closeTime == 'Fullday')">
															Fullday
														</template>
														<template v-else>
															{{ item.openTime }} - {{ item.closeTime }}
														</template>
													</template>
													<template v-else>
														Closed
													</template>
												</div>
												<div class="clearfix" v-if="index !== 6"></div>
											</template>
										</div>
										<div v-else>
											Hours
										</div>
									</div>
									<div class="col-2 d-flex justify-content-end">
										<a href="#" data-toggle="modal" data-target="#edit_time" @click="showHours">
											<img src="/assets/images/new-edit-icon.png" alt="edit">
										</a>
									</div>
								</div>
								<div class="row margin-top-70">
									<div class="col-10 d-flex align-items-start">
										<img src="/assets/images/new-phone-icon.png" alt="location" class="pr-3 font-26">
										<div class="text-capitalize"> {{ form.raw_data.primaryPhone ? form.raw_data.primaryPhone : 'phone'}} </div>
									</div>
									<div class="col-2 d-flex justify-content-end">
										<a href="#" data-toggle="modal" data-target="#edit_phone" @click="phoneForm = form.raw_data.primaryPhone">
											<img src="/assets/images/new-edit-icon.png" alt="edit">
										</a>
									</div>
								</div>
								<div class="row margin-top-70">
									<div class="col-10 d-flex align-items-start">
										<img src="/assets/images/new-world-icon.png" alt="location" class="pr-3 font-26">
										<div :class="{'text-capitalize': !form.website}"> {{ form.website ? form.website : 'website'}}</div>
									</div>
									<div class="col-2 d-flex justify-content-end">
										<a href="#" data-toggle="modal" data-target="#edit_url" @click="websiteForm = form.website">
											<img src="/assets/images/new-edit-icon.png" alt="edit">
										</a>
									</div>
								</div>
								<div class="row margin-top-70">
									<div class="col-10 d-flex align-items-start">
										<img src="/assets/images/new-bar-icon.png" alt="location" class="pr-3 font-22">
										<div>
											<p class="mb-2">Business description</p>
											<p class="m-0 fs-14">{{ form.raw_data.profile.description }}</p>
										</div>
									</div>
									<div class="col-2 d-flex justify-content-end">
										<a href="#" data-toggle="modal" data-target="#edit_business" @click="showDescription">
											<img src="/assets/images/new-edit-icon.png" alt="edit">
										</a>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-lg-1"></div>
							<div class="col-md-12 col-lg-5">
								<div class="row margin-top-70">
									<div class="col-10 d-flex align-items-start">
										<img src="/assets/images/new-check-icon.png" alt="location" class="pr-3 font-26">
										<div>{{ form.raw_data && form.raw_data.storeCode ? form.raw_data.storeCode : 'Store code'}}</div>
									</div>
									<div class="col-2 d-flex justify-content-end">
										<a href="#" data-toggle="modal" data-target="#edit_store-code" @click="storeCodeForm = form.raw_data.storeCode">
											<img src="/assets/images/new-edit-icon.png" alt="edit">
										</a>
									</div>
								</div>
								<div class="row margin-top-70">
									<div class="col-10 d-flex align-items-start">
										<img src="/assets/images/new-check-circle-icon.png" alt="location" class="pr-3 font-22">
										<div class="w-100">
											<template v-if="!form.raw_data.serviceArea || (form.raw_data.serviceArea && !form.raw_data.serviceArea.places) || (form.raw_data.serviceArea && form.raw_data.serviceArea.places && form.raw_data.serviceArea.places.placeInfos.length == 0)">
												Service area 
											</template>
											<template v-else>
												<div class="w-100" v-for="(item, index) in form.raw_data.serviceArea.places.placeInfos" v-if="form.raw_data.serviceArea && form.raw_data.serviceArea.places && form.raw_data.serviceArea.places.placeInfos">
													<div class="col-10 col-sm-11 d-flex align-items-center pl-0">
														<p class="mb-0">{{ item.name }}</p>
													</div>
												</div>
											</template>
										</div>
									</div>
									<div class="col-2 d-flex justify-content-end">
										<a href="#" data-toggle="modal" data-target="#edit_Servicearea" @click="showServices">
											<img src="/assets/images/new-edit-icon.png" alt="edit">
										</a>
									</div>
								</div>
								<div class="row margin-top-70" v-if="hasRegularHours">
									<div class="col-10 d-flex align-items-start">
										<img src="/assets/images/new-calendar-icon.png" alt="location" class="pr-3 font-24">
										<div class="w-100" v-if="form.raw_data.specialHours && form.raw_data.specialHours.specialHourPeriods.length > 0">
											<div
											class="d-flex w-100"
											v-for="item in form.raw_data.specialHours.specialHourPeriods">
											<span class="width-112">{{ item.startDate.day }}.{{ item.startDate.month }}.{{ item.startDate.year }}</span>
											<span v-if="!item.isClosed">
												<template v-if="(item.openTime == '00:00' && item.closeTime == '24:00') || (item.openTime == 'Fullday' || item.closeTime == 'Fullday')">
													Fullday
												</template>
												<template v-else>
													{{ item.openTime }} - {{ item.closeTime }}
												</template>
											</span>
											<span v-else>Closed</span>
										</div>
									</div>
									<div v-else> Special hours </div>
								</div>
								<div class="col-2 d-flex justify-content-end">
									<a href="#" data-toggle="modal" data-target="#edit_hours" @click="showSpecialHours">
										<img src="/assets/images/new-edit-icon.png" alt="edit">
									</a>
								</div>
							</div>
							<div class="row margin-top-70" v-if="form.raw_data.attributes && form.raw_data.attributes.length > 0">
								<div class="col-10 d-flex align-items-start">
									<img src="/assets/images/new-check-icon.png" alt="location" class="pr-3 font-26">
									<div v-if="form.raw_data.attributes && form.raw_data.attributes.length > 0">
										<p v-for="item in form.raw_data.attributes">{{ item.attributeId }}</p>
									</div>
									<div v-else> Attribute</div>
								</div>
								<div class="col-2 d-flex justify-content-end">
									<!-- <a href="#" data-toggle="modal" data-target="#edit_attribute" @click="showAttribute">
										<img src="/assets/images/new-edit-icon.png" alt="edit">
									</a> -->
								</div>
							</div>
							<div class="row margin-top-70">
								<div class="col-10 d-flex align-items-start">
									<img src="/assets/images/new-photo-icon.png" alt="location" class="pr-3 font-24">
									<div> Add Photos </div>
								</div>
								<div class="col-2 d-flex justify-content-end">
									<a href="#" data-toggle="modal" data-target="#edit_photo" @click="showPhotos">
										<img src="/assets/images/new-edit-icon.png" alt="edit">
									</a>
								</div>
								
								<p v-if="form.photos && form.photos.mediaItems">Current photo</p>
								<div class="col-12 d-flex align-items-center flex-wrap" v-if="form.photos && form.photos.mediaItems">
									<img :src="item.thumbnailUrl" :alt="item.thumbnailUrl" class="mr-3 mb-3" width="80" v-for="item in form.photos.mediaItems">
								</div>
								
								<p v-if="form.raw_data.photos && form.raw_data.photos.length > 0">Uploaded photo</p>
								<div class="col-12 d-flex align-items-center flex-wrap">
									<img :src="'/storage' + item.url" :alt="item.url" class="mr-3 mb-3" width="80" v-for="item in form.raw_data.photos">
								</div>
							</div>
						</div>
					</div>
					</div>

					<!-- Insights -->
					<!-- no insights
					<div class="tab-pane fade pt-5" id="zones" role="tabpanel" aria-labelledby="zones-tab">
						<div class="row px-3">
							<div class="col-lg-5">
								<div class="custom-card">
									<h4 class="text-uppercase mb-4">Performance</h4>

									<div class="row px-3">
										<div class="col-md-4 d-flex flex-column justify-content-center align-items-center bottom-bar active">
											<h5 class="text-grey">Views</h5>
											<span class="fs-32 mb-3">241</span>
										</div>
										<div class="col-md-4 d-flex flex-column justify-content-center align-items-center bottom-bar">
											<h5 class="text-grey">Searches</h5>
											<span class="fs-32 mb-3">22</span>
										</div>
										<div class="col-md-4 d-flex flex-column justify-content-center align-items-center bottom-bar">
											<h5 class="text-grey">Activity</h5>
											<span class="fs-32 mb-3">7</span>
										</div>
									</div>

									<div class="d-flex justify-content-between border-bottom pb-3 mb-3 mt-3">
										<p class="mb-0">Search views</p>

										<div>
											<span>51</span>
											<span class="pl-2 text-danger">(-18%)</span>
										</div>
									</div>

									<div class="d-flex justify-content-between mb-4">
										<p class="mb-0">Maps views</p>

										<div>
											<span>190</span>
											<span class="pl-2 text-danger">(-18%)</span>
										</div>
									</div>

									<p class="text-grey">Performance over the past 28 days</p>
								</div>
							</div>
							<div class="col-lg-7">
								<div class="custom-card">
									<div class="d-flex justify-content-between align-items-center">
										<p class="mb-0">Directions requests</p>
										<i class="fa fa-question-circle-o"></i>
									</div>

									<small>The areas where customers request directions to your business from</small>

									<div class="row mt-2">
										<div class="col-md-6">
											<select class="border-0 select-small">
												<option value="1">1 month</option>
											</select>
										</div>
										<div class="col-md-6">
											<GmapMap
												ref="editLocation"
												:center="center"
												:zoom="12"
												style="width: 100%; height: 245px">
												<GmapMarker
													:position="position"
													:icon="icon"
													:clickable="true"/>
											</GmapMap>
										</div>
									</div>
								</div>
							</div>
						</div>


						<div class="row mt-3 px-3">
							<div class="col-lg-6">
								<div class="custom-card">
									<div class="d-flex justify-content-between align-items-center">
										<p class="mb-0">Phone calls</p>
										<i class="fa fa-question-circle-o"></i>
									</div>

									<small>When and how many times customers call your business</small>

									<div class="d-flex my-3">
										<select class="border-0 select-small mr-3">
											<option value="1">Day of week</option>
										</select>

										<select class="border-0 select-small mr-3">
											<option value="1">one quarter</option>
										</select>
									</div>

									<p>Total calls 4</p>

									<div class="w-100">
										&lt;!&ndash; <line-chart :chart-data="chartdata" :options="options"></line-chart> &ndash;&gt;
										<GChart
										style="width: 100%; height: 400px;"
										type="ColumnChart"
										:data="chartData"
										:resizeDebounce="500"
										/>
									</div>

									<div class="d-flex align-items-center">
										<div class="phone-icon mr-2 d-flex justify-content-center align-items-center">
											<i class="fa fa-phone"></i>
										</div>
										<small>Do you want more calls? <a href="#">Create an ad</a></small>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="custom-card">
									<div class="d-flex justify-content-between align-items-center">
										<p class="mb-0">Customer actions</p>
										<i class="fa fa-question-circle-o"></i>
									</div>

									<small>The most common actions that customers take on your listing</small>

									<div class="d-flex my-3">
										<select class="border-0 select-small">
											<option value="1">1 month</option>
											<option value="3">3 month</option>
											<option value="6">6 month</option>
											<option value="12">1 year</option>
										</select>
									</div>

									<p>Total actions 19</p>

									<div class="w-100">
										&lt;!&ndash; <line-chart :chart-data="chartdata" :options="options"></line-chart> &ndash;&gt;
										<GChart
										style="width: 100%; height: 400px;"
										type="AreaChart"
										:data="chartDataActions"
										:options="chartOptions"
										:resizeDebounce="500"
										/>
									</div>
								</div>
							</div>
						</div>
					</div>-->

					<!-- Scan Result -->
					<div v-if="location.source_count > 0" class="tab-pane fade" id="scan-report" role="tabpanel" aria-labelledby="scan-report-tab">
						<scan-result :location="location"></scan-result>
					</div>
			</div>
		</div>
	</div>



	<!-- Location Modal -->
	<div class="modal" id="edit_location" tabindex="-1" role="dialog" aria-labelledby="edit_location" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" >Business location</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<p class="mb-4">Let customers see your business location on Google by adding a street address. You can leave this empty if you don't have a location such as a storefront or office.</p>
					<div class="row inquiry-form">
						<div class="col-sm-6 col-12">
							<div class="input-group mb-4">
								<span class="has-float-label">
									<v-select
									:class="{'error-shadow': $v.addressForm.country.$error}"
									label="name"
									class="form-control mt-1 p-0 border-0 select-label"
									v-model="addressForm.country"
									placeholder="Country / Region"
									:options="countries">
									<template #search="{attributes, events}">
										<input
										class="vs__search"
										autocomplete="new-username"
										v-bind="attributes"
										v-on="events"/>
									</template>
								</v-select>
									<!-- <input type="text" class="form-control" id="country" name="text" placeholder="Country / Region" readonly  v-model="showCountry" /> -->
									<label class="control-label" for="country">Country / Region</label>
								</span>
							</div>
							<div class="form-group input-group mb-4">
								<span class="has-float-label">
									<input type="text" class="form-control" id="address" name="address" placeholder="Street address" v-model="addressForm.street" :class="{'error-shadow': $v.addressForm.street.$error}" />
									<label class="control-label" for="address">Street address</label>
								</span>
							</div>
							<div class="form-group input-group mb-4">
								<span class="has-float-label">
									<input type="text" class="form-control" id="city" name="city" placeholder="City" v-model="addressForm.city" :class="{'error-shadow': $v.addressForm.city.$error}"/>
									<label class="control-label" for="city">City</label>
								</span>
							</div>
							<div class="input-group mb-4">
								<span class="has-float-label">
									<v-select
									label="name"
									class="form-control mt-1 p-0 border-0 select-label"
									v-model="addressForm.state"
									placeholder="Province / State"
									:options="provinces">
									<template #search="{attributes, events}">
										<input
										class="vs__search"
										autocomplete="new-username"
										v-bind="attributes"
										v-on="events"/>
									</template>
								</v-select>
								<label class="control-label" for="country">Province / State</label>
							</span>
						</div>
						<div class="form-group input-group mb-4">
							<span class="has-float-label">
								<input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal code" v-model="addressForm.zip"/>
								<label class="control-label" for="postal_code">Postal code</label>
							</span>
						</div>
					</div>
					<div class="col-sm-6 col-12">
						<p class="font-14">Drag pin to reposition</p>
						<div>
							<GmapMap
							:center="formCenter"
							:zoom="12"
							style="width: 100%; height: 285px">
							<GmapMarker
							:position="formPosition"
							:icon="icon"/>
							<!-- <GmapMarker
							@dragend="getCoordinatesForm"
							:position="formPosition"
							:clickable="true"
							:draggable="true"
							:icon="icon"
							@click="formCenter = formPosition"/> -->
						</GmapMap>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer flex-wrap">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			<button type="button" class="btn btn-primary" @click="updateAddress">Apply</button>
			<div class="clearfix w-100"></div>
			<p class="w-100 mt-3"> <strong>Please note:</strong> Edits may be reviewed for quality and can take up to 3 days to be published. <a href="#!">Learn more</a> </p>
		</div>
	</div>
</div>
</div>

	<!-- Regular Hours Modal -->
	<div class="modal fade" id="edit_time" tabindex="-1" role="dialog" aria-labelledby="edit_time" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" >Hours</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<div class="d-flex flex-column mb-4" v-for="(item, index) in hoursForm">
						<div>
							<div class="w-25 float-left text-capitalize py-2">{{ item.openDay }}</div>
							<div class="time_switch float-left toggle">
								<label class="switch float-left mr-3 mt-2">
									<input type="checkbox" class="primary" v-model="item.active">
									<span class="slider round"></span>
								</label>
								<span class="d-inline-block mt-1">
									<template v-if="item.active">
										Open
									</template>
									<template v-else>
										Close
									</template>
								</span>
							</div>
							<div class="pl-3 d-flex" v-if="item.active">
								<v-select
								class="form-control p-0 border-0"
								v-model="item.openTime"
								placeholder="Open"
								:options="times"
								@input="changeStartTime(index)"></v-select>

								<span class="px-3" v-if="item.openTime !== 'Fullday'">-</span>

								<v-select v-if="item.openTime !== 'Fullday'"
								class="form-control p-0 border-0"
								v-model="item.closeTime"
								placeholder="Close"
								:options="times"
								@input="changeEndTime(index)"></v-select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer flex-wrap">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" @click="updateHours">Apply</button>
					<div class="clearfix w-100"></div>
					<p class="w-100 mt-3"> <strong>Please note:</strong> Edits may be reviewed for quality and can take up to 3 days to be published. <a href="#!">Learn more</a> </p>
				</div>
			</div>
		</div>
	</div>

	<!-- Service Modal -->
	<div class="modal fade" id="edit_Servicearea" tabindex="-1" role="dialog" aria-labelledby="edit_Servicearea" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" >Service area</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<p class="mb-4">Let customers know where your business provides deliveries or services</p>
					<div class="row inquiry-form">
						<div class="col-12 col-sm-11 dropdown select--wrapper">
							<div class="form-group input-group input-with-icon mb-2">
								<span class="has-float-label">
									<input type="text" class="form-control" id="search_address" name="address" placeholder="Select areas" v-model="address" />
									<label class="control-label" for="search_address">Search and select areas</label>
								</span>
							</div>

							<p class="font-12"> you can change and add more later </p>

							<ul class="dropdown-menu custome-dropdown custom-autocomplete" :class="{'show': address && addressList.length > 0}" aria-labelledby="dLabel">
								<li v-for="item in addressList" @click="addAddress(item)">
									<p class="tagline">{{ item.description }}</p>
								</li>
							</ul>
						</div>

						<div class="row mb-4 px-3 w-100" v-for="(item, index) in placesForm">
							<div class="col-2 col-sm-1"></div>
							<div class="col-10 col-sm-11 d-flex align-items-center">
								<p class="mb-0">{{ item.name }}</p>
								<a role="button" class="pointer" @click="removeAddress(index)">
									<i class="fa fa-times pl-3"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer flex-wrap">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" @click="updateServices">Apply</button>
					<div class="clearfix w-100"></div>
					<p class="w-100 mt-3"> <strong>Please note:</strong> Edits may be reviewed for quality and can take up to 3 days to be published. <a href="#!">Learn more</a> </p>
				</div>
			</div>
		</div>
	</div>

	<!-- Phone modal -->
	<div class="modal fade" id="edit_phone" tabindex="-1" role="dialog" aria-labelledby="edit_phone" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" >Phone</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<div class="row inquiry-form">
						<div class="col-12 has-float-label mb-4">
							<vue-tel-input
							name="phone"
							id="tel-input"
							placeholder="Primary phone"
							v-model="phoneForm"
							:mode="'international'"
							@onInput="onInput"></vue-tel-input>
						</div>
					</div>
				</div>
				<div class="modal-footer flex-wrap">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" @click="updatePhone">Apply</button>
					<div class="clearfix w-100"></div>
					<p class="w-100 mt-3"> <strong>Please note:</strong> Edits may be reviewed for quality and can take up to 3 days to be published. <a href="#!">Learn more</a> </p>
				</div>
			</div>
		</div>
	</div>

	<!-- Website modal -->
	<div class="modal fade" id="edit_url" tabindex="-1" role="dialog" aria-labelledby="edit_url" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" >Website</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<p class="mb-4">Enter URLs to improve business info. Only enter URLs with live websites.</p>
					<div class="row inquiry-form">
						<div class="col-12">
							<div class="form-group input-group mb-4">
								<span class="has-float-label">
									<input type="text" class="form-control" id="website-url" name="website" placeholder="Website" v-model="websiteForm" />
									<label class="control-label" for="website-url">Website</label>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer flex-wrap">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" @click="updateWebsite">Apply</button>
					<div class="clearfix w-100"></div>
					<p class="w-100 mt-3"> <strong>Please note:</strong> Edits may be reviewed for quality and can take up to 3 days to be published. <a href="#!">Learn more</a> </p>
				</div>
			</div>
		</div>
	</div>

	<!-- Attr modal -->
	<div class="modal fade" id="edit_attribute" tabindex="-1" role="dialog" aria-labelledby="edit_attribute" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" >Attributes</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body attribute-wrap">
					<p class="mb-2">Only attributes you can edit are shown below. <a href="#!">Learn more</a></p>
					<div class="row inquiry-form">
						<div class="col-12 mb-2"> <strong>Highlights</strong> </div>
						<div class="col-12">
							<span class="badge badge-pill px-3 py-1 mt-2 font-16 pointer" :class="[attributeForm == false ? 'alert-secondary' : '']" @click="changeAttr">
								<span class="d-inline-block align-middle font-semi-bold pr-2" v-if="attributeForm == false ">
									<i class="fa fa-ban text-dark"></i>
								</span>
								<span class="d-inline-block align-middle font-semi-bold plus-txt pr-2" v-if="attributeForm == null ">
									<i class="fa fa-plus plus-txt"></i>
								</span>
								<span class="d-inline-block align-middle font-semi-bold plus-txt pr-2" v-if="attributeForm == true ">
									<i class="fa fa-check plus-txt"></i>
								</span>
								<span class="d-inline-block align-middle">Women-Led</span>
							</span>
						</div>
					</div>
				</div>
				<div class="modal-footer flex-wrap">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" @click="updateAttribute">Apply</button>
					<div class="clearfix w-100"></div>
					<p class="w-100 mt-3"> <strong>Please note:</strong> Edits may be reviewed for quality and can take up to 3 days to be published. <a href="#!">Learn more</a> </p>
				</div>
			</div>
		</div>
	</div>

	<!-- Description modal -->
	<div class="modal fade" id="edit_business" tabindex="-1" role="dialog" aria-labelledby="edit_business" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" >From the business</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body attribute-wrap">
					<p class="mb-4">Write a brief description of your business. <a href="#!">Learn more</a></p>
					<div class="row inquiry-form">
						<div class="col-12">
							<div class="form-group input-group mb-4">
								<span class="has-float-label">
									<textarea class="border-top-0 border-right-0 border-left-0" v-model="descriptionForm" maxlength="750"></textarea>
									<div class="w-100 text-right">{{ descriptionForm.length }}/750</div>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer flex-wrap">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" @click="updateDescription">Apply</button>
					<div class="clearfix w-100"></div>
					<p class="w-100 mt-3"> <strong>Please note:</strong> Edits may be reviewed for quality and can take up to 3 days to be published. <a href="#!">Learn more</a> </p>
				</div>
			</div>
		</div>
	</div>

	<!-- StoreCode modal -->
	<div class="modal fade" id="edit_store-code" tabindex="-1" role="dialog" aria-labelledby="edit_store-code" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" >Store code</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body attribute-wrap">
					<p class="mb-4">A store code is a unique ID for each listing in your account. Store codes can be seen by anyone that manages that  ocation on Google. <a href="#!">Learn more</a></p>
					<div class="row inquiry-form">
						<div class="col-12">
							<div class="form-group input-group mb-4">
								<span class="has-float-label">
									<input type="text" class="form-control" id="login-email" name="email" placeholder="Store code" v-model="storeCodeForm" />
									<label class="control-label" for="login-email">Store code</label>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer flex-wrap">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" @click="updateStoreCode">Apply</button>
					<div class="clearfix w-100"></div>
					<p class="w-100 mt-3"> <strong>Please note:</strong> Edits may be reviewed for quality and can take up to 3 days to be published. <a href="#!">Learn more</a> </p>
				</div>
			</div>
		</div>
	</div>

	<!-- SpecialHours modal -->
	<div class="modal fade" id="edit_hours" tabindex="-1" role="dialog" aria-labelledby="edit_hours" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" >Special hours</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body attribute-wrap">
					<div class="row inquiry-form">
						<div class="col-12">
							<div class="mb-4 d-flex flex-column">
								<div class="d-flex align-items-center w-100 mb-3" v-for="(item, index) in specialHoursForm">
									<div class="w-25 float-left text-capitalize py-1">
										<datepicker v-model="item.date" :format="customFormat" :key="index" :id="'date-' + index"></datepicker>
									</div>
									<div class="time_switch float-left toggle mx-3">
										<label class="switch float-left mr-3 mt-2">
											<input type="checkbox" class="primary" v-model="item.active">
											<span class="slider round"></span>
										</label>
										<span class="d-inline-block mt-1">
											<template v-if="item.active">
												Open
											</template>
											<template v-else>
												Close
											</template>
										</span>
									</div>
									<div class="d-flex align-items-center w-50" v-if="item.active">
										<v-select
										class="form-control p-0 border-0"
										v-model="item.openTime"
										placeholder="Open"
										:options="timesSpecial"
										@input="changeStartTimeSpecial(index)"></v-select>

										<span class="px-3" v-if="item.openTime !== 'Fullday'">-</span>

										<v-select v-if="item.openTime !== 'Fullday'"
										class="form-control p-0 border-0"
										v-model="item.closeTime"
										placeholder="Close"
										:options="timesSpecial"
										@input="changeEndTimeSpecial(index)"></v-select>
									</div>

									<a role="button" class="pointer pl-3 close" @click="specialHoursForm.splice(index, 1)">
										<span aria-hidden="true">&times;</span>
									</a>
								</div>

								<div>
									<a role="button" class="pointer mt-2" @click="addDate">Add date</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer flex-wrap">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" @click="updateSpecialHours">Apply</button>
					<div class="clearfix w-100"></div>
					<p class="w-100 mt-3"> <strong>Please note:</strong> Edits may be reviewed for quality and can take up to 3 days to be published. <a href="#!">Learn more</a> </p>
				</div>
			</div>
		</div>
	</div>

	<!-- Photo modal -->
	<div class="modal fade" id="edit_photo" tabindex="-1" role="dialog" aria-labelledby="edit_photo" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" >Add photo</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body attribute-wrap">
					<div class="row inquiry-form">
						<div class="col-12">
							<div class="mb-4">
								<vue-dropzone
								id="customdropzone" class="custom-file"
								ref="myVueDropzone"
								:options="dropzoneOptions"
								:useCustomSlot="true"
								:include-styling="false" 
								v-on:vdropzone-success="showSuccess">
									<div class="d-flex justify-content-between align-items-end w-100 border-bottom border-secondary">
										<span>Select file...</span>
										<button class="text-capitalize btn btn-sm-blue">Browse</button>
									</div>
								</vue-dropzone>

								<div class="pt-4 photo-block d-flex justify-content-center align-items-center" v-if="uploadedImage" v-for="(item, index) in uploadedImage">
									<img :src="'/storage' + item.url" alt="item" class="w-100">
									<i class="fa fa-2x fa-times pointer" @click="uploadedImage.splice(index, 1)"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer flex-wrap">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" @click="updatePhoto">Apply</button>
					<div class="clearfix w-100"></div>
					<p class="w-100 mt-3"> <strong>Please note:</strong> Edits may be reviewed for quality and can take up to 3 days to be published. <a href="#!">Learn more</a> </p>
				</div>
			</div>
		</div>
	</div>


	<!-- Error modal -->
	<div class="modal" id="error_modal" tabindex="-1" role="dialog" aria-labelledby="error_modal" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<div class="row inquiry-form flex-column">
						<p class="text-center mb-4">{{ errorMsg }}</p>
						<small class="mb-3 pl-4" v-for="item in errorDetails">{{ item }}</small>
					</div>
				</div>
				<div class="modal-footer flex-wrap">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
				</div>
			</div>
		</div>
	</div>

	</div>
</template>
<script>
	import LineChart from '../charts/LineChart.js'
	import vSelect from "vue-select"
	import vue2Dropzone from 'vue2-dropzone'
	import { VueTelInput } from 'vue-tel-input'
	import { required } from 'vuelidate/lib/validators'
	import Datepicker from 'vuejs-datepicker'
	import { Datetime } from 'vue-datetime'
	import 'vue-datetime/dist/vue-datetime.css'
	import moment from 'moment'
	import ScanResult from './ScanResult'

	export default {
		name: 'EditLocation',

		components: {
			LineChart,
			vSelect,
			VueTelInput,
			Datetime,
			Datepicker,
			vueDropzone: vue2Dropzone,
			ScanResult,
		},

		props: ['location', 'tab'],

		data() {
			return {
				errorMsg: null,
				errorDetails: [],
				icon: {
                url: '/assets/images/icons/map_location_small.png'
             },
             chartData: [
	             ['Day', 'Calls'],
	             ['Mon', 500],
	             ['Tue', 500],
	             ['Wed', 0],
	             ['Thu', 0],
	             ['Fri', 0],
	             ['Set', 1000],
	             ['Sun', 0],
             ],
             chartDataActions: [
	             ['Day', 'Visit your website', 'Request directions', 'Call you'],
	             ['Aug 11', 0, 3, 1],
	             ['', 2, 0, 0],
	             ['', 0, 1, 0],
	             ['Aug 19', 3, 2, 1],
	             ['', 1, 0, 3],
	             ['', 0, 4, 0],
	             ['Aug 25', 0, 0, 1]
             ],
             chartOptions: {
             	colors: ['#9fdf9f', '#f0f075', '#3366cc'],
             	chart: {
             		title: '',
             		subtitle: '',
             	}
             },
             disabled: false,
				countries: [],
				uploadedImage: [],
				phoneValid: true,
				dropzoneOptions: {
					dictDefaultMessage: 'Select file...',
					method: 'POST',
					url: '/api/v1/image/listing/upload',
					acceptedFiles: ".png, .jpg, .jpeg",
				},
				showCountry: '',
				addressList: [],
				address: '',
				form: {
					description: '',
					hours: [],
					website: '',
					phone: '',
					raw_data: {
						address: {},
						primaryPhone: '',
						profile: {
						 description: ''			
						}
					}
				},
				addressForm: {
					zip: null,
					country: '',
					province: '',
					position: {
						latitude: 45,
						longitude: 45
					}
				},
				defaultLatLng: {
					lat: 25,
					lng: 55.33333,
				},
				week: ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'],
				times: ['Fullday', '00:00', '00:30', '01:00', '01:30', '02:00', '02:30', '03:00', '03:30', '04:00', '04:30', '05:00', '05:30', '06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '21:00', '21:30', '22:00', '22:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30'],
				timesSpecial: ['Fullday', '00:00', '00:30', '01:00', '01:30', '02:00', '02:30', '03:00', '03:30', '04:00', '04:30', '05:00', '05:30', '06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '21:00', '21:30', '22:00', '22:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30', '24:00'],
				phoneForm: null,
				descriptionForm: '',
				websiteForm: '',
				storeCodeForm: '',
				specialHoursForm: [],
				attributeForm: null,
				placesForm: [],
				hoursForm: [],
				provinces: [],
			}
		},

		validations: {
			addressForm: {
				country: { required },
				street: { required },
				city: { required },
				// zip: {required },
				// state: { required }
			}
		},

		watch: {
			'addressForm.country'(val) {
				if (val) {
					axios.get('/api/geo/children/' + val.id)
						.then(response => {
							let code = this.form.raw_data.address && this.form.raw_data.address.regionCode ? this.form.raw_data.address.regionCode : this.form.country
							if(code !== val.country) {
								this.addressForm.state = ''
							}
							this.provinces = response.data
						})
						.catch(error => {
							console.error(error.response.data.message)
						})
				} else {
					this.addressForm.state = ''
					this.provinces = []
				}
			},

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

		computed: {
			hasRegularHours() {
				if(this.form.raw_data.regularHours && this.form.raw_data.regularHours.periods) {
					for (var i = 0; i < this.form.raw_data.regularHours.periods.length; i++) {
						if(this.form.raw_data.regularHours.periods[i].active) {
							return true
						}
					}
				}
				return false
			},
			formPosition() {
				return {
					lat: parseFloat(this.addressForm.position.latitude),
					lng: parseFloat(this.addressForm.position.longitude)
				}
			},
			formCenter() {
				return {
					lat: parseFloat(this.addressForm.position.latitude),
					lng: parseFloat(this.addressForm.position.longitude)
				}
			},
			position() {
				return {
					lat: this.checkLat(),
					lng: this.checkLng()
				}
			},
			center() {
				if (this.isValidLatLong(this.checkLat(), this.checkLng())) {
					return {
						lat: this.checkLat(),
						lng: this.checkLng()
					}
				} else {
					return this.defaultLatLng
				}
			}
		},

		mounted() {
			if(this.tab == 'insights') {
				$('#zones-tab').click()
			}
		},

		methods: {
			checkLat() {
				if(this.form.raw_data.latlng) {
					return parseFloat(this.form.raw_data.latlng.latitude)
				} else {
					return this.form.latitude ? parseFloat(this.form.latitude) : 0
				}
			},

			checkLng() {
				if(this.form.raw_data.latlng) {
					return parseFloat(this.form.raw_data.latlng.longitude)
				} else {
					return this.form.longitude ? parseFloat(this.form.longitude) : 0
				}
			},

			onInput({ number, isValid, country }) {
	        this.phoneValid = isValid;
	      },

			customFormat(date) {
				return moment(date).format('DD MM YYYY');
			},

			updateAddress() {
				this.$v.addressForm.$touch();
				let isValid = !this.$v.addressForm.$invalid;

				if(isValid) {

					this.$set(this.form.raw_data, 'latlng', {
						latitude: this.addressForm.position.latitude,
						longitude: this.addressForm.position.longitude
					})

					this.form.raw_data.address.addressLines[0] = this.addressForm.street
					this.form.raw_data.address.postalCode = this.addressForm.zip
					this.form.raw_data.address.locality = this.addressForm.city
					this.form.raw_data.address.administrativeArea = this.addressForm.state && this.addressForm.state.name ? this.addressForm.state.name : this.addressForm.state
					this.form.raw_data.address.latlng = this.addressForm.position
					this.showCountry = this.addressForm.country.name ? this.addressForm.country.name : this.addressForm.country
					this.form.raw_data.address.regionCode = this.addressForm.country.country ? this.addressForm.country.country : this.addressForm.country

					$('#edit_location').modal('hide')
				}
			},

			updateHours() {
				for (var i = 0; i < this.hoursForm.length; i++) {
					if(this.hoursForm[i].openTime == 'Fullday' || this.hoursForm[i].closeTime == 'Fullday') {
						this.hoursForm[i].openTime = '00:00'
						this.hoursForm[i].closeTime = '24:00'
					} else {
						let openTime = 0;
						let closeTime = 0;
						for (var t = 0; t < this.times.length; t++) {
							if(this.times[t] == this.hoursForm[i].openTime) {
								openTime = t
							}
							if(this.times[t] == this.hoursForm[i].closeTime) {
								closeTime = t
							}
						}

						if(openTime >= closeTime) {
							this.hoursForm[i].closeTime = '24:00'
						}
						if(!this.hoursForm[i].openTime || !this.hoursForm[i].closeTime) {
							this.hoursForm[i].active = false
						}

						if(!this.hoursForm[i].active) {
							this.hoursForm[i].openTime = null
							this.hoursForm[i].closeTime = null
						}
					}
				}

				if(this.form.raw_data.regularHours) {
					this.form.raw_data.regularHours.periods = JSON.parse(JSON.stringify(this.hoursForm));
				} else {
					this.$set(this.form.raw_data, 'regularHours', {
						periods: JSON.parse(JSON.stringify(this.hoursForm))
					})
				}
				$('#edit_time').modal('hide')
			},

			updatePhone() {
				if(this.phoneValid || (!this.phoneValid && !this.phoneForm)) {
					this.form.raw_data.primaryPhone = this.phoneForm
					$('#edit_phone').modal('hide')
				}
			},

			updateWebsite() {
				this.form.website = this.websiteForm
				$('#edit_url').modal('hide')
			},

			showDescription() {
				this.descriptionForm = this.form.raw_data.profile.description
			},

			updateDescription() {
				this.form.raw_data.profile.description = this.descriptionForm
				$('#edit_business').modal('hide')
			},

			updateStoreCode() {
				this.form.raw_data.storeCode = this.storeCodeForm
				$('#edit_store-code').modal('hide')
			},

			updatePhoto() {
				this.form.raw_data.photos = JSON.parse(JSON.stringify(this.uploadedImage));
				$('#edit_photo').modal('hide')
			},

			updateServices() {
				this.form.raw_data.serviceArea.places.placeInfos = JSON.parse(JSON.stringify(this.placesForm));
				$('#edit_Servicearea').modal('hide')
			},

			checkUnique(arr, item) {
				for (var i = 0; i < arr.length; i++) {
					if(arr[i].startDate.day == item.day && arr[i].startDate.month == item.month && arr[i].startDate.year == item.year) {
						return false
					}
				}
				return true
			},

			updateSpecialHours() {
				let uniqueArray = []

				for (var i = 0; i < this.specialHoursForm.length; i++) {
					if(this.specialHoursForm[i].date) {
						let googleDate = {
							day: this.specialHoursForm[i].date.getDate(),
							month: this.specialHoursForm[i].date.getMonth() + 1,
							year: this.specialHoursForm[i].date .getFullYear()
						}

						if(!this.specialHoursForm[i].active) {
							this.specialHoursForm[i].isClosed = true
							this.specialHoursForm[i].startDate = googleDate
						} else {
							if(this.specialHoursForm[i].isClosed) {
								delete this.specialHoursForm[i].isClosed
							}
							this.specialHoursForm[i].startDate = googleDate
							this.specialHoursForm[i].endDate = googleDate
						}
						
						if(this.checkUnique(uniqueArray, googleDate)) {
							if(!this.specialHoursForm[i].active || (this.specialHoursForm[i].active && this.specialHoursForm[i].openTime)) {
								 if(this.specialHoursForm[i].openTime == 'Fullday' || this.specialHoursForm[i].closeTime == 'Fullday') {
								 	this.specialHoursForm[i].openTime = '00:00'
								 	this.specialHoursForm[i].closeTime = '24:00'
								 }
								let openTime = 0;
								let closeTime = 0;
								for (var t = 0; t < this.timesSpecial.length; t++) {
								 	if(this.timesSpecial[t] == this.specialHoursForm[i].openTime) {
								 		openTime = t
								 	}
								 	if(this.timesSpecial[t] == this.specialHoursForm[i].closeTime) {
								 		closeTime = t
								 	}
								 }

								 if(openTime >= closeTime) {
								 	this.specialHoursForm[i].closeTime = '24:00'
								 }


								uniqueArray.push(this.specialHoursForm[i])
							}
						}
					}
				}
				if(this.form.raw_data.specialHours) {
					this.form.raw_data.specialHours.specialHourPeriods = JSON.parse(JSON.stringify(uniqueArray));
				} else {
					this.$set(this.form.raw_data, 'specialHours', {
						specialHourPeriods: JSON.parse(JSON.stringify(uniqueArray))
					})
				}
				$('#edit_hours').modal('hide')
			},

			updateAttribute() {
				if(this.attributeForm == null) {
					this.form.raw_data.attributes = null
				} else {
					this.$set(this.form.raw_data, 'attributes', [
						{
							attributeId: "is_owned_by_women",
							valueType: "BOOL",
							values: [this.attributeForm]
						}
					])
				}
				$('#edit_attribute').modal('hide')
			},

			changeAttr() {
				if(this.attributeForm == null) {
					this.attributeForm = true
				} else if(this.attributeForm == true) {
					this.attributeForm = false
				} else {
					this.attributeForm = null
				}
			},

			removeAddress(index) {
				this.placesForm.splice(index, 1)
			},

			addAddress(item) {
				this.address = ''

				if(this.checkAddress(item)) {
					this.placesForm.push({
						name: item.description,
						placeId: item.place_id
					})
				}
			},

			checkAddress(item) {
				for (var i = 0; i < this.placesForm.length; i++) {
					if(this.placesForm[i].description == item.description) {
						return false
					}
				}

				return true
			},

			changeStartTime(index) {
				if(this.hoursForm[index].openTime == 'Fullday') {
					this.hoursForm[index].closeTime = 'Fullday'
				}
				if(this.hoursForm[index].openTime !== 'Fullday' && this.hoursForm[index].closeTime == 'Fullday') {
					this.hoursForm[index].closeTime = null
				}
			},

			changeEndTime(index) {
				if(this.hoursForm[index].closeTime == 'Fullday') {
					this.hoursForm[index].openTime = 'Fullday'
				}
			},

			changeStartTimeSpecial(index) {
				if(this.specialHoursForm[index].openTime == 'Fullday') {
					this.specialHoursForm[index].closeTime = 'Fullday'
				}
				if(this.specialHoursForm[index].openTime !== 'Fullday' && this.specialHoursForm[index].closeTime == 'Fullday') {
					this.specialHoursForm[index].closeTime = null
				}
			},

			changeEndTimeSpecial(index) {
				if(this.specialHoursForm[index].closeTime == 'Fullday') {
					this.specialHoursForm[index].openTime = 'Fullday'
				}
			},

			getCoordinatesForm(e) {
				this.addressForm.position.latitude = e.latLng.lat()
				this.addressForm.position.longitude = e.latLng.lng()
			},

			getProvinces(id) {
				axios.get('/api/geo/children/' + id)
				.then(response => {
					this.provinces = response.data
				})
				.catch(error => {
					console.error(error.response.data.message)		
				})
			},

			updateLocation() {
				let sendData = JSON.parse(JSON.stringify(this.form.raw_data))
				let googlePeriods = []

				if(sendData.regularHours) {
					for (var i = 0; i < sendData.regularHours.periods.length; i++) {
						if((sendData.regularHours.periods[i].openTime == 'Fullday' || sendData.regularHours.periods[i].closeTime == 'Fullday') && sendData.regularHours.periods[i].active == true) {
							sendData.regularHours.periods[i].openTime = '00:00'
							sendData.regularHours.periods[i].closeTime = '24:00'
						}


						if(sendData.regularHours.periods[i].openTime && sendData.regularHours.periods[i].closeTime && sendData.regularHours.periods[i].active) {
							delete sendData.regularHours.periods[i].active
							googlePeriods.push(sendData.regularHours.periods[i])
						}
					}
				}

				if(sendData.specialHours) {
					for (var i = 0; i < sendData.specialHours.specialHourPeriods.length; i++) {
						delete sendData.specialHours.specialHourPeriods[i].active
						delete sendData.specialHours.specialHourPeriods[i].date
						if(sendData.specialHours.specialHourPeriods[i].isClosed) {
							delete sendData.specialHours.specialHourPeriods[i].openTime
							delete sendData.specialHours.specialHourPeriods[i].closeTime
							delete sendData.specialHours.specialHourPeriods[i].endDate
						}
					}
				}

				if(sendData.attributes == null) {
					delete sendData.attributes
				}

				sendData.regularHours.periods = googlePeriods

				if(sendData.regularHours.periods.length == 0) {
					delete sendData.specialHours
					delete sendData.regularHours
				}

				this.disabled = true
				axios.put('/api/v1/locations/' + this.location.id, sendData)
				.then(response => {
					window.location.href = '/manage-locations'
					this.disabled = false
				})
				.catch(error => {
					try {
						let errorJSON = JSON.parse(error.response.data.message)
						this.errorMsg = errorJSON && errorJSON.error && errorJSON.error.message ? errorJSON.error.message : error.response.data.message
						this.errorDetails = []
						if(errorJSON && errorJSON.error && errorJSON.error.details)
						for (var i = 0; i < errorJSON.error.details.length; i++) {
							if(errorJSON.error.details[i].errorDetails) {
								for (var x = 0; x < errorJSON.error.details[i].errorDetails.length; x++) {
									let msg = errorJSON.error.details[i].errorDetails[x].field + ' - ' + errorJSON.error.details[i].errorDetails[x].message
									this.errorDetails.push(msg)
								}
							}
						}
						$('#error_modal').modal('show')
						this.disabled = false	
					} catch (e) {
						this.$set(this, 'errorMsg', error.response.data.message);
						$('#error_modal').modal('show')
						this.disabled = false
						return false;
					}
				})
			},

			getCountry() {
				axios.get('/api/geo/countries')
				.then(response => {
					this.countries = response.data
					for (var i = 0; i < response.data.length; i++) {
						let code = this.form.raw_data.address && this.form.raw_data.address.regionCode ? this.form.raw_data.address.regionCode : this.form.country
					 	if(response.data[i].country == code) {
					 		this.addressForm.country = response.data[i]
							this.showCountry = response.data[i].name
					 	}
					}
				})
				.catch(error => {
					console.error(error.response.data.message)		
				})
			},

			showLocation() {
				if(this.form.raw_data.address) {
					axios.get('/api/geo/countries')
					.then(response => {
						this.countries = response.data
						for (var i = 0; i < response.data.length; i++) {
						 	if(response.data[i].country == this.form.raw_data.address.regionCode) {
								this.addressForm = {
									country: response.data[i],
									street: this.form.raw_data.address.addressLines[0],
									zip: this.form.raw_data.address.postalCode,
									city: this.form.raw_data.address.locality,
									state: this.form.raw_data.address.administrativeArea
								}

								if(this.form.raw_data.latlng) {
									this.$set(this.addressForm, 'position', {
										latitude: this.form.raw_data.latlng.latitude,
										longitude: this.form.raw_data.latlng.longitude
									})
								} else {
									if(this.form.latitude && this.form.longitude) {
										this.$set(this.addressForm, 'position', {
											latitude: this.form.latitude,
											longitude: this.form.longitude
										})
									} else {
										this.$set(this.addressForm, 'position', {
											latitude: 0,
											longitude: 0
										})
										this.getLatLng()
									}
								}
								this.showCountry = response.data[i].name
						 	}
						}
					})
					.catch(error => {
						console.error(error.response.data.message)		
					})
				}
			},

			getLatLng() {
				let url = this.addressForm.country.country + ', ' + this.addressForm.city + ', ' + this.addressForm.street
				axios.get('/api/v1/places/search/' + url)
				.then(response => {
					let result = response.data.predictions
					if(result.length > 0) {
						axios.get('/api/v1/places/' + result[0].place_id + '/details')
						.then(responseDetails => {
							 this.$set(this.addressForm, 'position', {
							 	latitude: responseDetails.data.result.geometry.location.lat,
							 	longitude: responseDetails.data.result.geometry.location.lng
							 })
						})
						.catch(error => {

						})
					}
				})
			},

			showHours() {
				this.hoursForm = [
					{"openDay": "MONDAY", "closeDay": "MONDAY", "openTime": "", "closeTime": "", active: false},
					{"openDay": "TUESDAY", "closeDay": "TUESDAY", "openTime": "", "closeTime": "", active: false},
					{"openDay": "WEDNESDAY", "closeDay": "WEDNESDAY", "openTime": "", "closeTime": "", active: false},
					{"openDay": "THURSDAY", "closeDay": "THURSDAY", "openTime": "", "closeTime": "", active: false},
					{"openDay": "FRIDAY", "closeDay": "FRIDAY", "openTime": "", "closeTime": "", active: false},
					{"openDay": "SATURDAY", "closeDay": "SATURDAY", "openTime": "", "closeTime": "", active: false},
					{"openDay": "SUNDAY", "closeDay": "SUNDAY", "openTime": "", "closeTime": "", active: false}
				]

				if(this.form.raw_data.regularHours && this.form.raw_data.regularHours.periods) {
					for (var i = 0; i < this.form.raw_data.regularHours.periods.length; i++) {
						let item = this.form.raw_data.regularHours.periods[i]
						if(item.openTime && item.openTime.length > 0) {
							item.active = true
						} else {
							item.active = false
						}
						for (var d = 0; d < this.hoursForm.length; d++) {
							if(this.hoursForm[d].openDay == item.openDay) {
								if(item.openTime == '00:00' && item.closeTime == '24:00') {
									this.hoursForm[d].openTime = 'Fullday'
									this.hoursForm[d].closeTime = null
								} else {
									this.hoursForm[d].openTime = item.openTime
									this.hoursForm[d].closeTime = item.closeTime
								}
								this.hoursForm[d].active = item.active
							}
						}
					}
				} else {
					this.$set(this.form.raw_data, 'regularHours', {
						periods: []
					})
				}

				this.form.raw_data.regularHours.periods = JSON.parse(JSON.stringify(this.hoursForm));
			},

			showServices() {
				if(!this.form.raw_data.serviceArea) {
					this.$set(this.form.raw_data, 'serviceArea', {
						places: {
							placeInfos: []
						}
					})
				} else {
					this.placesForm = JSON.parse(JSON.stringify(this.form.raw_data.serviceArea.places.placeInfos));
				}
			},

			showAttribute() {
				if(!this.form.raw_data.attributes) {
					this.attributeForm = null
				} else {
					this.attributeForm = this.form.raw_data.attributes[0].values[0]
				}
			},

			showSpecialHours() {
				if(!this.form.raw_data.specialHours) {
					this.$set(this.form.raw_data, 'specialHours', {
						specialHourPeriods: []
					})
				} else {
					this.specialHoursForm = JSON.parse(JSON.stringify(this.form.raw_data.specialHours.specialHourPeriods));

					for (var i = 0; i < this.specialHoursForm.length; i++) {
						if((this.specialHoursForm[i].openTime == '00:00' && this.specialHoursForm[i].closeTime == '00:00') || (this.specialHoursForm[i].openTime == '00:00' && this.specialHoursForm[i].closeTime == '24:00')) {
							this.specialHoursForm[i].openTime = 'Fullday'
							this.specialHoursForm[i].closeTime = null
						}
						if(this.specialHoursForm[i].startDate && this.specialHoursForm[i].startDate.year) {
							this.specialHoursForm[i].date = new Date(this.specialHoursForm[i].startDate.year, this.specialHoursForm[i].startDate.month - 1 ,this.specialHoursForm[i].startDate.day)
						}
						if(this.specialHoursForm[i].isClosed) {
							this.$set(this.specialHoursForm[i], 'active', false)
						} else {
							this.$set(this.specialHoursForm[i], 'active', true)
						}
					}
				}
			},

			showPhotos() {
				this.uploadedImage = JSON.parse(JSON.stringify(this.form.raw_data.photos));
			},

			addDate() {
				this.specialHoursForm.push({"date": "", "openTime": null, "closeTime": null, active: false})
			},

			showSuccess(response) {
				let resp = JSON.parse(response.xhr.response)
				this.uploadedImage.push({
					url: resp.image_url
				})
			},
			isValidLatLong: function(latitude, longitude) {
				return !isNaN(latitude) && !isNaN(longitude) && (latitude != 0 || longitude != 0);
			}
		},

		created() {
			this.form = JSON.parse(JSON.stringify(this.location));

			if(!this.form.raw_data.latlng && this.form.raw_data.address) {
				let url = this.form.raw_data.address.regionCode + ', ' + this.form.raw_data.address.locality + ', ' + this.form.raw_data.address.addressLines[0]

				axios.get('/api/v1/places/geocode/' + url)
				.then(response => {
					if(response.data.results.length > 0) {
						this.$set(this.form, 'latitude', response.data.results[0].geometry.location.lat)
						this.$set(this.form, 'longitude', response.data.results[0].geometry.location.lng)
					}
				})
			}

			if(this.form.raw_data.specialHours && this.form.raw_data.specialHours.specialHourPeriods) {
				for (var i = 0; i < this.form.raw_data.specialHours.specialHourPeriods.length; i++) {
					this.form.raw_data.specialHours.specialHourPeriods[i].endDate = this.form.raw_data.specialHours.specialHourPeriods[i].startDate
					if(this.form.raw_data.specialHours.specialHourPeriods[i].closeTime == '00:00') {
						this.form.raw_data.specialHours.specialHourPeriods[i].closeTime = '24:00'
					}
				}
			}

			if(!this.form.raw_data.profile) {
				this.$set(this.form.raw_data, 'profile', {
					'description' : ''
				})
			}

			if(!this.form.raw_data.storeCode) {
				this.$set(this.form.raw_data, 'storeCode', '')
			}

			if(!this.form.raw_data.places) {
				this.$set(this.form.raw_data, 'places', [])
			}

			if(!this.form.raw_data.photos) {
				this.$set(this.form.raw_data, 'photos', [])
			}

			this.websiteForm = this.form.website

			this.phoneForm = this.form.raw_data.primaryPhone
			
			this.getCountry()

			this.showHours()
		}
	}
</script>