<template>
    <div>
        <div class="dropdowns2 d-flex flex-column justify-content-end all-smart-response">

            <div class="d-flex flex-wrap dropdowns2__items">
                <div class="dropdowns2__item col-sm-6">
                    <select v-model="filter.category_id">
                        <option :value="0">Select category</option>
                        <option v-for="cat in category" v-bind:value="cat.id">{{ cat.name }}</option>
                    </select>
                </div>
                <div class="dropdowns2__item col-sm-6">
                    <select v-model="filter.language_id">
                        <option :value="0">Select language</option>
                        <option v-for="lang in language" v-bind:value="lang.id">{{ lang.name }}</option>
                    </select>
                </div>
                <div class="dropdowns2__item col-sm-6">
                    <select v-model="filter.positive">
                        <option :value="null">Select tonality</option>
                        <option value="1">Positive</option>
                        <option value="0">Negative</option>
                    </select>
                </div>
                <div class="dropdowns2__item col-sm-6">
                    <select v-model="filter.sector_id">
                        <option :value="0">Select business sector</option>
                        <option v-for="sec in sector" v-bind:value="sec.id">{{ sec.title }}</option>
                    </select>
                </div>
            </div>

            <vue-smart-tab-paginate v-bind:filter="filter"></vue-smart-tab-paginate>

        </div>
    </div>
</template>

<script>
    export default {
        name: 'SmartTabAll',
        data() {
            return {
                show: false,
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
        props: ['category', 'sector', 'language', 'search'],
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
        },
        mounted() {

        }
    }
</script>