<template>
    <div>
        <div class="dropdowns2 d-flex justify-content-end">
            <a class="back" v-if="show_smart" @click="backSector()"><i class="fa fa-caret-left"></i> show all sectors</a>
        </div>
        <div class="d-flex flex-wrap cards__items" v-if="!show_smart">
            <a class="col-md-4 link" @click="showSmart(sec.id)" v-for="sec in sector">
                <div class="cards__item">
                    <div>
                        <img v-bind:src="'/images/domain/white/'+sec.icon" alt="img" />
                        <p>{{ sec.title }}</p>
                    </div>
                </div>
            </a>
        </div>

        <vue-smart-tab-paginate v-if="show_smart" v-bind:filter="filter"></vue-smart-tab-paginate>
    </div>
</template>

<script>
    export default {
        name: 'SmartTabSector',
        data() {
            return {
                show: false,
                show_smart: false,
                filter : {
                    sector_id : 0,
                    category_id : 0,
                    language_id : 0,
                    positive : null,
                    search : null,
                    per_page : 8,
                    page : 1,
                },
            }
        },
        watch: {
            needRefresh: function(val) {
                this.filter.search = this.search;
            }
        },
        computed: {
            needRefresh() {
                return `${this.search}`;
            },
        },
        props: ['sector', 'search'],
        methods: {
            backSector() {
                this.show_smart = false;
                this.$root.$emit('allowSmartSearch', 0);
            },
            showSmart(id) {
                this.show_smart = true;
                this.filter.sector_id = id;
            }
        },
        mounted() {
            this.$root.$emit('allowSmartSearch', 0);
        }
    }
</script>