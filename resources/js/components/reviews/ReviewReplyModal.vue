<template>
    <div class="modal manage-reviews-modal" id="review-reply-modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times-circle-o" aria-hidden="true" style="font-size: 25px; outline: 0px;"></i></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body pb-0">
                    <div class="row ml-2 mr-2">
                        <div class="col-12 col-md-3 col-lg-2 col-xl-3 manage-reviews-img"><img :src="review.reviewer_photo_url" class="rounded-circle img-fluid"></div>
                        <div class="col-12 col-md-9 col-lg-10 col-xl-9 manage-reviews-detail order-sm-2 order-md-1">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-8"><h1 class="modal-title">{{ review.reviewer_name }}</h1></div>
                                        <div class="col-4">
                                            <p class="time">{{ review.created_at_for_humans }}</p>
                                        </div>
                                    </div>
                                    <p>{{  review.location.title }}</p>
                                    <p>{{  review.location.country }}, {{  review.location.state }}, {{  review.location.city }}</p>
                                    <p>{{  review.location.street }}, {{ review.location.zip }}</p>
                                    <div class="star-ratings d-inline-block w-100 mt-3">
                                        <ul>
                                            <li v-for="n in 5"><i :class="review.rating < n ? 'fa fa-star-o' : 'fa fa-star'" aria-hidden="true"></i></li>
                                        </ul>
                                    </div>
                                    <p class="description mt-2">{{ review.comment }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row m-0 box-border-top">
                        <div class="col-12 reply-box py-4 px-5">
                            <div class="row">
                                <div class="col-12 pb-0">
                                    <textarea v-model="reply"></textarea>
                                </div>
                                <div class="col-12 text-right">
                                    <div class="textarea-bottom pr-2 pb-2"></div>
                                </div>
                                <div class="col-12 pt-4 pb-3">
                                    <button class="btn btn-blue-large mr-2" @click="updateReply()"><i class="fa fa-reply d-inline-block align-text-middle mr-2" aria-hidden="true"></i> Public Reply</button>
                                    <a href="javascript:void(0)" data-dismiss="modal" title="Cancel" class="modalCancel">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import moment from 'moment'

  export default {
    name: 'ReviewReplyModal',
    data() {
      return {
        reply: '',
        review: {
          id: 0,
          created_at_for_humans: '',
          reviewer_photo_url: '',
          reviewer_name: '',
          reviewer_is_anonymous: false,
          rating: 0,
          comment: '',
          location: {
            id: 0,
            title: '',
            address: '',
            city: '',
            country: '',
            state: '',
            street: '',
            zip: ''
          }
        },
      }
    },
    methods: {
      updateReply: function () {
        if (this.reply.length > 0) {
          axios.post('/review-reply/update', { review_id: this.review.id, reply: this.reply })
          .then(response => {
            this.$root.$emit('updateReviewsTable')
          })
          .catch(error => {
            console.log(error)
          })
          .finally(() => {
            $('#review-reply-modal').modal('hide')
            this.reply = ''
          })
        }
      }
    },
    mounted () {
      this.$root.$on('showReviewReplyModal', (review) => {
        this.review = Object.assign({}, this.review, review)
        $('#review-reply-modal').modal('show')
      })
      this.$root.$on('showReviewReplyWithSmartModal', (review, smart) => {
          this.review = Object.assign({}, this.review, review);
          this.reply = smart.text;
          $('#review-reply-modal').modal('show');
      })
    },
    filters: {
      datetimeFormat: function (value) {
        return moment(value, 'YYYY-MM-DD HH:mm:ss').format('hh:mm A');
      },
    }
  }
</script>