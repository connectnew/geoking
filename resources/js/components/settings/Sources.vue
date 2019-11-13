<template>
    <div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="manage-locations-page">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="profile">
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
                                    <div class="row_mob mt-1 text-right">
                                        <div class="col mx-w-150 px-lg-1 px-2 d-md-inline-block">
                                            <a role="button" href="/source/export" class="d-flex align-items-center justify-content-center btn btn-black">
                                                <img src="/assets/images/location-icon.png" class="pr-3"> <span>Download all</span>
                                            </a>
                                        </div>
                                        <div class="col mx-w-150 px-lg-1 px-2 d-md-inline-block">
                                            <button class="d-flex align-items-center justify-content-center btn btn-blue" data-toggle="modal" data-target="#AddMany">
                                                <img src="/assets/images/location-icon.png" class="pr-3"> <span>Import locations</span>
                                            </button>
                                        </div>
                                        <div class="col-lg-3 col-12 mt-lg-0 mt-3 d-md-inline-block">
                                            <form class="search-location" action="#">
                                                <span class="position-relative d-inline-block mr-3 mt_1">
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
                                                      :api-url="'/source'"
                                                      :http-method="'post'"
                                                      :perPage="perPage"
                                                      :fields="fields"
                                                      :sort-order="sortOrder"
                                                      :multi-sort="true"
                                                      data-path="data"
                                                      pagination-path=""
                                                      pagination-component="VuetablePagination"
                                                      @vuetable:pagination-data="onPaginationData">
                                                <template slot="source_ref" slot-scope="props">
                                                    <div class="d-flex align-items-center">
                                                        <p class="mb-0">{{ props.rowData.website }}</p>
                                                    </div>
                                                </template>
                                                <template slot="location_ref" slot-scope="props">
                                                    <div v-show="props.rowData.editable">
                                                        <select class="d-inline-block" v-model="props.rowData.gmb_place_id">
                                                            <option v-for="option in locations" :value="option.raw_data.name">{{ option.title }}</option>
                                                        </select>
                                                        <button class="btn btn-link" @click="onSave(props.rowData)"><i class="fa fa-save"></i></button>
                                                    </div>
                                                    <div v-show="!props.rowData.editable">
                                                        <span v-if="props.rowData.location" class="">{{ props.rowData.location.title }}</span>
                                                        <span v-else class="toggle-ellipsis max-w-120" @click="onCellClicked">{{ props.rowData.gmb_place_id }}</span>
                                                        <button class="btn btn-link" @click="onEdit(props.rowData)"><i class="fa fa-edit"></i></button>
                                                    </div>
                                                </template>
                                                <template slot="actions" slot-scope="props">
                                                    <a href="#">
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
    </div>
</template>

<script>
  import Vuetable from 'vuetable-2'
  import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
  import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
  import PaginationMixin from 'vuetable-2/src/components/VuetablePaginationMixin.vue'

  import IconPencil from '../icons/Pencil'
  import IconTrash from '../icons/Trash'

  export default {
    name: 'Sources',

    components: {
      Vuetable,
      VuetablePagination,
      VuetablePaginationInfo,
      PaginationMixin,

      IconPencil,
      IconTrash,
    },

    props: ['user', 'locations'],

    data () {
      return {
        perPage: 10,
        loaded: false,
        fields: [
          {
            name: 'external_id',
            title: 'Number',
            sortField: 'external_id',
            dataClass: 'pt-3',
          },
          {
            name: 'name',
            title: 'Location Name',
            sortField: 'name',
            dataClass: 'pt-3',
          },
          {
            name: 'phone',
            title: 'Phone',
            sortField: 'phone',
            dataClass: 'pt-3',
          },
          {
            name: 'country',
            title: 'Country',
            sortField: 'country',
            dataClass: 'pt-3',
          },
          {
            name: 'province',
            title: 'Province',
            sortField: 'province',
            dataClass: 'pt-3',
          },
          {
            name: 'city',
            title: 'City',
            sortField: 'city',
            dataClass: 'pt-3',
          },
          {
            name: 'address',
            title: 'Address',
            sortField: 'address',
            dataClass: 'pt-3',
          },
          {
            name: 'postal_code',
            title: 'Postal code',
            sortField: 'postal_code',
            dataClass: 'pt-3',
          },
          {
            name: '__slot:source_ref',
            title: 'Website',
            sortField: 'website',
            titleClass: 'text-left',
            dataClass: 'text-left pt-3',
          },
          {
            name: '__slot:location_ref',
            title: 'Reference',
            sortField: 'gmb_place_id',
            dataClass: 'pt-3',
          },
          {
            name: '__slot:actions',
            title: 'Action',
            dataClass: 'pt-3',
          },
        ],
        sortOrder: [],
      }
    },

    watch: {
      'perPage' (val) {
        Vue.nextTick(() => this.$refs.vuetable.refresh())
      },
    },

    methods: {
      onPaginationData (paginationData) {
        this.$refs.pagination.setPaginationData(paginationData)
      },

      onChangePage (page) {
        this.$refs.vuetable.changePage(page)
      },

      onCellClicked (event) {
        let classes = event.target.className.split(' '),
          idx = classes.indexOf('active')
        if (idx > 0) {
          do {
            classes.splice(idx, 1)
            idx = classes.indexOf('active')
          } while (idx !== -1)
        } else {
          classes.push('active')
        }
        event.target.className = classes.join(' ')
      },

      onEdit :function(source) {
        this.$set(source, 'editable', true)
      },
      onSave : function(source) {
        let self = this
        axios.post('/source/edit',
          source
        ).then(response => {
          self.$set(source, 'gmb_place_id', response.data.gmb_place_id ? response.data.gmb_place_id : null)
          self.$set(source, 'location', response.data.location ? response.data.location : null)
        }).catch(error => {
          console.log(error)
        }).finally(() => {
          self.$set(source, 'editable', false)
        })
      },
    },
    computed: {},
    created () {

    },
    mounted() {
      this.$root.$on('sourcesUpdated', () => {
        this.$refs.vuetable.refresh()
      })
    }
  }
</script>