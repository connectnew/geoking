<template>
	<div>
		<h1 class="mb-2 position-relative">
			<a role="button" class="back-step position-absolute pointer" @click="$emit('change-step', 3)">
				<i class="fa fa-arrow-left" aria-hidden="true"></i>
			</a>
			Where are you located?
		</h1>

		<p class="mb-3">
			Drag and zoom the map and position the marker on the spot where your business is located.
		</p>

		<div class="map-section">
			<GmapMap
			  :center="center"
			  :zoom="12"
			  style="width: 100%; height: 350px"
			>
			  <GmapMarker
			 	 @dragend="getCoordinates"
			    :position="position"
			    :clickable="true"
			    :draggable="true"
			    @click="center = position"
			  />
			</GmapMap>
		</div>

		<button class="btn btn-submit mt-4" @click="validateStep">Next</button>

		<progress-bar :showStep="showStep"></progress-bar>
	</div>
</template>
<script>
	export default {
		name: 'Step5',

		props: ['showStep', 'center', 'sendData'],

		data() {
			return {
				position: {
					lat: 0,
					lng: 0
				},
				form: {
					lat: 0,
					lng: 0
				}
			}
		},

		watch: {
			'center'(val) {
				this.position = val
				this.form = val
			}
		},

		methods: {
			getCoordinates(e) {
				this.form.lat = e.latLng.lat()
				this.form.lng = e.latLng.lng()
			},

			validateStep() {
				this.$emit('change-step', 6)
				this.$emit('get-params', this.form)
			}
		},

		mounted() {
			this.position = {
				lat: this.center.lat,
				lng: this.center.lng
			}
			
			this.form = {
				lat: this.center.lat,
				lng: this.center.lng
			}

			if(this.sendData.lat && this.sendData.lng) {
				this.position = {
					lat: this.sendData.lat,
					lng: this.sendData.lng
				}
				this.form = {
					lat: this.sendData.lat,
					lng: this.sendData.lng
				}
			}
		}
	}
</script>