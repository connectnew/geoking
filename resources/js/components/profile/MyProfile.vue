<template>
	<div id="main-wrapper" class="min-height-100">
		<transition-group name="fade" mode="out-in">
			<component
			v-for="(item, index) in multiFormComponents"
			:ref="'step-' + (index + 1)"
			:key="index + 1"
			:is="item"
			:formProp="form"
			:currentStep="index + 1"
			v-show="showStep == index + 1"
			@get-params="setParams"
			@change-step="changeStep">
				
				<template v-slot:back>
					<back-button
					:currentStep="index + 1"
					:backStep="index"
					@change-step="changeStep"></back-button>
				</template>

				<template v-slot:next>
					<next-skip
					:currentStep="index + 1"
					:nextStep="index + 2"
					:skip="showSkip(index)"
					@validate="validate(index)"
					@change-step="changeStep"></next-skip>
				</template>

			</component>
		</transition-group>
	</div>
</template>
<script>
	import Step1 from './steps/Step1'
	import Step2 from './steps/Step2'
	import Step3 from './steps/Step3'
	import Step4 from './steps/Step4'
	import Step5 from './steps/Step5'
	import Step6 from './steps/Step6'
	import Step7 from './steps/Step7'

	import BackButton from './components/BackButton'
	import NextSkip from './components/NextSkip'

	export default {
		name: 'MyProfile',

		components: {
			Step1,
			Step2,
			Step3,
			Step4,
			Step5,
			Step6,
			Step7,
			BackButton,
			NextSkip
		},

		props: ['forms'],

		data() {
			return {
				multiFormComponents: ['Step1', 'Step2', 'Step4', 'Step5', 'Step6', 'Step7'],
				showStep: 1,
				hideSkipIndexes: [1, 4], // 1 - Start page; 4 - Tell us about your company
				form: {}
			}
		},

		methods: {
			validate(index) {
				this.$refs['step-' + (index + 1)][0].validateStep()
			},

			changeStep(step) {
				if(step == 7) {
					console.log(this.form)

					axios.post('/api/v1/profile', this.form)
					.then(response => {
						window.location.href = '/'
					})
					.catch(error => {
						console.log(error.response.data.message)	
					})
				} else {
					this.showStep = step
				}
			},

			setParams(data) {
				for (var prop in data) {
					this.form[prop] = data[prop]
				}
			},
			showSkip(index) {
				return !this.hideSkipIndexes.includes(index)
			}
		},

		created() {
			let urlParams = new URLSearchParams(window.location.search);
			let myParam = urlParams.get('currentStep');
			if(myParam){
				this.showStep = myParam
				this.form = this.forms
			}
			
		}
	}
</script>