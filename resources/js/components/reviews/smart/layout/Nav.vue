<template>
    <ul class="menu  d-sm-inline-block  d-md-flex">
        <li v-bind:class="nav.suggested ? 'menu-active' : ''">
            <a href="javascript:void(0)" @click.once="show('suggested')">Suggested Responses </a>
        </li>
        <li v-bind:class="nav.all ? 'menu-active' : ''">
            <a href="javascript:void(0)" @click.once="show('all')">All Responses </a>
        </li>
        <li v-bind:class="nav.sector ? 'menu-active' : ''">
            <a href="javascript:void(0)" @click.once="show('sector')">Responses by Sector</a>
        </li>
        <li v-bind:class="nav.category ? 'menu-active' : ''">
            <a href="javascript:void(0)" @click.once="show('category')">Responses by category</a>
        </li>
    </ul>
</template>

<script>

    export default {
        name: 'SmartLayoutNav',
        data() {
            return {
                nav : {
                    suggested : false,
                    all : false,
                    sector : false,
                    category : false,
                }
            }
        },
        methods: {
            show (tab) {
                switch (tab) {
                    case "suggested" :
                        this.nav = {suggested : true, all : false, sector : false, category : false};
                        this.$root.$emit('showSmartAll', 0);
                        this.$root.$emit('showSmartSector', 0);
                        this.$root.$emit('showSmartCategory', 0);
                        this.$root.$emit('showSmartSuggested', 1);
                        break;
                    case "all" :
                        this.nav = {suggested : false, all : true, sector : false, category : false};
                        this.$root.$emit('showSmartSuggested', 0);
                        this.$root.$emit('showSmartSector', 0);
                        this.$root.$emit('showSmartCategory', 0);
                        this.$root.$emit('showSmartAll', 1);
                        break;
                    case "sector" :
                        this.nav = {suggested : false, all : false, sector : true, category : false};
                        this.$root.$emit('showSmartSuggested', 0);
                        this.$root.$emit('showSmartAll', 0);
                        this.$root.$emit('showSmartCategory', 0);
                        this.$root.$emit('showSmartSector', 1);
                        break;
                    case "category" :
                        this.nav = {suggested : false, all : false, sector : false, category : true};
                        this.$root.$emit('showSmartSuggested', 0);
                        this.$root.$emit('showSmartAll', 0);
                        this.$root.$emit('showSmartSector', 0);
                        this.$root.$emit('showSmartCategory', 1);
                        break;
                }
            }
        }
    }

</script>