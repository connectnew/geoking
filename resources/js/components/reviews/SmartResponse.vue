<template>
	<div class="row mt-3">
        <div class="col-12">
          <div class="smart_responses_page">
            <div class="row">
              <div class="col-12">
                <div class="row mb-2 mt-2">
                  <div class="page-breadcrumb col-lg-4 col-md-12 col-12 form-group">
                    <h4 class="page-title  mt-1">Smart Responses (8)</h4>
                    <a href="javascript:void(0)" class="btn btn-basic custom-btn-rounded custom-btn-disabled" @click="smartResponse({})">Add Smart Response</a>
                  </div>
              
                  <div class="col-lg-8 col-md-12 col-12 form-group text-left text-lg-right">
                     <div class="btn-group" role="group">
                      <a class="btn btn-light">Positive </a>
                      <a class="btn btn-light">Negative </a>
                      <a class="btn btn-light active">All</a>
                    </div>
                    <div class="d-lg-block"> <a href="#" class="btn btn-light custom-btn-rounded">Food</a> <a href="#" class="btn btn-basic custom-btn-rounded custom-btn-disabled">Location</a> <a href="#" class="btn btn-basic custom-btn-rounded custom-btn-disabled">Service</a>
                    <a href="#" class="btn btn-basic custom-btn-rounded custom-btn-disabled">Price</a>
                    <a href="#" class="btn btn-basic custom-btn-rounded custom-btn-disabled">Other</a> </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <vuetable class="table table-striped post-tbl" ref="vuetable"
                          :api-url="'/api/v1/responses?paginate=1'"
                          :fields="fields"
                          :sort-order="sortOrder"
                          :multi-sort="true"
                          data-path="data"
                          pagination-path=""
                          pagination-component="VuetablePagination"
                          @vuetable:pagination-data="onPaginationData">
                            <template slot="actions" slot-scope="props">
                              
                            </template>
                          </vuetable>
                          <vuetable-pagination ref="pagination"
                          @vuetable-pagination:change-page="onChangePage"
                          :css="$root.paginationStyle"></vuetable-pagination>
                  <!-- <button type="submit" class="btn_blue"><i class="fa fa-plus"></i> Add New Smart Response</button>                  -->
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

	export default {
		name: 'SmartResponse',

    components: {
      Vuetable,
      VuetablePagination,
      VuetablePaginationInfo,
      PaginationMixin
    },

		props: [],

		data() {
			return {
        fields: [
          {
            name: 'name',
            title: 'Name',
            sortField: 'name',
            dataClass: 'pt-3',
          },
          {
            name: 'content',
            title: 'Content',
            sortField: 'content',
            dataClass: 'pt-3',
          },
          {
            name: 'reviewType',
            title: 'Review Type',
            sortField: 'reviewType',
            dataClass: 'pt-3',
          },
          {
            name: 'status',
            title: 'Auto Respond',
            sortField: 'status',
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

		computed: {

		},

		mounted() {

		},

		methods: {
          onPaginationData (paginationData) {
            this.$refs.pagination.setPaginationData(paginationData)
          },

          onChangePage (page) {
            this.$refs.vuetable.changePage(page)
          },
          smartResponse (smart) {
            this.$root.$emit('showSmartManageModal', smart)
          },
		},

		created() {

		}

	}
</script>