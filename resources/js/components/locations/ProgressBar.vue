<template>
	<div class="progress_wrapper w-100 mt-4 px-2">
		<div class="row">
			<div class="col px-1">
				<div class="progress rounded-0">
					<div class="progress-bar" role="progressbar" :class="[showStep == 1 ? 'w-0' : 'w-100']" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
			<div class="col px-1">
				<div class="progress rounded-0">
					<div class="progress-bar" role="progressbar" :class="[showStep < 3 ? 'w-0' : 'w-100']" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
			<div class="col px-1">
				<div class="progress rounded-0">
					<div class="progress-bar" role="progressbar" :class="{ 'w-0': showStep < 5, 'w-50': showStep == 5, 'w-100': showStep > 5}" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
			<div class="col px-1">
				<div class="progress rounded-0">
					<div class="progress-bar" role="progressbar" :class="{ 'w-0': showStep < 7, 'w-50': showStep == 7, 'w-100': showStep > 7}" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
			<div class="col px-1">
				<div class="progress rounded-0">
					<div class="progress-bar" role="progressbar" :class="{ 'w-0': showStep < 9, 'w-50': showStep == 9, 'w-100': showStep > 9}" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
		</div> 
	</div>
</template>
<script>
	export default {
		name: 'ProgressBar',

		props: ['showStep'],

		data() {
			return {

			}
		}
	}
</script>