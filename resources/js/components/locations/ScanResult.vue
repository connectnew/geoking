<template>
    <div>
        <div class="small-preloader-wrapper" style="min-height: 740px;" v-if="loading">
            <div class="small-preloader">
                <div class="lds-ripple">
                    <div class="lds-pos"></div>
                    <div class="lds-pos"></div>
                </div>
            </div>
        </div>
        <div class="business-scan-results" v-if="!loading">
            <div class="row">
                <div class="col-12">
                    <div class="blue-box">
                        <div class="row">
                            <div class="col-md-12 col-lg-5 pb-4">
                                <div id="business_scan_score">
                                    <vue-easy-pie-chart
                                            :percent="resultPercent"
                                            :bar-color="trackColor"
                                            :size="250"
                                            :animate="true"
                                            :line-width="8"
                                            :line-cap="'square'"
                                            :font-size="'56px'"
                                            :font-weight="700"></vue-easy-pie-chart>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4 padding-top-35">
                                <h1>{{ scanResult.name }}</h1>
                                <h2>{{ scanResult.address }}</h2>
                                <h2>{{ scanResult.phone }}</h2>
                            </div>
                            <div class="col-md-12 col-lg-3">
                                <div class="yellow-box text-center">
                                    <h1 class="text-center"><span style="font-size: 25px; font-weight: normal;">Get to</span> 100%</h1>
                                    <a href="#" class="btn btn-blue" style="white-space: pre-wrap;">Improve with GEOKING</a>
                                </div>
                            </div>
                            <div class="col-12 text-center pt-3">
                                <p class="mb-0">The Listing Score is designed to rate the online visibility of your business.</p>
                                <p class="mb-0">This score takes into consideration the listing's accuracy, completeness, duplicates, and claim status.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 pt-4">
                    <div class="table-responsive search-results-tble-cont">
                        <table id="searchResults" class="table table-striped table-bordered" width="100%">
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Status</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Score</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="source in sources.concat(sources_coming_soon)">
                                <td><img :src="'/assets/images/'+source+'-icon-big.png'" :alt="source"/></td>
                                <td>
                                    <i class="fa" :class="totalStatusClass(getStatus(scanResult[source]))" aria-hidden="true"></i><br>
                                    {{ getStatus(scanResult[source]) }}
                                </td>
                                <td v-for="property in ['name', 'address', 'phone']">
                                    <i class="fa" :class="statusClass(getStatus(scanResult[source], property))" aria-hidden="true"></i><br>
                                    {{ getStatus(scanResult[source], property) }}
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-center">
                                        <p class="score_red_txt mb-3 pt-2">{{ scanResult[source] ? scanResult[source].score : 0 }}%</p>
                                        <a href="javascript:void(0)" class="lockation-status px-3 py-1">Fix</a>
                                    </div>
                                </td>
                                <td class="overlay" v-if="sources_coming_soon.indexOf(source) >= 0"><h3>coming soon</h3></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
  import VueEasyPieChart from 'vue-easy-pie-chart'
  import 'vue-easy-pie-chart/dist/vue-easy-pie-chart.css'

  export default {
    name: 'ScanResult',

    props: ['location'],

    components: {
      VueEasyPieChart,
    },

    data () {
      return {
        loading: null,
        scanResult: {
          name: null,
          phone: null,
          address: null,
          mean_score: 0,
          google: null,
          bing: null,
          fb: null,
          force: null,
        },
        sources: ['google'],
        sources_coming_soon: ['bing', 'fb', 'force'],
      }
    },

    computed: {
      resultPercent () {
        let res = this.scanResult.mean_score
        if (res) {
          return parseInt(res)
        } else {
          return 0
        }
      },
      trackColor () {
        let res = this.scanResult.mean_score
        if (res >= 81 && res <= 100) {
          return '#0f6f06'
        } else if (res >= 61 && res <= 80) {
          return '#e1780c'
        } else {
          return '#e80029'
        }
      },
    },

    mounted () {

    },

    methods: {
      getStatus (obj, property) {
        if (null == obj) {
          return 'Not Listed'
        }
        if (null == property) {
          return obj.total_status
        }
        return obj[property].status
      },
      totalStatusClass (status) {
        if (status === 'Listed')
          return 'fa-check-circle listed'
        else
          return 'fa-exclamation-circle notlist'
      },
      statusClass (status) {
        if (status === 'Mismatch')
          return 'fa-exclamation-circle mismatch'
        if (status === 'Match')
          return 'fa-check-circle listed'
        else
          return 'fa-exclamation-circle notlist'
      },
    },

    created () {
      this.loading = true
      axios.post('/scan-result/location/' + this.location.id).then(response => {
        this.scanResult = response.data.report_details
        this.loading = false
      }).catch(error => {
        console.log(error)
      })
    },
  }
</script>