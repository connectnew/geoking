<template>
    <div v-bind:style="show ? 'display: block;' : 'display: none;'">
        <div class="dropdowns2 d-flex justify-content-end">
            <a class="back" v-if="show_smart" @click="backSector()"><i class="fa fa-caret-left"></i> show all sectors</a>
            <i class="fa fa-plus manage" v-if="auth" @click="showManage()"></i>
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

        <vue-smart-tab-paginate v-bind:filter="filter" v-bind:auth="auth" v-bind:auth_is_admin="auth_is_admin"></vue-smart-tab-paginate>
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
        props: ['sector', 'auth', 'auth_is_admin'],
        methods: {
            showManage() {
                window.location.href = "/response/manage";
            },
            backSector() {
                this.show_smart = false;
                this.$root.$emit('showSmartPaginate', 0);
            },
            showSmart(id) {
                this.show_smart = true;
                this.filter.sector_id = id;
                this.$root.$emit('showSmartPaginate', 1);
            }
        },
        mounted() {
            this.$root.$on('showSmartSector', (action) => {
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