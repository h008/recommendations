<template>
	<div>
		test
	<div id="recommendations-setting-enabled">
		<input id="recommendationsEnabledToggle"
			v-model="enabled"
			class="checkbox"
			checked="checked"
			type="checkbox"
			name="enabled">
		<label for="recommendationsEnabledToggle">{{ t('recommendations', 'Show recommendations') }}</label>
	</div>
	</div>
</template>

<script>


export default {
	name: 'Settings',
	mounted(){
		if(!this.enabled){
			this.$store.dispatch('enabled',true)

		}

	},
	computed: {
		enabled: {
			get() {
				return this.$store.state.enabled
			},
			set(val) {
				this.$store.dispatch('enabled', val)
			},
		},
	},
}
</script>
