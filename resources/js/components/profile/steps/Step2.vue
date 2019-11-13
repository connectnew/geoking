<template>
	<div class="row">

		<slot name="back"></slot>

		<div class="col-xl-10 col-lg-10 col-12 inquiry-form plr-50 profile_creation_sector_page py-4">
			<div class="row">
				<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 text-center" v-for="(item, index) in services" @click="active(item)"> 
					<div class="sector_step_box" :class="{'active-serv': item.active}">
						<div class="icon_wrap"><img :src="item.img_url" :title="item.title"></div>
						<h3>{{ item.title }}</h3>
						<p>{{ item.description }}</p>
						<!-- <div class="footer">
							<ul>
								<li>
									<a role="button">
										<i class="fa fa-eye"></i>
										Preview
									</a>
								</li>
								<li @click="item.active = !item.active">
									<a role="button">
										<i class="fa fa-check-circle green-text" v-if="item.active"></i>
										Activate
									</a>
								</li>
							</ul>
						</div> -->
					</div>
				</div>
			</div>

			<div class="row">
				<slot name="next"></slot>
			</div>
		</div>

		<div class="col-xl-1 col-lg-1 d-lg-block d-none col-2 blue-bg-col min-height-100"></div>
	</div>
</template>
<script>
	export default {
		name: 'Step2',

		props: ['formProp'],

		data() {
			return {
				services: [
				{
					id: 7,
					active: false,
					title: 'Generic',
					description: 'Select this template if you opt to go for a for generic dashboard.',
					img_url: 'assets/images/generic.png'
				},
				{
					id: 1,
					active: false,
					title: 'Transport',
					description: 'Airport Terminals, Metro stations, Bus stations, Trains stations, Trains stations, Taxi stops, Parkings, other',
					img_url: 'assets/images/transport.png'
				},
				{
					id: 2,
					active: false,
					title: 'Retail',
					description: 'Retail Banks, Fashion shops, Electronics stores, Automotive, Gyms, Petrol stations, large formats, Rent a car, Homecare,',
					img_url: 'assets/images/retail_icon.png'
				},
				{
					id: 3,
					active: false,
					title: 'Food and Beverage',
					description: 'QSR, Coffee shops, Delis, Restaurants, Catering, Supermarkets, Groceries, Street food, dine-ins, canteens, ice-cream parlors, or another form provider of food to the public.',
					img_url: 'assets/images/food_and_beverage_icon.png'
				},
				{
					id: 4,
					active: false,
					title: 'Healthcare',
					description: 'Clinics, Hospital, Dentists, GPs, Labs, emergencies, Pharmacies, Seniors homes, Vets, Emergencies, Health providers, Specialists, Kine, oncology, nutrionists, psys, opticians, homecare, radiology, other.',
					img_url: 'assets/images/healthcare_icon.png'
				},
				{
					id: 5,
					active: false,
					title: 'Entertainment',
					description: 'Parcs, Cinemas, Theater, Events, Stadiums, Musuems, Historical sites, Tourism, Wildlife, Marina, Fauna, other',
					img_url: 'assets/images/entertainment_icon.png'
				},
				{
					id: 6,
					active: false,
					title: 'Hospitality',
					description: 'Hotels, Beauty parlors,  Motels, Lounges, Resorts, Compounds, Residencial units, B&B, other.',
					img_url: 'assets/images/hospitality_icon.png'
				},
				{
					id: 8,
					active: false,
					title: 'Public Service',
					description: 'Police stations, Fire stations,Voting stations, Ministries, Gov Agencies, Municipalities, Embassies, other',
					img_url: 'assets/images/public_service_icon.png'
				},
				{
					id: 9,
					active: false,
					title: 'Education',
					description: 'Schools, Universities, Training centers, Institutes, Kindergardens, Libraries, Business schools,other',
					img_url: 'assets/images/education_icon.png'
				},
				]
			}
		},

		methods: {
			validateStep: function() {
				let data = {
					services: []
				}

				for (var i = 0; i < this.services.length; i++) {
					if(this.services[i].active) {
						data.services.push(this.services[i].id)
					}
				}

				if(data.services.length == 1) {
					this.$emit('get-params', data)
					this.$emit('change-step', 3)
				}
			},

			active(item) {
				for (var i = 0; i < this.services.length; i++) {
					if(this.services[i].id == item.id) {
						this.services[i].active = true
					} else {
						this.services[i].active = false
					}
				}
				// item.active = !item.active
			}
			
		},
		created() {
			let urlParams = new URLSearchParams(window.location.search);
			let myParam = urlParams.get('currentStep');
			if(myParam){
				this.form = this.formProp
			}
			
		}
	}
</script>