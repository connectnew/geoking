<template>
	<div class="c-select-container"
		@focus="shownList = true"
      @focusout="shownList = false"
      tabindex="0">
		<div class="c-select d-flex flex-wrap justify-content-between align-items-center" @click="shownList = true">
			<span class="c-selected-item" v-if="value.length == 0">{{ placeholder }}</span>
			<template v-else>
				<span class="c-selected-item" v-if="!tags">Selected ({{ value.length }}) items</span>
				<span class="c-shown-item" v-for="(item, index) in value" v-else>
					{{ showTitle(item) }}
					<i class="fa fa-times pl-2" @click="value.splice(index, 1)"></i>
				</span>
			</template>

			<i class="fa fa-chevron-down"></i>
		</div>
		<div class="c-select-list shadow" v-show="shownList">
			<ul>
				<li v-if="allCheckbox" @click="all = !all">
					<input type="checkbox" v-model="all">
					<span>All</span>
				</li>
				<li v-for="(item, index) in options" @click="selectValue(item)">
					<input type="checkbox" :checked="checkedItem(item)">
					<span>{{ showTitle(item) }}</span>
				</li>
			</ul>
		</div>
	</div>
</template>
<script>
	export default {
		name: 'CustomSelect',

		props: {
			allCheckbox: {
				type: Boolean,
				default: false
			},
			tags: {
				type: Boolean,
				default: false
			},
			value: {
				type: Array,
				default: function() {
					return []
				}
			},
			placeholder: {
				type: String,
				default: 'Select ...'
			},
			options: {
				type: Array,
				default: function() {
					return []
				}
			},
			label: {
				type: String,
				default: null
			}
		},

		watch: {
			'all'(val) {
				if(val) {
					for (var i = 0; i < this.options.length; i++) {
						if(!this.value.find(x => x.id === this.options[i].id)) {
							this.value.push(this.options[i])
						}
					}
				}
			},

			'value'(val) {
				if(val && val.length == this.options.length) {
					this.all = true
				} else {
					this.all = false
				}
			}
		},

		data() {
			return {
				all: false,
				shownList: false
			}
		},

		methods: {
			outsideClick() {
				this.shownList = false
			},

			checkedItem(item) {
				for (var i = 0; i < this.value.length; i++) {
					if(this.value[i] == item) {
						return true
					}
				}
				return false
			},

			showTitle(item) {
				if(this.label) {
					return item[this.label]
				} else {
					return item
				}
			},

			selectValue(item) {
				for (var i = 0; i < this.value.length; i++) {
					if(this.value[i] == item) {
						this.value.splice(i, 1)
						return false
					}
				}
				this.value.push(item)
			},

			updateValue() {
				this.$emit('input', this.value);
			}
		}
	}
</script>