<template>
    <div class="modal manage-smart-response-modal" id="smart-response-modal" v-bind:style="modalShow ? 'display: block; overflow-x: hidden; overflow-y: auto;' : 'display: none'" aria-hidden="true">
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

                    <div class="row m-0 box-border-top">
                        <div class="col-12 response-box py-4 px-5">

                            <form class="form-smart-response">
                                <div class="row form-row">

                                    <div class="col-12 form-group pb-0">
                                        <label>Category</label>
                                        <select class="form-control" id="sel-smart-category" v-model="smart.category_id" required>
                                            <option :value="null" disabled>Select category</option>
                                            <option v-for="cat in category" v-bind:value="cat.id">{{ cat.name }}</option>
                                        </select>
                                    </div>

                                    <div class="col-12 form-group pb-0">
                                        <label>Language</label>
                                        <select class="form-control" id="sel-smart-langauge" v-model="smart.langauge_id" required>
                                            <option :value="null" disabled>Select language</option>
                                            <option v-for="lang in language" v-bind:value="lang.id">{{ lang.name }}</option>
                                        </select>
                                    </div>

                                    <div class="col-12 form-group pb-0">
                                        <label>Tonality</label>
                                        <select class="form-control" id="sel-smart-tonality" v-model="smart.positive" required>
                                            <option :value="null" disabled>Select tonality</option>
                                            <option value="1">Positive</option>
                                            <option value="0">Negative</option>
                                        </select>
                                    </div>

                                    <div class="col-12 form-group pb-0">
                                        <label>Business sector</label>
                                        <select class="form-control" id="sel-smart-sector" v-model="smart.sector_id" required>
                                            <option :value="null" disabled>Select business sector</option>
                                            <option v-for="sec in sector" v-bind:value="sec.id">{{ sec.title }}</option>
                                        </select>
                                    </div>

                                    <div class="col-12 form-group pb-0">
                                        <label>Text</label>
                                        <textarea class="form-control" rows="5" v-model="smart.text" required></textarea>
                                    </div>
                                    <div class="col-12 text-right">
                                        <div class="textarea-bottom pr-2 pb-2"></div>
                                    </div>
                                    <div class="col-12 pt-4 pb-3">
                                        <button class="btn btn-blue-large mr-2" @click="submitSmart()"><i class="fa fa-save d-inline-block align-text-middle mr-2" aria-hidden="true"></i> Save</button>
                                        <a href="javascript:void(0)" @click="modalHide()">Cancel</a>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'SmartManageModal',

        data() {
            return {
                sector : {},
                category : {},
                language : {},
                tonality : {},
                smart : {
                    id : null,
                    category_id : null,
                    langauge_id : null,
                    positive : null,
                    sector_id : null,
                    text : null,
                },
                modalShow : false,
            }
        },
        methods: {

            submitSmart () {

                if(!this.smart.category_id){
                    return false;
                }
                if(!this.smart.langauge_id){
                    return false;
                }
                if(!this.smart.positive){
                    return false;
                }
                if(!this.smart.sector_id){
                    return false;
                }
                if(!this.smart.text){
                    return false;
                }

                this.saveSmart();

            },
            saveSmart () {

                axios.post('/smart-response/save', this.smart)
                    .then(response => {

                        if(response.data.status == "ok"){
                            this.modalHide();
                        } else if (response.data.status == "error"){

                            for(let i in response.data.message) {
                                console.log(i);
                            }
                        }
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => {
                    })
            },
            modalHide () {
                this.smart = {
                    id : null,
                    category_id : null,
                    langauge_id : null,
                    positive : null,
                    sector_id : null,
                    text : null,
                };
                this.modalShow = false;
            },

        },
        mounted () {

            this.$root.$on('showSmartManageModal', (smart) => {
                console.log(Object.keys(smart).length);
                if(Object.keys(smart).length){
                    this.smart.id = smart.id;
                    this.smart.category_id = smart.category_id;
                    this.smart.langauge_id = smart.langauge_id;
                    this.smart.positive = smart.positive;
                    this.smart.sector_id = smart.sector_id;
                    this.smart.text = smart.text;
                }
                this.modalShow = true;
            });

            axios.post('/smart-response/get-all-category', {})
                .then(response => {

                    this.category = response.data.category;
                    this.language = response.data.language;
                    this.sector = response.data.sector;
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => {
                })
        }

    }

</script>

