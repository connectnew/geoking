<template>
    <div v-bind:style="show ? 'display: block;' : 'display: none;'">
        <div class="dropdowns2 d-flex flex-column justify-content-end all-smart-response">

            <i class="fa fa-plus ml-auto manage" v-if="auth" @click="showManage()"></i>
            <div class="d-flex flex-wrap dropdowns2__items">
                <div class="dropdowns2__item col-sm-6">
                    <select v-model="filter.category_id" @change="showSmart()">
                        <option :value="null">Select category</option>
                        <option v-for="cat in category" v-bind:value="cat.id">{{ cat.name }}</option>
                    </select>
                </div>
                <div class="dropdowns2__item col-sm-6">
                    <select v-model="filter.language_id" @change="showSmart()">
                        <option :value="null">Select language</option>
                        <option v-for="lang in language" v-bind:value="lang.id">{{ lang.name }}</option>
                    </select>
                </div>
                <div class="dropdowns2__item col-sm-6">
                    <select v-model="filter.positive" @change="showSmart()">
                        <option :value="null">Select tonality</option>
                        <option value="1">Positive</option>
                        <option value="0">Negative</option>
                    </select>
                </div>
                <div class="dropdowns2__item col-sm-6">
                    <select v-model="filter.sector_id" @change="showSmart()">
                        <option :value="null">Select business sector</option>
                        <option v-for="sec in sector" v-bind:value="sec.id">{{ sec.title }}</option>
                    </select>
                </div>
            </div>

            <vue-smart-tab-paginate v-bind:filter="filter" v-bind:auth="auth" v-bind:auth_is_admin="auth_is_admin"></vue-smart-tab-paginate>

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
        props: ['category', 'sector', 'language', 'auth', 'auth_is_admin'],
        methods: {
            showManage() {
                window.location.href = "/response/manage";
            },
            showSmart() {
                this.$root.$emit('showSmartPaginate', 1);
            },
        },
        mounted() {
            this.$root.$on('showSmartAll', (action) => {
                if(action){
                    this.show = true;
                    this.$root.$emit('showSmartPaginate', 1);
                } else {
                    this.show = false;
                    this.$root.$emit('showSmartPaginate', 0);
                }
            });
        }
    }
</script>