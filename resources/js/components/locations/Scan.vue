<template>
    <div>
        <div class="row" v-show="part == 1">
            <div class="col-12 pt-3">
                <div class="scan-listing-main bg-white">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="row py-5 my-lg-3 my-0">
                                <div class="col-md-8 offset-md-2">
                                    <h1 class="font-weight-light font-37 text-center mb-4">Instant and Free Health Report</h1>
                                    <div class="form-group input-group mb-4 pt-2 px-lg-0 px-3">
									<span class="has-float-label">
										<input type="text" class="form-control" id="store_name" name="store_name"
                                               placeholder="Store Name" v-model="form.store_name"
                                               :class="{'error-shadow': $v.form.store_name.$error}"/>
										<label class="control-label" for="store_name">Store Name<span class="text-danger">*</span></label>
									</span>
                                    </div>

                                    <div class="input-group mb-4 pt-1 px-lg-0 px-3">
                                    <span class="has-float-label">
                                        <v-select
                                                :class="{'error-shadow': $v.form.country.$error, 'required-select': $v.form.country.$invalid || $v.form.country.$error}"
                                                label="name"
                                                class="form-control p-0 custom-select-scan"
                                                v-model="checkedCountry"
                                                placeholder="Country"
                                                :options="countries">
                                                    <template #search="{attributes, events}">
                                                        <input
                                                        class="vs__search"
                                                            autocomplete="new-username"
                                                            v-bind="attributes"
                                                            v-on="events"/>
                                                     </template>
                                                </v-select>
                                    </span>
                                    </div>

                                    <div class="form-group input-group mb-4 pt-1 px-lg-0 px-3">
									<span class="has-float-label">
                                        <vue-tel-input
                                        ref="telInput"
                                        id="tel-input"
                                        placeholder="Store Phone" name="tel"
                                        v-model="form.store_phone"
                                        :class="{'error-shadow': $v.form.store_phone.$error || !phoneValid}"
                                        :mode="'international'"
                                        @onInput="onInput"></vue-tel-input>
										<!-- <input type="text" class="form-control" id="store_phone" name="store_phone"
                                               placeholder="Store Phone" v-model="form.store_phone"
                                               :class="{'error-shadow': $v.form.store_phone.$error}"/> -->
										<!-- <label class="control-label" for="store_phone">Store phone<span class="text-danger">*</span></label> -->
									</span>
                                    </div>
                                    
                                    <div class="input-group mb-4 pt-1 px-lg-0 px-3">
									<span class="has-float-label">
                                        <v-select
                                                :class="{'error-shadow': $v.form.province.$error, 'required-select': $v.form.province.$invalid || $v.form.province.$error}"
                                                label="name"
                                                class="form-control p-0 custom-select-scan select-province"
                                                v-model="checkedProvince"
                                                placeholder="Province"
                                                :options="provinces">
                                                    <template #search="{attributes, events}">
                                                        <input
                                                        class="vs__search"
                                                            autocomplete="new-username"
                                                            v-bind="attributes"
                                                            v-on="events"/>
                                                     </template>
                                                </v-select>
                                    </span>
                                    </div>
                                    <div class="input-group mb-4 pt-1 px-lg-0 px-3">
									<span class="has-float-label">
                                        <v-select
                                                :class="{'error-shadow': $v.form.city.$error, 'required-select': $v.form.city.$invalid || $v.form.city.$error}"
                                                placeholder="City"
                                                label="name"
                                                class="form-control p-0 custom-select-scan scan-city"
                                                v-model="checkedCity"
                                                v-show="!emptyCitiesList"
                                                :options="cities">
                                            <template #search="{attributes, events}">
                                                <input
                                                        class="vs__search"
                                                        autocomplete="new-username"
                                                        v-bind="attributes"
                                                        v-on="events"
                                                />
                                            </template>
                                        </v-select>

                                        <template v-if="emptyCitiesList">
    										<input type="text" class="form-control" id="city" name="city" placeholder="City"
                                                   v-model="form.city" :class="{'error-shadow': $v.form.city.$error}"/>
    										<label class="control-label" for="city">City<span class="text-danger">*</span></label>
                                        </template>

									</span>
                                    </div>
                                    <div class="form-group input-group mb-4 pt-1 px-lg-0 px-3">
									<span class="has-float-label">
										<input type="text" class="form-control" id="store_address" name="store_address"
                                               placeholder="Store Address" v-model="form.store_address"
                                               :class="{'error-shadow': $v.form.store_address.$error}"/>
										<label class="control-label" for="store_address">Store Address<span class="text-danger">*</span></label>
									</span>
                                    </div>
                                    <div class="form-group input-group mb-4 pt-1 px-lg-0 px-3">
									<span class="has-float-label">
										<input type="text" class="form-control" id="po_box" name="po_box"
                                               placeholder="Postal code" v-model="form.po_box"
                                               :class="{'error-shadow': $v.form.po_box.$error}"/>
										<label class="control-label" for="po_box">Postal code<span class="text-danger">*</span></label>
									</span>
                                    </div>
                                    <div class="form-group input-group mb-4 pt-1 px-lg-0 px-3">
									<span class="has-float-label">
										<input type="text" class="form-control" id="user_email" name="user_email" placeholder="Email"
                                               v-model="user_email"
                                               :class="{'error-shadow': $v.user_email.$error}"/>
										<label class="control-label" for="user_email">Enter your email to receive the report<span class="text-danger">*</span></label>
									</span>
                                    </div>
                                    <div class="d-block">
                                        <div class="text-center inquiry-form d-flex flex-column flex-xl-row align-items-center justify-content-between">
                                            <a role="button"
                                               class="btn profile-btn continue-btn mb-0 font-26 text-white pointer text-uppercase bg-grey px-3 d-flex align-items-center"
                                               @click="addOne">
                                                <img src="/assets/images/plus.png" width="24" height="24" alt="add" class="mr-4"> ADD LOCATION
                                            </a>

                                            <a href="/manage-locations"
                                               class="btn profile-btn continue-btn mb-0 font-26 text-white pointer text-uppercase bg-grey px-3 d-flex align-items-center w-auto px-4">
                                                CANCEL
                                            </a>
                                        </div>
                                    </div>
                                   <!--  <div class="form-group input-group mb-4 pt-4 px-lg-0 px-3">
									<span class="custom-control custom-checkbox inline-block float-left mr-3">
										<input type="checkbox" class="custom-control-input" id="ReviewScore" v-model="form.policy">
										<label class="custom-control-label" for="ReviewScore" :class="{'error-shadow': policyValid}">
                                            <a class="small-label">By checking here i consent to receive message from <br> Geoking and agree to its Privacy Policy.</a>
                                        </label>
									</span>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 ">
                            <div class="d-block bg_blue py-5 h-100">
                                <div class="d-block my-lg-3 my-0">
                                    <div class="d-block px-md-5 px-3 mb-5">
                                        <h4 class="font-weight-normal text-white text-center">
                                            Please fill out the form below and get your <br>
                                            multilocation quick scan report to your inbox. For more than 5 locations, please use our <br>
                                            file upload or authenticate with Google.
                                        </h4>
                                    </div>
                                    <div class="clearfix w-100"></div>
                                    <div class="text-center d-flex flex-column justify-content-center align-items-center pt-5 w-100 px-4">
                                        <div class="col-12 col-lg-6 col-xl-5 bg-white p-3 location-scan d-flex justify-content-between"
                                             v-for="(item, index) in locations">
                                            {{ item.store_address }}
                                            <div class="d-flex">
                                                <a role="button" class="pointer mr-2" @click="editForm(locations[index])">
                                                    <img src="/assets/images/Edit.png" alt="edit">
                                                </a>
                                                <a role="button" class="pointer" @click="locations.splice(index, 1)">
                                                    <img src="/assets/images/Times.png" alt="remove">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-12 pt-5 d-flex flex-column" v-if="locations.length > 0">
                                            <div class="d-flex justify-content-center w-100 mb-3">
                                                <span class="custom-control custom-checkbox inline-block float-left mr-3">
                                                    <input type="checkbox" class="custom-control-input" id="ReviewScore" v-model="form.policy">
                                                    <label class="custom-control-label" for="ReviewScore" :class="{'error-shadow': policyValid}">
                                                        <a class="small-label text-white">By checking here i consent to receive message from <br> Geoking and agree to its Privacy Policy.</a>
                                                    </label>
                                                </span>
                                            </div>
                                            <div class="text-center inquiry-form d-flex flex-column flex-xl-row align-items-center justify-content-center w-100">
                                                <a role="button"
                                                class="btn profile-btn continue-btn mb-0 font-26 text-white pointer text-uppercase mb-3 mb-xl-0"
                                                @click="scan">SCAN LISTING</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="business-scan-results" v-show="part !== 1">
            <div class="row">
                <div class="col-12 pt-3">
                    <div class="blue-box">
                        <div class="row">
                            <div class="col-md-12 col-lg-5 col-xl-3 pb-4">
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
                            <div class="col-md-12 col-lg-4 col-xl-5 padding-top-35">
                                <h1>{{ result.name }}</h1>
                                <h2>{{ result.address }}</h2>
                                <h2>{{ result.phone }}</h2>
                            </div>
                            <div class="col-md-12 col-lg-3 col-xl-2">
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

            <div class="row" v-show="part == 2">
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
                            <tr v-if="result.google.name">
                                <td><img src="/assets/images/google-icon-big.png"/></td>
                                <td><i class="fa"
                                       :class="{'fa-check-circle listed': result.google.total_status == 'Listed' || result.google.total_status == 'Match',
									'fa-exclamation-circle mismatch': result.google.total_status == 'Mismatch',
									'fa-exclamation-circle notlist': result.google.total_status == 'Missing' || result.google.total_status == 'Not Verified' || result.google.total_status == 'Not Listed'}"
                                       aria-hidden="true"></i> <br>
                                    {{ result.google.total_status }}
                                </td>
                                <td>
                                    <i class="fa" :class="{'fa-check-circle listed': result.google.name.status == 'Listed' || result.google.name.status == 'Match',
									'fa-exclamation-circle mismatch': result.google.name.status == 'Mismatch',
									'fa-exclamation-circle notlist': result.google.name.status == 'Missing' || result.google.name.status == 'Not Verified' || result.google.name.status == 'Not Listed'}"
                                       aria-hidden="true"></i> <br>
                                    {{ result.google.name.status }}
                                </td>
                                <td>
                                    <i class="fa" :class="{'fa-check-circle listed': result.google.address.status == 'Listed' || result.google.address.status == 'Match',
									'fa-exclamation-circle mismatch': result.google.address.status == 'Mismatch',
									'fa-exclamation-circle notlist': result.google.address.status == 'Missing' || result.google.address.status == 'Not Verified' || result.google.address.status == 'Not Listed'}"
                                       aria-hidden="true"></i> <br>
                                    {{ result.google.address.status }}
                                </td>
                                <td>
                                    <i class="fa" :class="{'fa-check-circle listed': result.google.phone.status == 'Listed' || result.google.phone.status == 'Match',
									'fa-exclamation-circle mismatch': result.google.phone.status == 'Mismatch',
									'fa-exclamation-circle notlist': result.google.phone.status == 'Missing' || result.google.phone.status == 'Not Verified' || result.google.phone.status == 'Not Listed'}"
                                       aria-hidden="true"></i> <br>
                                    {{ result.google.phone.status }}
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-center">
                                        <p class="score_red_txt mb-3 pt-2">{{ result.google.score }}%</p>
                                        <a href="javascript:void(0)" class="lockation-status px-3 py-1">Fix</a>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td><img src="/assets/images/bing-icon-big.png"/></td>
                                <td><i class="fa fa-exclamation-circle notlist" aria-hidden="true"></i> <br>Not Listed</td>
                                <td><i class="fa fa-exclamation-circle notlist" aria-hidden="true"></i> <br>Not Listed</td>
                                <td><i class="fa fa-exclamation-circle notlist" aria-hidden="true"></i> <br>Not Listed</td>
                                <td><i class="fa fa-exclamation-circle notlist" aria-hidden="true"></i> <br>Not Listed</td>
                                <td>
                                    <div class="d-flex flex-column align-items-center">
                                        <p class="score_red_txt mb-3 pt-2">50%</p>
                                        <a href="javascript:void(0)" class="lockation-status px-3 py-1">Fix</a>
                                    </div>
                                </td>
                                <td class="overlay"><h3>coming soon</h3></td>
                            </tr>

                            <tr>
                                <td><img src="/assets/images/fb-icon-big.png"/></td>
                                <td><i class="fa fa-exclamation-circle notlist" aria-hidden="true"></i> <br>Not Verified</td>
                                <td><i class="fa fa-exclamation-circle notlist" aria-hidden="true"></i> <br>Missing</td>
                                <td><i class="fa fa-exclamation-circle notlist" aria-hidden="true"></i> <br>Missing</td>
                                <td><i class="fa fa-exclamation-circle mismatch" aria-hidden="true"></i> <br>Mismatch</td>
                                <td>
                                    <div class="d-flex flex-column align-items-center">
                                        <p class="score_red_txt mb-3 pt-2">50%</p>
                                        <a href="javascript:void(0)" class="lockation-status px-3 py-1">Fix</a>
                                    </div>
                                </td>
                                <td class="overlay"><h3>coming soon</h3></td>
                            </tr>
                            <tr>
                                <td><img src="/assets/images/force-icon-big.png"/></td>
                                <td><i class="fa fa-check-circle listed" aria-hidden="true"></i> <br>Listed</td>
                                <td><i class="fa fa-check-circle listed" aria-hidden="true"></i> <br>Match</td>
                                <td><i class="fa fa-check-circle listed" aria-hidden="true"></i> <br>Match</td>
                                <td><i class="fa fa-exclamation-circle notlist" aria-hidden="true"></i> <br>Missing</td>
                                <td>
                                    <div class="d-flex flex-column align-items-center">
                                        <p class="score_red_txt mb-3 pt-2">50%</p>
                                        <a href="javascript:void(0)" class="lockation-status px-3 py-1">Fix</a>
                                    </div>
                                </td>
                                <td class="overlay"><h3>coming soon</h3></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row" v-show="part == 3">
                <div class="col-12 pt-4">
                    <div class="table-responsive search-results-tble-cont">
                        <table id="searchResults" class="table table-striped table-bordered" width="100%">
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="sorting_disabled" v-for="result in listResults">{{ result.name }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><img src="/assets/images/google-icon-big.png"/></td>
                                <td v-for="result in listResults">{{ result.google.score }}%</td>
                            </tr>
                            <tr>
                                <td><img src="/assets/images/bing-icon-big.png"></td>
                                <td v-for="n in listResults.length">50%</td>
                            </tr>
                            <tr>
                                <td><img src="/assets/images/fb-icon-big.png"></td>
                                <td v-for="n in listResults.length">50%</td>
                            </tr>
                            <tr>
                                <td><img src="/assets/images/force-icon-big.png"></td>
                                <td v-for="n in listResults.length">50%</td>
                            </tr>
                            <tr>
                                <td class="font-22 font-weight-bold">Net Score</td>
                                <td v-for="n in listResults.length">50%</td>
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
  import { VueTelInput } from 'vue-tel-input'
  import { required, email } from 'vuelidate/lib/validators'
  import vSelect from 'vue-select'
  import VueEasyPieChart from 'vue-easy-pie-chart'
  import 'vue-easy-pie-chart/dist/vue-easy-pie-chart.css'

  export default {
    name: 'Scan',

    props: [],

    components: {
      vSelect,
      VueEasyPieChart,
      VueTelInput
    },

    data () {
      return {
        phoneValid: true,
        policyValid: false,
        emptyCitiesList: false,
        edit: false,
        checkedCountry: '',
        checkedProvince: '',
        checkedCity: '',
        countries: [],
        provinces: [],
        cities: [],
        result: {
          google: {},
        },
        listResults: [],
        meanScore: 0,
        part: 1,
        locations: [],
        form: {
          policy: false,
          country: '',
          province: '',
          po_box: '',
          city: '',
        },
        user_email: ''
      }
    },

    validations: {
      form: {
        store_name: { required },
        store_phone: { required },
        store_address: { required },
        po_box: { required },
        country: { required },
        province: { required },
        city: { required },
      },
      user_email: { required, email },
    },

    watch: {
      'checkedCountry' (val) {
        if (val) {
          this.$refs.telInput.choose(val.country)
          this.form.country = val.country
          axios.get('/api/geo/children/' + val.id).then(response => {
            this.form.province = ''
            this.checkedProvince = ''
            this.provinces = response.data
          }).catch(error => {
            console.error(error.response.data.message)
          })

          axios.get('/api/geo/cities/' + val.country)
          .then(response => {
            this.form.city = ''
            this.checkedCity = ''

            this.emptyCitiesList = !response.data.length

            this.cities = response.data
        }).catch(error => {
            console.error(error.response.data.message)
        })
        } else {
          this.form.country = ''
          this.form.city = ''
          this.form.province = ''
          this.checkedProvince = ''
          this.checkedCity = ''
        }
      },

      'checkedProvince' (val) {
        if (val) {
          this.form.province = val.name

          let position = {
            lat: Number(val.lat),
            lng: Number(val.long),
          }
          this.$emit('get-position', position)
        } else {
          this.form.province = ''
        }
      },

      'checkedCity'(val) {
        if (val) {
            this.form.city = val.name
        } else {
            this.form.city = ''
            this.checkedCity = ''
        }
    }
    },

    mounted() {
        $('#tel-input input').attr('id', 'ContactPhone')
        $('#tel-input input').attr('class', 'form-control')
        $('#tel-input').append( "<label class='control-label' for='ContactPhone'>Store Phone <span class='text-danger'>*</span> </label>" )
    },

    methods: {
        onInput({ number, isValid, country }) {
            this.phoneValid = isValid;
        },

      addOne () {
        this.$v.form.$touch()
        let isValid = !this.$v.form.$invalid
        if (isValid && this.phoneValid) {
          if (this.edit) {
            this.form = {}
            this.checkedCountry = ''
            this.checkedProvince = ''
            this.$v.$reset()
            this.edit = false
          } else {
            this.locations.push(this.form)
            this.form = {}
            this.checkedCountry = ''
            this.checkedProvince = ''
            this.$v.$reset()
          }

        }
      },

      scan () {
        this.policyValid = !this.form.policy;

        this.$v.user_email.$touch()

        let isValid = !this.$v.user_email.$invalid

        if (this.locations.length > 0 && !this.policyValid && isValid) {
          axios.post('/scan', {locations: this.locations, email: this.user_email}).then(response => {
            let list = response.data.reduce((carry, item) => null !== item.result ? carry.concat([item.result]) : carry, [])
            let totalScore = list.reduce((carry, item) => carry + item.mean_score, 0)

            if (list.length > 0) {
              this.listResults = list
              this.meanScore = (totalScore/response.data.length).toFixed(2)
              this.result = list[0]
              this.policyValid = false
              this.form = {}
              this.part = list.length > 1 ? 3 : 2
            } else {
              this.locations = []
              this.form = {}
            }
          }).catch(error => {

          })
        }
      },
      editForm (data) {
        this.edit = true
        this.form = data
      },
    },
    computed: {
      resultPercent () {
        let res = this.meanScore
        if (res) {
          return parseInt(res)
        } else {
          return 0
        }
      },
      trackColor () {
        let res = this.meanScore
        if (res >= 81 && res <= 100) {
          return '#0f6f06'
        } else if (res >= 61 && res <= 80) {
          return '#e1780c'
        } else {
          return '#e80029'
        }
      },
    },

    created () {
      axios.get('/api/geo/countries').then(response => {
        this.countries = response.data
      }).catch(error => {
        console.error(error.response.data.message)
      })
    },

  }
</script>