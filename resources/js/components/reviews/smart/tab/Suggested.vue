<template>
    <div>
        <div class="dropdowns d-md-flex justify-content-between">
            <div class="dropdowns__items d-sm-flex flex-wrap">
                <div class="col-sm-6 dropdowns__item">
                    <img src="/img/chd.png" alt="chd" />
                    <select v-model="filter.category_id">
                        <option :value="0">Categories</option>
                        <option v-for="cat in category" v-bind:value="cat.id">{{ cat.name }}</option>
                    </select>
                </div>
                <div class="col-sm-6 dropdowns__item">
                    <img src="/img/chd.png" alt="chd" />
                    <select v-model="filter.positive">
                        <option :value="null">Positive/Negative</option>
                        <option value="1">Positive</option>
                        <option value="0">Negative</option>
                    </select>
                </div>
                <div class="col-sm-6 dropdowns__item">
                    <img src="/img/chd.png" alt="chd" />
                    <select v-model="filter.language_id">
                        <option :value="0">Language</option>
                        <option v-for="lang in language" v-bind:value="lang.id">{{ lang.name }}</option>
                    </select>
                </div>
                <div class="col-sm-6 dropdowns__item">
                    <img src="/img/chd.png" alt="chd" />
                    <select v-model="filter.sector_id">
                        <option :value="0">Business Sector</option>
                        <option v-for="sec in sector" v-bind:value="sec.id">{{ sec.title }}</option>
                    </select>
                </div>
            </div>
        </div>

        <vue-smart-tab-paginate v-bind:filter="filter"></vue-smart-tab-paginate>

    </div>
</template>

<script>
    export default {
        name: 'SmartTabSuggested',
        data() {
            return {
                filter : {
                    sector_id : 0,
                    category_id : 0,
                    language_id : 0,
                    positive : null,
                    search : null,
                    per_page : 8,
                    page : 1,
                }
            }
        },
        watch: {
            needRefresh: function(val) {
                this.filter.sector_id = this.review.domain_id;
                this.filter.category_id = this.review.category_id;
                this.filter.language_id = this.review.language_id;
                this.filter.positive = this.review.positive;
                this.filter.search = this.search;
            }
        },
        computed: {
            needRefresh() {
                return `${this.review.category_id}|${this.review.domain_id}|${this.review.language_id}|${this.review.positive}|${this.search}`;
            },
        },
        props: ['category', 'sector', 'language', 'search', 'review', 'nav'],
        methods: {
        },
        mounted() {
            this.filter.sector_id = this.review.domain_id;
            this.filter.category_id = this.review.category_id;
            this.filter.language_id = this.review.language_id;
            this.filter.positive = this.review.positive;
        }
    }
</script>