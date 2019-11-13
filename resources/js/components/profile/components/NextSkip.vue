<template>
	<div class="col-12 text-center pb-4">
		<a role="button" @click="$emit('validate')">
			<p>
				<button  class="btn profile-btn continue-btn mb-0" style="margin-top: 18px !important;">Continue</button>
			</p>
		</a>
		<p v-if="skip">
			<a role="button" class="skip-txt pointer" @click="next">Skip</a>
		</p>
	</div>
</template>
<script>
	export default {
		name: 'NextSkip',

		props: ['nextStep', 'currentStep', 'skip'],

		methods: {
			next() {
				if(this.currentStep == 5) {
					window.location.href = '/integrate'
				} else {
					this.$emit('change-step', this.nextStep)
				}
			}
		}
	}
</script>