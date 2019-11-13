<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="white-rounded-box revews-selectbox border_1 rounded-0">
                    <div class="row mt-2">
                        <div class="col-md-6 col-lg-2 col-xl-2 pt-1 pb-1">
                            <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                      placeholder="Locations"
                                      label="title"
                                      :resetOnOptionsChange="true"
                                      :filterable="false"
                                      v-model="filterReviews.location"
                                      :options="locations">
                                <template #search="{attributes, events}">
                                    <input
                                            class="vs__search"
                                            autocomplete="new-username"
                                            v-bind="attributes"
                                            v-on="events"/>
                                </template>
                            </v-select>
                        </div>
                        <div class="col-md-6 col-lg-2 col-xl-2 pt-1 pb-1">
                            <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                      placeholder="Sources"
                                      label="name"
                                      :resetOnOptionsChange="true"
                                      :filterable="false"
                                      v-model="filterReviews.source"
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
                        <div class="col-md-6 col-lg-2 col-xl-2 pt-1 pb-1">
                            <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                      placeholder="Rating"
                                      label="name"
                                      :resetOnOptionsChange="true"
                                      :filterable="false"
                                      v-model="filterReviews.rating"
                                      :options="ratings">
                                <template #search="{attributes, events}">
                                    <input
                                            class="vs__search"
                                            autocomplete="new-username"
                                            v-bind="attributes"
                                            v-on="events"/>
                                </template>
                            </v-select>
                        </div>
                        <div class="col-md-6 col-lg-2 col-xl-2 pt-1 pb-1">
                            <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                      placeholder="Statuses"
                                      label="name"
                                      :resetOnOptionsChange="true"
                                      :filterable="false"
                                      v-model="filterReviews.status"
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
                        <div class="col-md-6 col-lg-2 col-xl-2"></div>
                    </div>
                    <div class="row mt-4 review-score-stats">
                        <div class="col-sm-6 col-6 col-md-6 col-lg-3 col-xl-3 d-flex align-items-center">
                            <h2>{{ analytics.total.average_score }}</h2>
                            <div class="ml-2">
                                <dynamics-total v-bind:percent="analytics.total.average_score_dynamics"></dynamics-total>
                                <p class="score-text">Average Score</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-6 col-md-6 col-lg-3 col-xl-3 d-flex align-items-center">
                            <h2>{{ analytics.total.positive }}</h2>
                            <div class="ml-2">
                                <dynamics-total v-bind:percent="analytics.total.positive_dynamics"></dynamics-total>
                                <p class="score-text">Positive Reviews</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-6 col-md-6 col-lg-3 col-xl-3 d-flex align-items-center">
                            <h2>{{ analytics.total.negative }}</h2>
                            <div class="ml-2">
                                <dynamics-total v-bind:percent="analytics.total.negative_dynamics"></dynamics-total>
                                <p class="score-text">Negative Reviews</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-6 col-md-6 col-lg-3 col-xl-3 d-flex align-items-center">
                            <h2>{{ analytics.total.pending_response }}</h2>
                            <div class="ml-2">
                                <dynamics-total v-bind:percent="analytics.total.pending_response_dynamics"></dynamics-total>
                                <p class="score-text">Pending Responses</p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12 col-lg-6 pb-4">
                            <p class="reviews-page-title mt-15">Summary of Reviews</p>
                            <div class="table-responsive">
                                <table class="table review-summary">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-left">Review</th>
                                        <th>Percentage</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in analytics.scores">
                                        <td>{{ item.score }}.</td>
                                        <td class="text-left">
                                            <template v-for="n in item.score"><i class="fa fa-star font-24 text_yellow"></i>&nbsp;</template>
                                        </td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" :class="'bg-'+badgeStyle(item.score)" :style="'width:'+ item.percent +'%'"></div>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-pill" :class="'badge-'+badgeStyle(item.score)"><a href="/manage-reviews">{{ item.total }}</a></span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6 pb-4">
                            <p class="reviews-page-title">Review Analysis</p>
                            <div id="chart_review_analysis" style="width: 100%; height: 350px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="white-rounded-box w-100 rounded-0 border_2 revews-selectbox">
                    <div class="row mt-2">
                        <div class="col-md-6 col-lg-2 col-xl-2 pt-1 pb-1">
                            <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                      placeholder="Locations"
                                      label="title"
                                      :resetOnOptionsChange="true"
                                      :filterable="false"
                                      v-model="filterCustomers.location"
                                      :options="locations">
                                <template #search="{attributes, events}">
                                    <input
                                            class="vs__search"
                                            autocomplete="new-username"
                                            v-bind="attributes"
                                            v-on="events"/>
                                </template>
                            </v-select>
                        </div>
                        <div class="col-md-6 col-lg-2 col-xl-2 pt-1 pb-1">
                            <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                      placeholder="Sources"
                                      label="name"
                                      :resetOnOptionsChange="true"
                                      :filterable="false"
                                      v-model="filterCustomers.source"
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
                        <div class="col-md-6 col-lg-2 col-xl-2 pt-1 pb-1">
                            <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                      placeholder="Rating"
                                      label="name"
                                      :resetOnOptionsChange="true"
                                      :filterable="false"
                                      v-model="filterCustomers.rating"
                                      :options="ratings">
                                <template #search="{attributes, events}">
                                    <input
                                            class="vs__search"
                                            autocomplete="new-username"
                                            v-bind="attributes"
                                            v-on="events"/>
                                </template>
                            </v-select>
                        </div>
                        <div class="col-md-6 col-lg-2 col-xl-2 pt-1 pb-1">
                            <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                      placeholder="Statuses"
                                      label="name"
                                      :resetOnOptionsChange="true"
                                      :filterable="false"
                                      v-model="filterCustomers.status"
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
                        <div class="col-md-6 col-lg-2 col-xl-2"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-4 col-xl-4 pb-4">
                <div class="white-rounded-box p-0 rounded-0 h-100 position-md-relative position-static pb-md-5 pb-0">
                    <div class="row">
                        <div class="col-12 pl-4 pr-4">
                            <p class="reviews-page-title mb-2 mt-2">Customer Satisfaction per Time of the Day</p>
                        </div>
                    </div>
                    <hr class="mt-0 mb-0">
                    <div class="row mb-md-4 mb-0">
                        <div class="col-12">
                            <div class="col-12 pl-4 pr-4 text-center">
                                <template v-if="customerSatisfaction.peak_time">
                                    <div class="font-30 text_light_gray pt-4">
                                        <div class="font-bold">{{ customerSatisfaction.peak_time }}</div>
                                        <div class="font-18">Peak Time</div>
                                    </div>
                                </template>
                                <div id="customer_satisfaction" style="width: 100%; height: 230px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 col-xl-4 pb-4">
                <div class="white-rounded-box p-0 rounded-0 h-100 position-md-relative position-static pb-md-5 pb-0">
                    <div class="row">
                        <div class="col-12 pl-4 pr-4">
                            <p class="reviews-page-title mb-2 mt-2">Median First Response Time vs last 30 days</p>
                        </div>
                    </div>
                    <hr class="mt-0 mb-0">
                    <div class="row mb-md-4 mb-0">
                        <div class="col-12 pl-4 pr-4">
                            <div class="row mt-3 mb-3">
                                <div class="col-12 text-center pt-5">
                                    <template v-if="medianResponseTime.median_response_time">
                                        <div class="pt-5 font-30 text_dark_blue_link">
                                            <span class="font-60">{{ medianResponseTime.median_response_time }}</span>
                                        </div>
                                        <div class="pt-2 font-20">
                                            <div v-if="medianResponseTime.median_response_time_dynamics < 0" class="red-text">
                                                <span class="font-40"><i class="fa fa-caret-down"></i> {{ Math.abs(medianResponseTime.median_response_time_dynamics) }}%</span>
                                            </div>
                                            <div v-else-if="medianResponseTime.median_response_time_dynamics > 0" class="red-text">
                                                <span class="font-40"><i class="fa fa-caret-up"></i> {{ medianResponseTime.median_response_time_dynamics }}%</span>
                                            </div>
                                            <div v-else class="text_dark_green">.. 0</div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="pt-5 font-46 text_light_gray">
                                            No data
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 col-xl-4 pb-4">
                <div class="white-rounded-box p-0 rounded-0 h-100">
                    <div class="row">
                        <div class="col-12 pl-4 pr-4">
                            <p class="reviews-page-title mb-2 mt-2">Reasons for Dissatisfaction</p>
                        </div>
                    </div>
                    <hr class="mt-0 mb-0">
                    <div class="row">
                        <div class="col-12 pl-4 pr-4 text-center">
                            <!-- <div id="reason_for_dis" style="width: 100%; height: 360px;"></div> -->
                            <GChart
                                    style="width: 100%; height: 400px;"
                                    type="PieChart"
                                    :data="chartData"
                                    :options="chartOptions"
                                    :events="chartEvents"
                                    :resizeDebounce="500"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-8 pb-4">
                <div class="white-rounded-box rounded-0 border_2">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-4">
                                    <p class="reviews-page-title">Location Analysis</p>
                                </div>
                                <div class="col-md-12 col-lg-8">
                                    <div class="row revews-selectbox">
                                        <div class="col-md-12 offset-lg-4 col-lg-4 pb-3">
                                            <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                                      placeholder="Locations"
                                                      label="title"
                                                      :resetOnOptionsChange="true"
                                                      :filterable="false"
                                                      v-model="filterAnalytics.location"
                                                      :options="locations">
                                                <template #search="{attributes, events}">
                                                    <input
                                                            class="vs__search"
                                                            autocomplete="new-username"
                                                            v-bind="attributes"
                                                            v-on="events"/>
                                                </template>
                                            </v-select>
                                        </div>
                                        <div class="col-md-12 col-lg-4 pb-3">
                                            <v-select class="custom-v-select form-control select-bottom-0 py-0"
                                                      placeholder="Sources"
                                                      label="name"
                                                      :resetOnOptionsChange="true"
                                                      :filterable="false"
                                                      v-model="filterAnalytics.source"
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
                                </div>
                            </div>
                            <vuetable class="table nowrap location-analysis" ref="vuetable"
                                      :api-url="'/reviews-analytics/location-analysis'"
                                      :http-method="'post'"
                                      :append-params="tableParams"
                                      :fields="fields"
                                      :query-params="noQueryParams"
                                      :row-class="onRowClass"
                                      pagination-path=""
                                      data-path="sources"
                                      @vuetable:load-success="loadSuccess">
                                <template slot="source" slot-scope="props">
                                    <div v-if="sources_coming_soon.includes(props.rowData.source_name)" class="overlay"><h3>coming soon</h3></div>
                                    <img class="small-logo" :src="'/assets/images/' + props.rowData.source_name + '-logo-sm.jpg'" :alt="props.rowData.source_name">
                                </template>
                                <template slot="total_review" slot-scope="props">
                                    <div v-if="props.rowData.total_review">
                                    {{ props.rowData.total_review }}
                                    <span v-if="props.rowData.total_review_dynamics < 0" class="red-text-sm"><i class="fa fa-caret-down"></i> {{ Math.abs(props.rowData.total_review_dynamics) }}%</span>
                                    <span v-else-if="props.rowData.total_review_dynamics > 0" class="blue-text-sm"><i class="fa fa-caret-up"></i> {{ props.rowData.total_review_dynamics }}%</span>
                                    <span v-else class="gray-text-sm">.. 0%</span>
                                    </div>
                                </template>
                                <template slot="overall_rating" slot-scope="props">
                                    <div v-if="props.rowData.overall_rating">
                                    {{ props.rowData.overall_rating }}
                                    <span v-if="props.rowData.overall_rating_dynamics < 0" class="red-text-sm"><i class="fa fa-caret-down"></i> {{ Math.abs(props.rowData.overall_rating_dynamics) }}%</span>
                                    <span v-else-if="props.rowData.overall_rating_dynamics > 0" class="blue-text-sm"><i class="fa fa-caret-up"></i> {{ props.rowData.overall_rating_dynamics }}%</span>
                                    <span v-else class="gray-text-sm">.. 0%</span>
                                    </div>
                                </template>
                            </vuetable>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 col-xl-4 pb-4">
                <div class="white-rounded-box rounded-0 border_2 h-100">
                    <div class="row h-100">
                        <div class="col-12 pt-2 pb-3">
                            <p class="reviews-page-title">Highlights</p>
                            <hr>
                        </div>
                        <div class="col-12 text-center d-flex align-content-md-between flex-wrap w-100 h-100 highlight_wrapper">
                            <div class="w-100 flex-nowrap d-flex justify-content-between mb-4">
                                <div class="category_wrapper mb-3">
                                    <div class="img-sec"><span class="badge badge-pill position-absolute rounded-circle badge-pos">5</span> <img
                                            src="/assets/images/excellent-icon.png" alt="Excellent"></div>
                                    <div class="text-sec"> Excellent<br>
                                        Service
                                    </div>
                                </div>
                                <div class="category_wrapper mb-3">
                                    <div class="img-sec"><span class="badge badge-pill position-absolute rounded-circle badge-pos">6</span> <img
                                            src="/assets/images/atmosphere-icon.png" alt="Excellent"></div>
                                    <div class="text-sec"> Great <br>
                                        atmosphere
                                    </div>
                                </div>
                                <div class="category_wrapper mb-3">
                                    <div class="img-sec"><span class="badge badge-pill position-absolute rounded-circle badge-pos">8</span> <img src="/assets/images/value-icon.png"
                                                                                                                                                 alt="Excellent"></div>
                                    <div class="text-sec"> Good value<br>
                                        for money
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 flex-nowrap d-flex justify-content-between">
                                <div class="category_wrapper mb-3">
                                    <div class="img-sec"><span class="badge badge-pill position-absolute rounded-circle badge-pos">2</span> <img src="/assets/images/food-icon.png"
                                                                                                                                                 alt="Excellent"></div>
                                    <div class="text-sec"> Great<br>
                                        Food
                                    </div>
                                </div>
                                <div class="category_wrapper mb-3">
                                    <div class="img-sec"><span class="badge badge-pill position-absolute rounded-circle badge-pos">4</span> <img
                                            src="/assets/images/location-icn.png" alt="Excellent"></div>
                                    <div class="text-sec"> Good<br>
                                        Location
                                    </div>
                                </div>
                                <div class="category_wrapper mb-3">
                                    <div class="img-sec"><span class="badge badge-pill position-absolute rounded-circle badge-pos">4</span> <img
                                            src="/assets/images/food-icon-2.png" alt="Excellent"></div>
                                    <div class="text-sec"> Good<br>
                                        Menu
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- The Modal -->
                <div class="modal fade manage-reviews-modal attribute-score-modal" id="review_analysis_modal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <div class="modal-header-txt">Review Analysis</div>
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body pb-0">
                                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Stars</th>
                                        <th>Author</th>
                                        <th>Timestamp</th>
                                        <th>City</th>
                                        <th>Store code</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>ABC</td>
                                        <td>ABC</td>
                                        <td>ABC</td>
                                        <td>ABC</td>
                                        <td>ABC</td>
                                        <td>ABC</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade manage-reviews-modal attribute-score-modal" id="reason_dis_modal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <div class="modal-header-txt">Reasons for Dissatisfaction</div>
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body pb-0">
                                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Stars</th>
                                        <th>Author</th>
                                        <th>Timestamp</th>
                                        <th>City</th>
                                        <th>Store code</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>ABC</td>
                                        <td>ABC</td>
                                        <td>ABC</td>
                                        <td>ABC</td>
                                        <td>ABC</td>
                                        <td>ABC</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- The Modal -->

            </div>
        </div>

    </div>
</template>
<script>
  import Vuetable from 'vuetable-2'
  import vSelect from 'vue-select'
  import { GChart } from 'vue-google-charts'

  const Highcharts = require('highcharts')
  require('highcharts/modules/exporting')(Highcharts)

  const dynamicsTotal = {
    props: ['percent'],
    template: '<p :class="textColor" v-if="percent"><i class="fa" :class="caretDirection"></i> {{ absPercent }}%</p>',
    computed: {
      absPercent() {
        return Math.abs(this.percent)
      },
      textColor() {
        if (this.percent >= 15) {
          return 'green-text'
        } else if (this.percent <= 15) {
          return 'red-text'
        }
        return 'orange-text'
      },
      caretDirection() {
        if (this.percent >= 15) {
          return 'fa-caret-up'
        } else if (this.percent <= 15) {
          return 'fa-caret-down'
        }
        return this.percent > 0 ? 'fa-caret-right' : 'fa-caret-left'
      }
    }
  }
  const timeSeries = [
    '12AM', '1AM', '2AM', '3AM', '3AM', '4AM', '5AM', '6AM', '7AM', '8AM', '9AM', '10AM', '11AM',
    '12PM', '1PM', '2PM', '3PM', '3PM', '4PM', '5PM', '6PM', '7PM', '8PM', '9PM', '10PM', '11PM',
  ]

  export default {
    name: 'AnalyticsReviews',

    components: {
      Vuetable,
      vSelect,
      GChart,
      dynamicsTotal
    },

    props: [],

    watch: {
      'searchFilterReviews' (val) {
        this.searchReviews(val)
      },

      'searchFilterCustomers' (val) {
        this.searchMedianFirstResponseTime(val)
        this.searchCustomerSatisfaction(val)
      },

      'searchFilterAnalytics' (val) {
        this.$set(this.tableParams, 'location', val.location)
        this.$set(this.tableParams, 'source', val.source)
        this.$refs.vuetable.reload();
      },
    },

    computed: {
      searchFilterReviews () {
        return {
          location: this.filterReviews.location !== null ? this.filterReviews.location.id : null,
          source: this.filterReviews.source,
          rating: this.filterReviews.rating,
          status: this.filterReviews.status
        }
      },
      searchFilterCustomers () {
        return {
          location: this.filterCustomers.location !== null ? this.filterCustomers.location.id : null,
          source: this.filterCustomers.source,
          rating: this.filterCustomers.rating,
          status: this.filterCustomers.status
        }
      },
      searchFilterAnalytics () {
        return {
          location: this.filterAnalytics.location !== null ? this.filterAnalytics.location.id : null,
          source: this.filterAnalytics.source
        }
      },
    },

    data () {
      return {
        message: '',
        fields: [
          {
            name: '__slot:source',
            title: () => 'Review Site' + (this.review_sites > 0 ? (' ('+this.review_sites+')') : ''),
            dataClass: 'pt-3',
            titleClass: 'text-center font-weight-bold',
          },
          {
            name: '__slot:total_review',
            title: 'Total Reviews',
            dataClass: 'pt-3',
            titleClass: 'text-center font-weight-bold',
          },
          {
            name: '__slot:overall_rating',
            title: 'Overall Rating',
            dataClass: 'pt-3',
            titleClass: 'text-center font-weight-bold',
            sortField: 'overall_rating'
          },
          {
            name: 'new_reviews',
            title: 'New Reviews',
            dataClass: 'pt-3',
            titleClass: 'text-center font-weight-bold',
          },
          {
            name: 'last_added',
            title: 'Last Added',
            dataClass: 'pt-3',
            titleClass: 'text-center font-weight-bold',
          },
        ],
        filterReviews: {
          location: null,
          source: null,
          rating: null,
          status: null,
        },
        filterCustomers: {
          location: null,
          source: null,
          rating: null,
          status: null,
        },
        filterAnalytics: {
          location: null,
          source: null,
        },
        tableParams: {},
        locations: [],
        sources: ['google'],
        sources_coming_soon: ['bing', 'fb', 'force'],
        ratings: [1, 2, 3, 4, 5],
        statuses: ['Responded', 'Unresponded'],
        analytics: {
          total: {
            average_score: 0,
            positive: 0,
            negative: 0,
            pending_response: 0,
          },
          last_months: [],
          scores: [],
        },
        customerSatisfaction: [],
        medianResponseTime: [],
        review_sites: 0,
        hChart: null,
        csChart: null,
        chartEvents: {
          'select': (data) => {
            console.log(data)
            // $('#reason_dis_modal').modal('show');
          },
        },
        chartData: [
          ['Reasons', 'Reasons for Dissatisfaction'],
          ['Food', 35],
          ['Location', 28],
          ['Price', 15],
          ['Service', 24],
          ['Menu', 10],
          ['Parking', 6],
        ],
        chartOptions: {
          pieHole: 0.5,
          chartArea: { 'left': 30, 'top': 80, 'width': '100%', 'height': '360px' },
          colors: ['#f66955', '#00a65a', '#f39c11', '#00c0ef', '#3c8dbc', '#d2d6df'],
          pieSliceTextStyle: {
            color: 'transparent',
          },
        },
      }
    },

    mounted () {
      if ($('#chart_review_analysis').length) {
        this.hChart = Highcharts.chart('chart_review_analysis', {
          chart: {
            type: 'column',
          },
          title: {
            text: '',
          },
          subtitle: {
            text: '',
          },
          xAxis: {
            categories: [],
            crosshair: true,
          },
          credits: {
            enabled: false,
          },
          exporting: {
            enabled: false,
          },
          yAxis: {
            min: 0,
            title: {
              text: '',
            },
          },
          legend: {
            symbolWidth: 12,
            symbolHeight: 12,
            symbolRadius: 0,
            squareSymbol: false,
          },
          tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
              '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true,
          },
          plotOptions: {
            column: {
              borderWidth: 0,
              padding: 0,
            },
            series: {
              pointPadding: 0,
              groupPadding: 0.23,
              cursor: 'pointer',
              point: {
                events: {
                  click: function (data) {
                    // $('#review_analysis_modal').modal('show');
                  },
                },
              },
            },
          },
          series: [
            {
              name: 'Positive',
              data: [],
              color: '#00a65a',
            }, {
              name: 'Negative',
              data: [],
              color: '#de4b39',
            }],
        })
      }
      if ($('#customer_satisfaction').length) {
        this.csChart = Highcharts.chart('customer_satisfaction', {
          chart: {
            type: 'area'
          },
          title: {
            text: ''
          },
          credits: {
            enabled: false,
          },
          exporting: {
            enabled: false,
          },
          legend: {
            enabled: false,
          },
          xAxis: {
            allowDecimals: false,
            categories: timeSeries,
            labels: {
              step: 3
            }
          },
          yAxis: {
            min: 0,
            allowDecimals: false,
            title: {
              text: '',
            },
          },
          tooltip: {
            pointFormat: 'Customer Satisfaction {point.y}'
          },
          plotOptions: {
            area: {
              fillOpacity: 0.5,
              marker: {
                enabled: false,
              }
            }
          },
          series: [
            {
              data: []
            }
          ]
        })
      }
    },
    methods: {
      badgeStyle (score) {
        if (score == 1) {
          return 'danger'
        } else if (score == 2) {
          return 'warning'
        } else if (score == 3) {
          return 'info'
        } else {
          return 'success'
        }
      },

      sendMessage () {
        let body = {
          message: this.message,
        }

        this.message = ''

        axios.post('/api/v1', body).then(response => {
          this.message = ''
        }).catch(error => {

        })
      },
      searchReviews (params) {
        axios.post('/reviews-analytics/statistics', {params: params})
        .then(response => {
          this.analytics = response.data
          let months = this.analytics.last_months.map(stats => { return stats.month }),
            positives = this.analytics.last_months.map(stats => { return stats.positive }),
            negatives = this.analytics.last_months.map(stats => { return stats.negative })

          this.hChart.update({ xAxis: { categories: months } })
          this.hChart.series[0].update({ data: positives })
          this.hChart.series[1].update({ data: negatives })
        }).catch(error => {
          console.log(error)
        })
      },
      searchCustomerSatisfaction (params) {
        axios.post('/reviews-analytics/customer-satisfaction', {params: params})
        .then(response => {
          this.customerSatisfaction = response.data
          let series = [];
          for (let i in timeSeries) {
            let tm = timeSeries[i], val = 0
            if (typeof this.customerSatisfaction.per_time_of_day[tm] !== 'undefined') {
            val = this.customerSatisfaction.per_time_of_day[tm].value
            }
            series.push(val)
          }
          this.csChart.series[0].update({ data: series })

        }).catch(error => {
          console.log(error)
        })
      },
      searchMedianFirstResponseTime (params) {
        axios.post('/reviews-analytics/median-response-time', {params: params})
        .then(response => {
          this.medianResponseTime = response.data
        }).catch(error => {
          console.log(error)
        })
      },
      noQueryParams (sortOrder, currentPage, perPage) {
        return {}
      },
      loadSuccess(response) {
        this.review_sites = response.data.review_sites
      },
      onRowClass (dataItem) {
        return (this.sources_coming_soon.includes(dataItem.source_name)) ? 'coming-soon' : ''
      }
    },
    created () {
      axios.get('/api/v1/locations').then(response => {
        this.locations = response.data
      }).catch(error => {
        console.log(error)
      })
      this.searchReviews({})
      this.searchCustomerSatisfaction({})
      this.searchMedianFirstResponseTime({})
    },
    filters: {},
  }
</script>