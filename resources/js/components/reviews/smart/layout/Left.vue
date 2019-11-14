<template>
    <div>
        <h1 class=" aside__title">
            Knowledge base
        </h1>
        <a data-reload>English</a>
        <a data-reload>Arabic</a>
        <div class="aside__search">
            <div>
                Search for response
            </div>
            <form class="d-flex" onsubmit="return false;">
                <input class="col" type="text" v-model="search" v-on:keyup.enter="keyEnter()" v-bind:disabled="disable"/>
                <button class="ml-auto" @click="searchSmart()" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>
        <div class="aside__items">
            <div class="aside__item d-md-flex">
                <div class="aside__item-img d-flex align-items-center">
                    <img src="/img/it1.png" alt="it1" />
                </div>
                <div class="aside__item-text">
                    <h2>Learn</h2>
                    <p>
                        Find more responses by <br />
                        vertical or by <br />
                        category
                    </p>
                </div>
            </div>
            <div class="aside__item d-md-flex">
                <div class="aside__item-img d-flex align-items-center">
                    <img src="/img/it2.png" alt="it1" />
                </div>
                <div class="aside__item-text">
                    <h2>Live Agent</h2>
                    <p>
                        Hire a qualified and specialized <br />
                        live agent here. Satisfaction or <br />
                        your money back.
                    </p>
                </div>
            </div>
            <div class="aside__item d-md-flex">
                <div class="aside__item-img d-flex align-items-center">
                    <img src="/img/it3.png" alt="it1" />
                </div>
                <div class="aside__item-text">
                    <h2>Download playbook</h2>
                    <p>
                        Resources for repetable and predictable implementations.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'SmartLayoutLeft',
        data() {
            return {
                search: null,
                disable : true,
            }
        },
        methods: {
            keyEnter() {
                this.searchSmart();
            },
            searchSmart() {
                this.$root.$emit('filterSmartBySearch', this.search);
            }
        },
        mounted() {
            this.$root.$on('allowSmartSearch', (status) => {
                if(status){
                    this.disable = false;
                } else {
                    this.disable = true;
                    this.search = null;
                }
            });
        }
    }
</script>