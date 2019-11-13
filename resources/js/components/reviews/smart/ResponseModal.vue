<template>
    <div class="modal smart-response-modal" style="overflow-x: hidden; overflow-y: auto;" v-bind:style="show ? 'display: block;' : 'display: none'" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">Smart Response</h3>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-times-circle-o" aria-hidden="true" style="font-size: 25px; outline: 0px;" @click="modalHide()"></i>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <vue-smart-layout-index v-bind:review="review"></vue-smart-layout-index>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'SmartResponseModal',
        data() {
            return {
                show : false,
                review : {},
            }
        },
        methods: {
            modalHide() {
                this.$root.$emit('showSmartSuggested', 0);
                this.$root.$emit('showSmartAll', 0);
                this.$root.$emit('showSmartSector', 0);
                this.$root.$emit('showSmartCategory', 0);
                this.show = false;
                this.review = {};
            },
        },
        mounted () {
            this.$root.$on('showSmartResponseModal', (review) => {
                this.show = true;
                this.review = review;
            });
            this.$root.$on('selectSmartResponse', (smart) => {
                let review = this.review;
                this.modalHide();
                this.$root.$emit('showReviewReplyWithSmartModal', review, smart);
            });
        }

    }

</script>