<template>
	<div class="col-3 d-flex align-items-center blue-bg-col min-height-100 height-auto-mob bg-white-mob"
	:class="{'col-xl-1 col-lg-1': currentStep == 2, 'col-xl-3 col-lg-2': currentStep == 3 || currentStep == 5, 'col-xl-2 col-lg-2': currentStep == 4, }">
		<a role="button" class="mx-lg-auto ml-3 pointer" @click="back">
			<img src="/assets/images/arrow-left.png" class="arrow-img arrow-left-display">
		</a>
	</div>
</template>
<script>
	export default {
		name: 'BackButton',

		props: ['backStep', 'currentStep'],
		methods: {
			back() {
					this.$emit('change-step', this.backStep)	
			}
		}
	}
</script>