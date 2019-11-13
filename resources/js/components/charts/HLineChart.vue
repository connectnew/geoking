<template>
	<div :id="id" style="min-width: 250px; height: 100%; margin: 0 auto"></div>
</template>
<script>
	const Highcharts = require('highcharts')
	require('highcharts/modules/exporting')(Highcharts)

	export default {
		name: 'HLineChart',

		props: {
			id: {
				type: String,
				default: 'custom-line-chart'
			},

			categories: {
				type: Array,
				default: function () {
					return []
				},
			},

			series: {
				type: Array,
				default: function() {
					return []
				}
			}
		},

		data() {
			return {
				hChart: null
			}
		},

		mounted() {
			if($('#' + this.id).length){
				this.hChart = Highcharts.chart(this.id, {
					chart: {
						type: 'areaspline',
					},
					title: {
						text: ''
					},
					legend: {
						enabled:true,
						symbolWidth: 12,
						symbolHeight: 12,
						symbolRadius: 0,
						squareSymbol: false,

					},
					xAxis: {
						categories: this.categories,
						labels: {
							style: {
								fontSize:'12px',
								color:'#262932'
							}
						}             
					},
					yAxis: {
						title: {
							text: ''
						},
						gridLineWidth: 0,
						labels: {
							style: {
								fontSize:'12px', color:'#262932'
							}
						}  
					},
					exporting:{
						enabled:false
					},
					tooltip: {
						shared: false,
						useHTML: true,
						pointFormat: '<b style="font-size:1.5em; font-family:Arial; margin:10px 0 0 0; font-weight:bold; ">{point.y}</b> ', 
					},
					credits: {
						enabled: false
					},
					plotOptions: {
						areaspline: {
							fillOpacity: 1
						}
					},
					series: this.series
				});
			}
		},

		watch: {
			'categories' (val) {
				this.hChart.update({ xAxis: { categories: val } })
			},
			'series' (val) {
				for (let i=0, len=val.length; i<len; i++) {
					this.hChart.series[i].update({ data: val[i].data })
				}
			}
		},

		methods: {

		}
	}
</script>