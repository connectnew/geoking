<template>
    <div v-bind:style="show ? 'display: block;' : 'display: none;'">
        <div class="dropdowns d-md-flex justify-content-between">
            <div class="dropdowns__items d-sm-flex flex-wrap">
                <div class="col-sm-6 dropdowns__item">
                    <img src="/img/chd.png" alt="chd" />
                    <select v-model="filter.category_id" @change="showSmart()">
                        <option :value="null">Categories</option>
                        <option v-for="cat in category" v-bind:value="cat.id">{{ cat.name }}</option>
                    </select>
                </div>
                <div class="col-sm-6 dropdowns__item">
                    <img src="/img/chd.png" alt="chd" />
                    <select v-model="filter.positive" @change="showSmart()">
                        <option :value="null">Positive/Negative</option>
                        <option value="1">Positive</option>
                        <option value="0">Negative</option>
                    </select>
                </div>
                <div class="col-sm-6 dropdowns__item">
                    <img src="/img/chd.png" alt="chd" />
                    <select v-model="filter.language_id" @change="showSmart()">
                        <option :value="null">Language</option>
                        <option v-for="lang in language" v-bind:value="lang.id">{{ lang.name }}</option>
                    </select>
                </div>
                <div class="col-sm-6 dropdowns__item">
                    <img src="/img/chd.png" alt="chd" />
                    <select v-model="filter.sector_id" @change="showSmart()">
                        <option :value="null">Business Sector</option>
                        <option v-for="sec in sector" v-bind:value="sec.id">{{ sec.title }}</option>
                    </select>
                </div>
            </div>
            <i class="fa fa-plus manage align-self-center" v-if="auth" @click="showManage()"></i>
        </div>

        <vue-smart-tab-paginate v-bind:filter="filter" v-bind:auth="auth" v-bind:auth_is_admin="auth_is_admin"></vue-smart-tab-paginate>

    </div>
</template>

<script>
    export default {
        name: 'SmartTabSuggested',
        data() {
            return {
                show: false,
                filter : {
                    sector_id : null,
                    category_id : null,
                    language_id : null,
                    positive : null,
                    search : null,
                    per_page : 8,
                    page : 1,
                }
            }
        },
        props: ['category', 'sector', 'language', 'auth', 'auth_is_admin', 'review'],
        methods: {
            showManage() {
                window.location.href = "/response/manage";
            },
            showSmart() {
                this.$root.$emit('showSmartPaginate', 1);
            },
        },
        mounted() {
            this.$root.$on('showSmartSuggested', (action) => {
                if(action){
                    this.show = true;
                    this.filter.sector_id = this.review.domain_id;
                    this.filter.category_id = this.review.category_id;
                    this.filter.language_id = this.review.language_id;
                    this.filter.positive = this.review.positive;
                    this.$root.$emit('showSmartPaginate', 1);
                } else {
                    this.show = false;
                    this.$root.$emit('showSmartPaginate', 0);
                }
            });
        }
    }
</script>