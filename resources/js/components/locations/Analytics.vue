<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="bg-white border_2">
                    <div class="col-12">
                        <div class="row select-sec revews-selectbox px-2">
                            <!--<div class="col py-2">
                                <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                          placeholder="Locations"
                                          label="title"
                                          :resetOnOptionsChange="true"
                                          :filterable="false"
                                          v-model="filterLocations.location"
                                          :options="locations">
                                    <template #search="{attributes, events}">
                                        <input
                                                class="vs__search"
                                                autocomplete="new-username"
                                                v-bind="attributes"
                                                v-on="events"/>
                                    </template>
                                </v-select>
                            </div>-->
                            <!--<div class="col py-2">
                                <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                          placeholder="Sources"
                                          label="title"
                                          :resetOnOptionsChange="true"
                                          :filterable="false"
                                          v-model="filterLocations.source"
                                          :options="sources">
                                    <template #search="{attributes, events}">
                                        <input
                                                class="vs__search"
                                                autocomplete="new-username"
                                                v-bind="attributes"
                                                v-on="events"/>
                                    </template>
                                </v-select>
                            </div>-->
                            <div class="col py-2">
                                <!--<v-select class="custom-v-select form-control select-bottom-0 py-0"
                                          placeholder="Rating"
                                          label="title"
                                          :resetOnOptionsChange="true"
                                          :filterable="false"
                                          v-model="filterLocations.rating"
                                          :options="ratings">
                                    <template #search="{attributes, events}">
                                        <input
                                                class="vs__search"
                                                autocomplete="new-username"
                                                v-bind="attributes"
                                                v-on="events"/>
                                    </template>
                                </v-select>-->
                                <div>Rating Range: {{ filterLocations.rating[0] }} - {{ filterLocations.rating[1] }}</div>
                                <vue-slider
                                        class="border-0 bold-txt txt-gray px-2"
                                        v-model="filterLocations.rating"
                                        :dot-style="{ backgroundColor: 'rgb(51, 148, 214)', borderColor: 'rgb(51, 148, 214)' }"
                                        :process-style="{ backgroundColor: 'rgb(51, 148, 214)' }"
                                        :min="0"
                                        :max="5"
                                        :tooltip="'none'">
                                </vue-slider>
                            </div>
                            <div class="col py-2">
                                <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                          placeholder="Statuses"
                                          label="title"
                                          :resetOnOptionsChange="true"
                                          :filterable="false"
                                          v-model="filterLocations.status"
                                          :options="statuses">
                                    <template #search="{attributes, events}">
                                        <input
                                                class="vs__search"
                                                autocomplete="new-username"
                                                v-bind="attributes"
                                                v-on="events"/>
                                    </template>
                                </v-select>
                            </div>
                            <!--<div class="col py-2">
                                <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                          placeholder="Reviews"
                                          label="title"
                                          :resetOnOptionsChange="true"
                                          :filterable="false"
                                          v-model="filterLocations.review"
                                          :options="reviews">
                                    <template #search="{attributes, events}">
                                        <input
                                                class="vs__search"
                                                autocomplete="new-username"
                                                v-bind="attributes"
                                                v-on="events"/>
                                    </template>
                                </v-select>
                            </div>-->
                            <!-- <div class="col py-2">
                                <select class="form-control">
                                    <option value="" selected="">Clear All</option>
                                    <option value="Locations # 1">Clear All # 1</option>
                                    <option value="Locations # 2">Clear All # 2</option>
                                    <option value="Locations # 3">Clear All # 3</option>
                                    <option value="Locations # 4">Clear All # 4</option>
                                </select>
                            </div> -->
                        </div>
                    </div>
                    <div class="row mr-0">

                        <div class="col-lg-8 col-12 px-10 px-r-0 pr-md-0">
                            <div class="w-100 bg-white px-3 h-100 pt-3 pb-3">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <h1 class="reviews-page-title font-weight-normal mb-3 mt-0">My Locations</h1>
                                    </div>
                                    <!--<div class="col-lg-9 col-sm-6 col-12 mb-lg-0 mb-3">
                                        <span class="float-left float-sm-right">
											<div class="d-inline-block float-left mt-1 mr-2 text-muted">Heatmap</div>
											<div class="toggle listing-switch toggle_small d-inline-block float-left mr-2 mt-2">
												<label class="switch"><input type="checkbox" class="primary"/><span class="slider round"></span></label>
											</div>
                                        </span>
                                    </div>-->
                                </div>
                                <GmapMap style="width: 100%; height: 350px" :center="defaultLatLng" :zoom="8" ref="gMap">
                                    <GmapInfoWindow
                                            :options="infoOptions"
                                            :position="infoWindowPos"
                                            :opened="infoWinOpen"
                                            @closeclick="infoWinOpen=false">
                                    </GmapInfoWindow>
                                    <GmapMarker
                                            v-for="(address, index) in locations"
                                            v-if="isValidLatLong(address.latitude, address.longitude)"
                                            :key="index"
                                            :position="addressCoordinates(index)"
                                            :icon="icon"
                                            :clickable="true"
                                            @click="toggleInfoWindow(index)"/>
                                </GmapMap>
                            </div>
                        </div>


                        <div class="col-lg-4 col-12 pt-1 px-3 tab-width-set-l pb-5">
                            <h1 class="reviews-page-title font-weight-normal mb-0 mt-2">Profile Score</h1>
                            <div class="row my-5">
                                <template v-if="totals.total > 0">
                                <div class="col-xllg-7 profile-score-left col-12">
                                    <div class="easy-pie-chart-lg-xl box_center">
                                        <vue-easy-pie-chart
                                                :percent="totals.avg_score"
                                                :bar-color="trackColor"
                                                :size="250"
                                                :animate="true"
                                                :line-width="8"
                                                :line-cap="'square'"
                                                :font-size="'56px'"
                                                :font-weight="700">{{totals.profile_score}}</vue-easy-pie-chart>
                                        <div class="percent">
                                            <span class="number">{{totals.profile_score}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xllg-5 profile-score-right col-12 mt-4">
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-sm-4 d-flex align-items-center justify-content-center">
                                            <div class="inline-block left-col">
                                                <h1>{{totals.total}}</h1>
                                            </div>
                                            <div class="inline-block ml-2">
                                                <dynamics-total v-bind:percent="totals.total_dynamics"></dynamics-total>
                                                <p class="score-text text-uppercase">Total Locations</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-12 col-sm-4 d-flex align-items-center justify-content-center">
                                            <div class="inline-block left-col">
                                                <h1>{{totals.fixes_needed}}</h1>
                                            </div>
                                            <div class="inline-block ml-2">
                                                <dynamics-total v-bind:percent="totals.fixes_needed_dynamics"></dynamics-total>
                                                <p class="score-text text-uppercase">Fixes Needed</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-12 col-sm-4 d-flex align-items-center justify-content-center">
                                            <div class="inline-block left-col">
                                                <h1>{{totals.profile_score}}</h1>
                                            </div>
                                            <div class="inline-block ml-2">
                                                <dynamics-total v-bind:percent="totals.profile_score_dynamics"></dynamics-total>
                                                <p class="score-text text-uppercase">Profile Score</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </template>
                                <template v-else>
                                    <div class="col-12 text-center pt-5">
                                        <div class="pt-5 font-46 text_light_gray">
                                            No data
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-8 col-12">
                <div class="white-rounded-box rounded-0 pt-2 pb-3">
                    <h1 class="reviews-page-title font-weight-normal mb-4 mt-2">Score by Site</h1>
                    <div class="map_wrap">
                        <h-line-chart id="score-by-site" v-bind:categories="sbsMonths" v-bind:series="sbsSeries"></h-line-chart>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="w-100 bg-white px-3 h-100 py-3 performance_sec">
                    <h1 class="reviews-page-title font-weight-normal mb-3 mt-0">Performance</h1>
                    <div class="clearfix"></div>
                    <div class="row ml_15">
                        <!--<div class="col">
                            <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                      placeholder="Locations"
                                      label="title"
                                      :resetOnOptionsChange="true"
                                      :filterable="false"
                                      v-model="filterLocations.location"
                                      :options="locations">
                                <template #search="{attributes, events}">
                                    <input
                                            class="vs__search"
                                            autocomplete="new-username"
                                            v-bind="attributes"
                                            v-on="events"/>
                                </template>
                            </v-select>
                        </div>-->
<!--                        <div class="col">
                            <v-select placeholder="Period"
                                    label="title"
                                    :clearable="false"
                                    class="custom-v-select form-control select-bottom-0 py-0"
                                    v-model="filterPerformance.preset"
                                    :options="periods">
                                <template #search="{attributes, events}">
                                    <input
                                            class="vs__search"
                                            autocomplete="new-username"
                                            v-bind="attributes"
                                            v-on="events"/>
                                </template>
                            </v-select>

                            <v-date-picker v-show="!filterPerformance.presetPeriod"
                                           class="w-100 input-date-range mt-2"
                                           mode='range'
                                           v-model='filterPerformance.period'
                                           show-caps></v-date-picker>
                        </div>-->
                    </div>
                    <div class="clearfix"></div>

                    <ul id="tabs" class="row nav nav-tabs mx-0 mt-2" role="tablist">
                        <li class="nav-item col text-center px-0">
                            <a id="tab-1" href="#pane-1" class="nav-link active font-18" data-toggle="tab" role="tab">
                                Views
                                <div class="clearfix"></div>
                                <span class="font-16">{{ performance.views.total }}</span>
                            </a>
                        </li>
                        <li class="nav-item col text-center px-0">
                            <a id="tab-2" href="#pane-2" class="nav-link font-18" data-toggle="tab" role="tab">
                                Searches
                                <div class="clearfix"></div>
                                <span class="font-16">{{ performance.searches.total }}</span>
                            </a>
                        </li>
                        <li class="nav-item col text-center px-0">
                            <a id="tab-3" href="#pane-3" class="nav-link font-18" data-toggle="tab" role="tab">
                                Activity
                                <div class="clearfix"></div>
                                <span class="font-16">{{ performance.activity.total }}</span>
                            </a>
                        </li>
                    </ul>

                    <div id="content" class="tab-content" role="tablist">
                        <div id="pane-1" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="tab-1">
                            <div class="collapse show" role="tabpanel" aria-labelledby="heading-1">
                                <div class="card-body p-0 pt-3 px-1">
                                    <div class="row mlr_15 flex-wrap performance_detail font-18">
                                        <div class="col-8 text-left">Search views</div>
                                        <div class="col-4 text-right">
                                            {{performance.views.VIEWS_SEARCH}}
                                            <simple-dynamics v-bind:percent="performance.views.VIEWS_SEARCH_dynamics"></simple-dynamics>
                                        </div>
                                        <hr class="col-11"/>
                                        <div class="col-8 text-left">Map Views</div>
                                        <div class="col-4 text-right">
                                            {{performance.views.VIEWS_MAPS}}
                                            <simple-dynamics v-bind:percent="performance.views.VIEWS_MAPS_dynamics"></simple-dynamics>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="pane-2" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-2">
                            <div class="collapse show" role="tabpanel" aria-labelledby="heading-2">
                                <div class="card-body p-0 pt-3 px-1">
                                    <div class="row mlr_15 flex-wrap performance_detail font-18">
                                        <div class="col-8 text-left">Direct</div>
                                        <div class="col-4 text-right">
                                            {{performance.searches.QUERIES_DIRECT}}
                                            <simple-dynamics v-bind:percent="performance.searches.QUERIES_DIRECT_dynamics"></simple-dynamics>
                                        </div>
                                        <div class="col-12 font-14">Customers who find your listing searching for your business name or address</div>
                                        <hr class="col-11"/>
                                        <div class="col-6 text-left">Discovery</div>
                                        <div class="col-6 text-right">
                                            {{performance.searches.QUERIES_INDIRECT}}
                                            <simple-dynamics v-bind:percent="performance.searches.QUERIES_INDIRECT_dynamics"></simple-dynamics>
                                        </div>
                                        <div class="col-12 font-14">Customers who find your listing searching for a category, product, or service</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="pane-3" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-3">
                            <div class="collapse show" role="tabpanel" aria-labelledby="heading-3">
                                <div class="card-body p-0 pt-3 px-1">
                                    <div class="row mlr_15 flex-wrap performance_detail font-18">
                                        <div class="col-8 text-left">Website visits</div>
                                        <div class="col-4 text-right">
                                            {{performance.activity.ACTIONS_WEBSITE}}
                                            <simple-dynamics v-bind:percent="performance.activity.ACTIONS_WEBSITE_dynamics"></simple-dynamics>
                                        </div>
                                        <hr class="col-11">
                                        <div class="col-8 text-left">Calls</div>
                                        <div class="col-4 text-right">
                                            {{performance.activity.ACTIONS_PHONE}}
                                            <simple-dynamics v-bind:percent="performance.activity.ACTIONS_PHONE_dynamics"></simple-dynamics>
                                        </div>
                                        <hr class="col-11">
                                        <div class="col-8 text-left">Photo views</div>
                                        <div class="col-4 text-right">
                                            {{performance.activity.PHOTOS_VIEWS_MERCHANT}}
                                            <simple-dynamics v-bind:percent="performance.activity.PHOTOS_VIEWS_MERCHANT_dynamics"></simple-dynamics>
                                        </div>
                                        <hr class="col-11">
                                        <div class="col-8 text-left">Direction requests</div>
                                        <div class="col-4 text-right">
                                            {{performance.activity.ACTIONS_DRIVING_DIRECTIONS}}
                                            <simple-dynamics v-bind:percent="performance.activity.ACTIONS_DRIVING_DIRECTIONS_dynamics"></simple-dynamics>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="font-14">Performance over the past 28 days</div>
                    </div>
                    <div class="clearfix mt-3"></div>
                    <div class="btn-group w-100" role="group" aria-label="Basic example">
                        <!--<button type="button" class="btn btn-tp col text-center">
                            <img src="/assets/images/create-post.jpg">
                            <div class="clearfix"></div>
                            <span>Create post</span>
                        </button>-->
                        <!--<button type="button" class="btn btn-tp col">
                            <img src="/assets/images/add-photo.jpg">
                            <div class="clearfix"></div>
                            <span>Add post</span>
                        </button>-->
                        <a role="button" class="btn btn-tp col" href="https://ads.google.com/signup?hl=en" target="_blank">
                            <img src="/assets/images/create-ad.jpg">
                            <div class="clearfix"></div>
                            <span>Create ad</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="bg-white px-3 pt-3">
                    <div class="row">
                        <div class="col-lg-6 reviews-title-cont">
                            <h1 class="reviews-page-title font-weight-normal mb-0 mt-0">See how each of your listings are for each of your locations </h1>
                            <p class="reviews-page-subtitle">For every platform you are on</p>
                        </div>
                        <div class="col-lg-6 revews-selectbox">
                            <div class="row justify-content-end">
                                <!--<div class="col-sm-4 col-12 mb-2">
                                    <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                              placeholder="Region"
                                              label="title"
                                              :resetOnOptionsChange="true"
                                              :filterable="false"
                                              v-model="filterLocations.region"
                                              :options="regions">
                                        <template #search="{attributes, events}">
                                            <input
                                                    class="vs__search"
                                                    autocomplete="new-username"
                                                    v-bind="attributes"
                                                    v-on="events"/>
                                        </template>
                                    </v-select>
                                </div>-->
                                <div class="col-sm-8 col-12 mb-2">
                                    <v-select placeholder="Period"
                                              label="title"
                                              :clearable="false"
                                              class="custom-v-select form-control select-bottom-0 py-0"
                                              v-model="filterScanResults.preset"
                                              :options="periods">
                                        <template #search="{attributes, events}">
                                            <input
                                                    class="vs__search"
                                                    autocomplete="new-username"
                                                    v-bind="attributes"
                                                    v-on="events"/>
                                        </template>
                                    </v-select>

                                    <v-date-picker v-show="!filterScanResults.presetPeriod"
                                                   class="w-100 input-date-range mt-2"
                                                   mode='range'
                                                   v-model='filterScanResults.period'
                                                   show-caps></v-date-picker>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-12">

                            <div class="toggle listing-location-switch d-inline-block float-right mt-3">
                                <label class="switch">
                                    <input type="checkbox" class="primary" v-model="toggle"/>
                                    <span class="slider round"></span>
                                </label>
                                <div class="clearfix"></div>
                                <div class="d-block text-center switch_txt text-uppercase">
                                    PLATFORM
                                </div>
                            </div>
                            <div class="float-right mt-3 mr-5 location-data-social" v-if="toggle">
                                <div class="inline-block float-left"><img src="/assets/images/google_icon.svg" class="img-fluid height_28"></div>
                                <div class="inline-block float-left ml-2"><i class="fa fa-facebook-official font-28 text-secondary"></i></div>
                                <div class="inline-block float-left ml-2"><img src="/assets/images/bing_icon.svg" class="img-fluid height_28"></div>
                                <div class="inline-block float-left ml-2"><i class="fa fa-foursquare font-28 text-secondary"></i></div>
                                <div class="inline-block float-left ml-2"><img src="/assets/images/booking-icon.png" class="img-fluid height_28"></div>
                                <div class="inline-block float-left ml-2"><i class="fa fa-instagram font-28 text-secondary"></i></div>
                                <div class="inline-block float-left ml-2"><img src="/assets/images/flight-icon.png" class="img-fluid height_28"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-12 pt-4 business-scan-results mb-4" id="location-listing" v-show="!toggle">
                                <div class="table-responsive listing-tble-cont">
                                    <table id="listingResults" class="table table-striped table-bordered" width="100%">
                                        <thead>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th v-for="location in locationScanResults">{{location.title}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="source in sources.concat(sources_coming_soon)">
                                            <td><img :src="'/assets/images/'+source+'-icon-big.png'"/></td>
                                            <td v-for="location in locationScanResults">
                                                {{ location.latest_scan_result && location.latest_scan_result.report_details[source] ? location.latest_scan_result.report_details[source].score : 0 }}%
                                            </td>
                                            <td class="overlay overlay-low" v-if="sources_coming_soon.indexOf(source) >= 0"><h3>coming soon</h3></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="location-data" class="mb-4" v-show="toggle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
  import VueEasyPieChart from 'vue-easy-pie-chart'
  import vSelect from 'vue-select'
  import vueSlider from 'vue-slider-component'
  import { setupCalendar } from 'v-calendar'
  import moment from 'moment'

  const Highcharts = require('highcharts')
  require('highcharts/modules/exporting')(Highcharts)

  import HLineChart from '../charts/HLineChart'

  const dynamicsTotal = {
    props: ['percent'],
    template: '<p :class="textColor" class="mb-0"><i class="fa" :class="caretDirection"></i> {{ absPercent }}%</p>',
    computed: {
      absPercent() {
        return Math.abs(this.percent)
      },
      textColor() {
        if (this.percent > 0) {
          return 'green-text'
        } else if (this.percent < 0) {
          return 'red-text'
        }
        return 'gray-text'
      },
      caretDirection() {
        if (this.percent > 0) {
          return 'fa-caret-up'
        } else if (this.percent < 0) {
          return 'fa-caret-down'
        }
        return 'fa-ellipsis-h'
      }
    }
  }
  const simpleDynamics = {
    props: ['percent'],
    template: '<span v-if="absPercent > 0" :class="textColor">({{signPercent}}{{absPercent}}%)</span>',
    computed: {
      absPercent() {
        return Math.abs(this.percent)
      },
      signPercent() {
        if (this.percent > 0) {
          return '+'
        } else if (this.percent < 0) {
          return '-'
        }
        return null
      },
      textColor() {
        if (this.percent > 0) {
          return 'green-text'
        } else if (this.percent < 0) {
          return 'red-text'
        }
        return null
      }
    }
  }

  export default {
    name: 'LocationAnalytics',

    props: [],

    components: {
      VueEasyPieChart,
      vSelect,
      HLineChart,
      dynamicsTotal,
      simpleDynamics,
      vueSlider,
      setupCalendar
    },

    data () {
      return {
        toggle: false,
        hChart: null,
        periods: ['all', 'last 30 days', 'last 3 month', 'last year', 'choose period'],
        statuses: ['All', 'Verified', 'Unverified'],
        filterLocations: {
          rating: [0, 5]
        },
        /*filterPerformance: {
          presetPeriod: true,
          period: null,
          preset: null,
        },*/
        filterScanResults: {
          presetPeriod: true,
          period: null,
          preset: null,
        },
        defaultLatLng: {
          lat: 25,
          lng: 55.33333,
        },
        totals: {
          fixes_needed: null,
          fixes_needed_dynamics: null,
          profile_score: null,
          profile_score_dynamics: null,
          avg_score: null,
          total: null,
          total_dynamics: null,
        },
        performance: {
          activity: {
            ACTIONS_DRIVING_DIRECTIONS: 0,
            ACTIONS_PHONE: 0,
            ACTIONS_WEBSITE: 0,
            PHOTOS_VIEWS_MERCHANT: 0,
            total: 0
          },
          searches: {
            QUERIES_DIRECT: 0,
            QUERIES_INDIRECT: 0,
            total: 0
          },
          views: {
            VIEWS_MAPS: 0,
            VIEWS_SEARCH: 0,
            total: 0
          },
        },
        locations: [],
        latLongLocations: {},
        locationScanResults: [],
        sbsMonths: [],
        sources: ['google'],
        sources_coming_soon: ['bing', 'fb', 'force'],
        sbsData: {google: []},
        icon: {
          url: '/assets/images/icons/map_location_small.png',
        },
        infoWindowPos: null,
        infoWinOpen: false,
        currentIdx: null,
        infoOptions: {
          content: '',
          //optional: offset infowindow so it visually sits nicely on top of our marker
          pixelOffset: {
            width: 0,
            height: -35
          }
        },
        googleLib: null,
      }
    },

    mounted () {
      this.hChart = Highcharts.chart('location-data', {
        chart: {
          type: 'column',
        },
        title: {
          text: '',
        },
        credits: {
          enabled: false,
        },
        exporting: {
          enabled: false,
        },
        xAxis: {
          categories: [],
          style: {
            textOutline: false,
            fontSize: '18px',
            color: '#666666',
          },
          labels: {
            style: {
              fontSize: '18px',
            },
          },
        },
        yAxis: {
          gridLineWidth: 0,
          min: 0,
          max: 100,
          title: false,
          labels: {
            enabled: false,
          },
        },
        tooltip: {
          formatter: function () {
            return '<b>' + this.x + '</b><br/>' +
              this.series.name + ': ' + this.y + ' %'
          },
        },
        legend: {
          enabled: false,
        },
        plotOptions: {
          column: {
            stacking: 'normal',
            borderWidth: 0,
            dataLabels: {
              enabled: true,
              format: '{y} %',
              inside: true,
              rotation: -90,
              x: -30,
              style: {
                textDecoration: 'none',
                color: '#000',
                fontWeight: 'normal',
                textOutline: false,
                fontSize: '18px',
              },
            },
          },
          series: {
            pointWidth: 35,
          },
        },
        series: [
          {
            enableMouseTracking: false,
            showInLegend: false,
            grouping: false,
            color: '#f1f1f1',
            data: [],
            animation: true,
            dataLabels: {
              enabled: false,
            },
          }, {
            name: 'Matched',
            color: '#00b01d',
            animation: true,
            data: [],
            dataLabels: {
              enabled: true,
              formatter: function () {
                return this.y + '%'
              },
            },
          }],
      })
    },

    methods: {
      addressCoordinates (index) {
        return {
          lat: Number.parseFloat(this.locations[index].latitude),
          lng: Number.parseFloat(this.locations[index].longitude),
        }
      },
      getLocations (params) {
        axios.post('/locations-analytics/locations', { params: params })
        .then(response => {
          this.locations = response.data.locations
          for (let i=0, len=this.locations.length; i<len; i++) {
            this.loadLatLong(this.locations[i], i)
          }
          this.totals = response.data.totals
        }).catch(error => {
          console.log(error)
        })
      },
      getPerformance (params) {
        axios.post('/locations-analytics/performance', { params: params })
        .then(response => {
          this.performance = response.data
        }).catch(error => {
          console.log(error)
        })
      },
      getScanResults (params) {
        axios.post('/locations-analytics/scan-results', { params: params })
        .then(response => {
          this.locationScanResults = response.data
          let names = [],
            values = [],
            values100 = []
          for (let i in this.locationScanResults) {
            let location = this.locationScanResults[i]
            names.push(location.title)
            values100.push(100)
            values.push(location.latest_scan_result && location.latest_scan_result.report_details.google ? location.latest_scan_result.report_details.google.score : 0)
          }
          this.hChart.update({ xAxis: { categories: names } })
          this.hChart.series[0].update({ data: values100 })
          this.hChart.series[1].update({ data: values })
        }).catch(error => {
          console.log(error)
        })
      },
      toggleInfoWindow: function(index) {
        let location = this.locations[index],
          rating = []
        for (let i=1; i<=5; i++) {
          rating.push('<i class="fa fa-star font-14 text-'+(location.rating >= i ? 'warning' : 'secondary')+'"></i>')
        }

        this.infoWindowPos = this.addressCoordinates(index);
        this.infoOptions.content = '<div class="map_tooltip">' +
          '<h5>'+location.title+'</h5>' +
          '<p>'+location.raw_data.address.addressLines[0]+' '+location.raw_data.address.locality+', '+location.raw_data.address.regionCode+'</p>' +
          '<p>'+location.rating+' '+rating.join(' ')+' ('+location.reviews_count+')</p>' +
          '</div>';
        //check if its the same marker that was selected if yes toggle
        if (this.currentIdx === index) {
          this.infoWinOpen = !this.infoWinOpen;
        }
        //if different marker set info-window to open and reset current marker index
        else {
          this.infoWinOpen = true;
          this.currentIdx = index;
        }
      },
      isValidLatLong: function(latitude, longitude) {
        let lat = Number.parseFloat(latitude),
          lng = Number.parseFloat(longitude)

        return !isNaN(lat) && !isNaN(lng) && (lat != 0 || lng != 0);
      },
      loadLatLong: function (location, index) {
        let latLong = {
          lat: Number.parseFloat(location.latitude),
          lng: Number.parseFloat(location.longitude)
        };
        if (this.isValidLatLong(location.latitude, location.longitude)) {
          this.latLongLocations[location.id] = latLong
          return;
        }
        if(typeof this.latLongLocations[location.id] !== 'undefined') {
          location.latitude = this.latLongLocations[location.id].lat
          location.longitude = this.latLongLocations[location.id].lng
          this.locations[index] = location
          return;
        }
        let url = []
        if (typeof location.raw_data.address !== 'undefined') {
          url.push(location.raw_data.address.regionCode)
          url.push(location.raw_data.address.locality)
          url.push(location.raw_data.address.addressLines[0])

          axios.get('/api/v1/places/geocode/' + url.join(', '))
          .then(response => {
            if (response.data.results.length > 0) {
              this.latLongLocations[location.id] = response.data.results[0].geometry.location
              location.latitude = this.latLongLocations[location.id].lat
              location.longitude = this.latLongLocations[location.id].lng
              this.locations[index] = location
            }
          })
        }
      }
    },
    watch: {
      /*'filterPerformance.preset': function (newVal, oldVal) {
        if (oldVal === 'choose period') {
          this.filterPerformance.presetPeriod = true
        } else if (newVal === 'choose period') {
          this.filterPerformance.presetPeriod = false
        }
      },*/

      'filterScanResults.preset': function (newVal, oldVal) {
        if (oldVal === 'choose period') {
          this.filterScanResults.presetPeriod = true
        } else if (newVal === 'choose period') {
          this.filterScanResults.presetPeriod = false
        }
      },

      'searchFilterLocations' (val) {
        this.getLocations(val)
      },

      /*'searchFilterPerformance' (val) {
        this.getPerformance(val)
      },*/

      'searchFilterScanResults' (val) {
        this.getScanResults(val)
      },
      'bounds' (bounds) {
        if (null !== bounds) {
          this.$refs.gMap.fitBounds(bounds)
        }
      }
    },

    computed: {
      searchFilterLocations () {
        return {
          rating: this.filterLocations.rating,
          status: this.filterLocations.status,
        }
      },
      /*searchFilterPerformance () {
        let period = null
        if (this.filterPerformance.period != null) {
          period = [
            moment(this.filterPerformance.period.start).format('YYYY-MM-DD'),
            moment(this.filterPerformance.period.end).format('YYYY-MM-DD')
          ]
        }
        return {
          preset: this.filterPerformance.preset,
          period: period,
        }
      },*/
      searchFilterScanResults () {
        let period = null
        if (this.filterScanResults.period != null) {
          period = [
            moment(this.filterScanResults.period.start).format('YYYY-MM-DD'),
            moment(this.filterScanResults.period.end).format('YYYY-MM-DD')
          ]
        }
        return {
          preset: this.filterScanResults.preset,
          period: period,
        }
      },
      sbsSeries () {
        return [
          {
            name: 'Google',
            fillColor: 'rgba(79,150,192, 1)',
            data: this.sbsData.google,
            lineColor: 'rgba(79,150,192, 1)',
            marker: {
              enabled: false,
            },
          },
        ]
      },
      trackColor () {
        let res = this.totals.avg_score
        if (res >= 81 && res <= 100) {
          return '#0f6f06'
        } else if (res >= 61 && res <= 80) {
          return '#e1780c'
        } else {
          return '#e80029'
        }
      },
      bounds () {
        if (this.googleLib === null) {
          return null
        }
        let bounds = new this.googleLib.maps.LatLngBounds();
        for (let i=0, len=this.locations.length; i<len; i++) {
          let coordinates = this.addressCoordinates(i)
          if (!isNaN(coordinates.lat) && !isNaN(coordinates.lng) && (coordinates.lat != 0 || coordinates.lng != 0)) {
            bounds.extend(coordinates)
          }
        }
        return bounds
      }
    },
    created () {
      this.getLocations({})
      this.getPerformance({})
      this.getScanResults({})
      axios.post('/locations-analytics/score-by-site')
      .then(response => {
        for (let i in response.data) {
          let res = response.data[i]
          this.sbsMonths.push(res.month)
          for (let s in this.sources) {
            let source = this.sources[s]
            this.sbsData[source].push(res.data[source] ? res.data[source] : 0)
          }
        }
      }).catch(error => {
        console.log(error)
      })
    },
    updated() {
      if (this.googleLib === null && typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
        this.googleLib = google
      }
    }
  }
</script>