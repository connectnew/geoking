<template>
    <div class="modal smart-response-modal" style="overflow-x: hidden; overflow-y: auto;" v-bind:style="show ? 'display: block;' : 'display: none'" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Smart Response</h3>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-times-circle-o" aria-hidden="true" style="font-size: 25px; outline: 0px;" @click="modalHide()"></i>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">

                    <div class="main container">
                        <div class="row" id="app">
                            <aside class="aside col-xl-4">
                                <vue-smart-layout-left></vue-smart-layout-left>
                            </aside>
                            <section class="content col-xl-8">

                                <nav class="nav">
                                    <ul class="menu  d-sm-inline-block  d-md-flex">
                                        <li v-bind:class="nav == 'SmartTabSuggested' ? 'menu-active' : ''">
                                            <a href="javascript:void(0)" @click="changeTab('SmartTabSuggested')">Suggested Responses </a>
                                        </li>
                                        <li v-bind:class="nav == 'SmartTabAll' ? 'menu-active' : ''">
                                            <a href="javascript:void(0)" @click="changeTab('SmartTabAll')">All Responses </a>
                                        </li>
                                        <li v-bind:class="nav == 'SmartTabSector' ? 'menu-active' : ''">
                                            <a href="javascript:void(0)" @click="changeTab('SmartTabSector')">Responses by Sector</a>
                                        </li>
                                        <li v-bind:class="nav == 'SmartTabCategory' ? 'menu-active' : ''">
                                            <a href="javascript:void(0)" @click="changeTab('SmartTabCategory')">Responses by category</a>
                                        </li>
                                    </ul>
                                </nav>

                                <component v-bind:is="nav" v-bind:nav="nav" v-bind:search="search" v-bind:category="category" v-bind:sector="sector" v-bind:language="language" v-bind:auth="auth" v-bind:auth_is_admin="auth_is_admin" v-bind:review="review"></component>

                            </section>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import SmartTabSuggested from './tab/Suggested.vue'
    import SmartTabAll from './tab/All.vue'
    import SmartTabSector from './tab/Sector.vue'
    import SmartTabCategory from './tab/Category.vue'

    export default {
        name: 'SmartResponseModal',
        data() {
            return {
                show : false,
                review : {},
                nav: '',
                category: {},
                sector: {},
                language: {},
                auth: false,
                auth_is_admin: false,
                search: null,
            }
        },
        components: {
            SmartTabSuggested,
            SmartTabAll,
            SmartTabSector,
            SmartTabCategory
        },
        methods: {
            modalHide() {
                this.show = false;
                this.review = {};
                this.search = null;
            },
            changeTab(tab) {
                this.search = null;
                this.nav = tab;
            }
        },
        mounted () {

            this.$root.$on('showSmartResponseModal', (review) => {
                this.show = true;
                this.review = review;
                this.changeTab('SmartTabSuggested');
            });
            this.$root.$on('selectSmartResponse', (smart) => {
                let review = this.review;
                this.modalHide();
                this.$root.$emit('showReviewReplyWithSmartModal', review, smart);
            });
            this.$root.$on('filterSmartBySearch', (search) => {
                this.search = search ? search : null;
            });

            axios.post('/smart-response/get-all-category', { category: true, sector: true, language: true })
                .then(response => {

                    this.category = response.data.category;
                    this.language = response.data.language;
                    this.sector = response.data.sector;
                    this.auth = response.data.auth;
                    this.auth_is_admin = response.data.auth_is_admin;
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => {
                });
        }
    }

</script>