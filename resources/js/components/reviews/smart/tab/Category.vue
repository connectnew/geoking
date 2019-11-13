<template>
    <div v-bind:style="show ? 'display: block;' : 'display: none;'">
        <div class="dropdowns2 d-flex justify-content-end">
            <a class="back" v-if="show_smart" @click="backCatelog()"><i class="fa fa-caret-left"></i> show all categories</a>
            <i class="fa fa-plus manage" v-if="auth" @click="showManage()"></i>
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

        <vue-smart-tab-paginate v-bind:filter="filter" v-bind:auth="auth" v-bind:auth_is_admin="auth_is_admin"></vue-smart-tab-paginate>

    </div>
</template>

<script>
    export default {
        name: 'SmartTabCategory',
        data() {
            return {
                show: false,
                show_smart: false,
                filter : {
                    sector_id : null,
                    category_id : null,
                    language_id : null,
                    positive : null,
                    search : null,
                    per_page : 8,
                    page : 1,
                },
            }
        },
        props: ['category', 'auth', 'auth_is_admin'],
        methods: {
            showManage() {
                window.location.href = "/response/manage";
            },
            backCatelog() {
                this.show_smart = false;
                this.$root.$emit('showSmartPaginate', 0);
            },
            showSmart(id) {
                this.show_smart = true;
                this.filter.category_id = id;
                this.$root.$emit('showSmartPaginate', 1);
            },
        },
        mounted() {
            this.$root.$on('showSmartCategory', (action) => {
                if(action){
                    this.show = true;
                    this.show_smart = false;
                } else {
                    this.show = false;
                    this.show_smart = false;
                    this.$root.$emit('showSmartPaginate', 0);
                }
            });
        }
    }
</script>