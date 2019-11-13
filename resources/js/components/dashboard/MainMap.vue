<template>
	<GmapMap
			:center="centerGMap"
			:zoom="listings[0] && isValidLatLong(listings[0].latitude, listings[0].longitude) ? 8 : 2"
			style="width: 100%; height: 350px">
		<GmapMarker
				v-for="(address, index) in listings"
				v-if="isValidLatLong(address.latitude, address.longitude)"
				:key="index"
				:position="addressCoordinates(index)"
				:icon="icon"
				:clickable="true"/>
	</GmapMap>
</template>
<script>
	export default {
		name: 'MainMap',

		props: ['user'],

		data() {
			return {
				defaultLatLng: {
					lat: 25,
					lng: 55.33333
				},
				listings: [],
				icon: {
                url: '/assets/images/icons/map_location_small.png'
            }
			}
		},

		methods: {
			addressCoordinates(index) {
				return  {
					lat: Number(this.listings[index].latitude),
					lng: Number(this.listings[index].longitude)
				};
			},
			isValidLatLong: function(latitude, longitude) {
				let lat = Number.parseFloat(latitude),
					lng = Number.parseFloat(longitude)

				return !isNaN(lat) && !isNaN(lng) && (lat != 0 || lng != 0);
			},
		},

		computed: {
			centerGMap () {
				for (let i=0, len=this.listings.length; i<len; i++) {
					let coordinates = this.addressCoordinates(i)
					if (!isNaN(coordinates.lat) && !isNaN(coordinates.lng) && (coordinates.lat != 0 || coordinates.lng != 0)) {
						return coordinates;
					}
				}
				return this.defaultLatLng
			}
		},

		created() {
			axios.get('/api/v1/locations')
			.then(response => {
				this.listings = response.data
			})
			.catch(error => {
							
			})
		}
	}
</script>