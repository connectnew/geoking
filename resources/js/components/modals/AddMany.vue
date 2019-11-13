<template>
    <div>
        <!--Add Many Modal OPEN-->
        <div class="modal fade" id="AddMany" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content reset__popup">
                    <div class="modal-body">
                        <h1 class="mb-3 font-weight-normal font-32">Import locations
                            <a href="#!" class="float-right text-secondary">
                                <i class="fa fa-times font-26 font-weight-normal" data-dismiss="modal"></i>
                            </a>
                        </h1>
                        <p class="mb-3 rating">
                            <img src="/assets/images/raiting_big.png">
                            <img src="/assets/images/raiting_big.png">
                            <img src="/assets/images/raiting_big.png">
                            <img src="/assets/images/raiting_big.png">
                            <img src="/assets/images/raiting_big.png">
                        </p>
                        <h2 class="mb-3 text-muted font-24">Manage multiple locations by importing a spreadsheet</h2>
                        <div class="file_uploadedImgInput pb-3">
                            <div class="file_fileUpload"><span>Select file</span>
                                <input type="file" ref="file" class="upload" id="filePicWithLogo" name="filePicWithLogo" v-on:change="handleFileUpload()">
                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="col-12 text-left">
                                <h3 class="font-22 border-bottom pb-3">
                                    <a href="/source/export-template" class="text-secondary"><i class="fa fa-download"></i> Download the template</a>
                                </h3>
                                <h3 class="font-22 border-bottom pb-3">
                                    <a href="/source/export-sample" class="text-secondary"><i class="fa fa-download"></i> Download sample spreadsheet</a>
                                </h3>
                                <h3 class="font-22 border-bottom pb-3">
                                    <a href="/source/export-attributes" class="text-secondary"><i class="fa fa-download"></i> Download attribute reference spreadsheet</a>
                                </h3>
                                <h3 class="font-22 pb-3">
                                    <a href="#!" class="text-secondary"><i class="fa fa-question-circle-o"></i> Learn how to create an import file</a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'AddMany',
    methods: {
      handleFileUpload() {
        if (this.$refs.file.files.length > 0) {
          let formData = new FormData(),
            this$Root = this.$root;

          formData.append('sources', this.$refs.file.files[0])

          axios.post('/source/import',
            formData,
            {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            }
          ).then(function() {
            this$Root.$emit('sourcesUpdated')
          })
          .catch(function(e) {
            let message = e.toString(),
                errors = []
            try {
              if (e.response.data.errors.length > 1) {
                errors = e.response.data.errors
                message = e.response.data.message
              } else {
                message = e.response.data.errors[0]
              }
            } catch (exception) {
              // do nothing
            }
            this$Root.$emit('showSimpleAlert', message, errors)
          }).finally(function () {
            $('#AddMany').modal('hide')
          })
        }
      }
    }
  }
</script>