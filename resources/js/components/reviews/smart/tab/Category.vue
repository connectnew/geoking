<template>
    <div>
        <div class="dropdowns2 d-flex justify-content-end">
            <a class="back" v-if="show_smart" @click="backCatelog()"><i class="fa fa-caret-left"></i> show all categories</a>
        </div>
        <div class="d-flex flex-wrap cards__items" v-if="!show_smart">
            <a @click="showSmart(cat.id)" class="col-md-4 link" v-for="cat in category">
                <div class="cards__item">
                    <div>
                        <img v-bind:src="'/images/category/'+cat.icon" alt="img"/>
                        <p>{{ cat.name }}</p>
                    </div>
                </div>
            </a>
        </div>

        <vue-smart-tab-paginate v-if="show_smart" v-bind:filter="filter"></vue-smart-tab-paginate>
    </div>
</template>

<script>
    export default {
        name: 'SmartTabCategory',
        data() {
            return {
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
        props: ['category', 'search'],
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
        methods: {
            backCatelog() {
                this.show_smart = false;
                this.$root.$emit('allowSmartSearch', 0);

            },
            showSmart(id) {
                this.show_smart = true;
                this.filter.category_id = id;
            },
        },
        mounted() {
            this.$root.$emit('allowSmartSearch', 0);
        }
    }
</script>