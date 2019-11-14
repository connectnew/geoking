<template>

    <div class="mas" v-if="smart.total">
        <div class=" mas__items">
            <div class="row flex-wrap">
                <div class="col-md-6 mas__item" v-for="iter in smart.data">
                    <p>{{ iter.text }}</p>
                    <div class="d-flex">
                        <a class="btn-copy" @click="copySmart(iter.text)"><img src="/img/page.png" alt="page"/></a>
                        <button @click="selectSmart(iter)">SELECT</button>
                    </div>
                </div>
            </div>

        </div>
        <div class="pagination d-flex justify-content-center">
            <div class="pagination__item pagination__prev" @click="changePage(pagination.prev.page, 'prev')" v-bind:class="pagination.prev.show ? '' : 'not_active'">
                <img src="/img/chl.png" alt="chl"/>
            </div>
            <div class="pagination__item pagination__number" v-for="page in pagination.page" v-bind:class="page == smart.current_page ? 'pagination__number-active' : ''" @click="changePage(page, 'page')">{{ page }}</div>
            <div class="pagination__item pagination__next" @click="changePage(pagination.next.page, 'next')" v-bind:class="pagination.next.show ? '' : 'not_active'">
                <img src="/img/chr.png" alt="chr"/>
            </div>
        </div>
    </div>

</template>

<script>

    export default {
        name: 'SmartTabPaginate',
        data() {
            return {
                smart: { total: 0 },
                pagination: {
                    page : {},
                    page_current : 0,
                    prev : { show : false, page : 0 },
                    next : { show : false, page : 0 }
                },
            }
        },
        props: ['filter', 'show'],
        methods: {
            copySmart(text) {
                this.$clipboard(text);
            },
            selectSmart(smart) {
                this.$root.$emit('selectSmartResponse', smart);
            },
            getSmart() {

                axios.post('/smart-response/get-by-category', this.filter)
                    .then(response => {

                        this.pagination = this.calculatePaginate(response.data);
                        this.smart = response.data;
                        if(this.smart.total){
                            this.$root.$emit('allowSmartSearch', 1);
                        }
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => {
                    });
            },
            calculatePaginate(data) {

                var pagination = {
                    page : {},
                    page_current : 0,
                    prev : { show : false, page : 0 },
                    next : { show : false, page : 0 }
                };

                var n = 0;
                var start = 0;
                var end = 0;
                var range = 4;

                if(data.current_page - range > 0){
                    start = data.current_page - range;
                } else {
                    start = 1;
                }

                if(data.current_page + range <= data.last_page){
                    end = data.current_page + range;
                } else {
                    end = data.last_page;
                }

                if(data.current_page > 1){
                    pagination.prev.show = true;
                    pagination.prev.page = data.current_page - 1;
                }
                if(data.current_page < data.last_page){
                    pagination.next.show = true;
                    pagination.next.page = data.current_page + 1;
                }

                for(let i = start; i <= end; i++) {
                    pagination.page[n] = i;
                    n ++;
                }

                pagination.page_current = data.current_page;

                return pagination;
            },
            changePage(page, event) {

                if(event == 'prev' && !this.pagination.prev.show){
                    return false;
                }
                if(event == 'next' && !this.pagination.next.show){
                    return false;
                }
                if(event == 'page' && page == this.pagination.page_current){
                    return false;
                }

                this.filter.page = page;
                this.getSmart();
            }

        },
        watch: {
            needRefresh: function(val) {
                this.getSmart();
            }
        },
        computed: {
            needRefresh() {
                return `${this.filter.category_id}|${this.filter.sector_id}|${this.filter.language_id}|${this.filter.positive}|${this.filter.search}`;
            },
        },
        mounted() {

            this.$root.$emit('allowSmartSearch', 0);
            this.getSmart();
        }
    }

</script>