<template>
    <div class="main container">
        <div class="row" id="app">
            <aside class="aside col-xl-4">
                <vue-smart-layout-left></vue-smart-layout-left>
            </aside>
            <section class="content col-xl-8">

                <nav class="nav">
                    <vue-smart-layout-nav></vue-smart-layout-nav>
                </nav>

                <vue-smart-tab-suggested v-bind:category="category" v-bind:sector="sector" v-bind:language="language" v-bind:auth="auth" v-bind:auth_is_admin="auth_is_admin" v-bind:review="review"></vue-smart-tab-suggested>
                <vue-smart-tab-all v-bind:category="category" v-bind:sector="sector" v-bind:language="language" v-bind:auth="auth" v-bind:auth_is_admin="auth_is_admin"></vue-smart-tab-all>
                <vue-smart-tab-sector v-bind:sector="sector" v-bind:auth="auth" v-bind:auth_is_admin="auth_is_admin"></vue-smart-tab-sector>
                <vue-smart-tab-category v-bind:category="category" v-bind:auth="auth" v-bind:auth_is_admin="auth_is_admin"></vue-smart-tab-category>

            </section>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'SmartLayoutIndex',
        data() {
            return {
                category: {},
                sector: {},
                language: {},
                auth: false,
                auth_is_admin: false,
            }
        },

        props: ['review'],
        methods: {

        },
        mounted() {

            axios.post('/smart-response/get-all-category', { category: true, sector: true, language: true })
                .then(response => {

                    this.category = response.data.category;
                    this.language = response.data.language;
                    this.sector = response.data.sector;
                    this.auth = response.data.auth;
                    this.auth_is_admin = response.data.auth_is_admin;
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => {
                });
        }
    }
</script>