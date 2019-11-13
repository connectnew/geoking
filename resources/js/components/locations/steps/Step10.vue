<template>
	<div>
		<h1 class="mb-2 position-relative">
			<a role="button" class="back-step position-absolute pointer" @click="$emit('change-step', 9)">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
			</a>
			Finish and verify this business
		</h1>

		<p class="mb-3">To manage your listing, you'll need to verify your connection With this business, What you'll get With verification:</p>

		<div class="map-section inquiry-form">
			<div class="row">
				<div class="col-12">
					<ul class="check_list">
						<li>Allow new customers to find you on Google Search Maps</li>
						<li>Promote your business with photos and posts </li>
						<li>Track business analytics to understand your customers</li>
						<li>Respond to customer reviews</li>
					</ul>
				</div>
			</div>
		</div>

		<button class="btn btn-submit mt-4" @click="validateStep" :disabled="disabled">Finish</button>

		<progress-bar :showStep="showStep"></progress-bar>
	</div>
</template>
<script>
	export default {
		name: 'Step10',

		props: ['showStep', 'disabled'],

		data() {
			return {

			}
		},

		computed: {

		},

		mounted() {

		},

		methods: {
			validateStep() {
				this.$emit('change-step', 11)
			}
		},

		created() {

		}

	}
</script>