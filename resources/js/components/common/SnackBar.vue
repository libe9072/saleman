/**
 * SnackBar.vue
 * @author libe90
 * @date   2019-12-09
 * @comment 스낵바 Vue
 */
<template>
	<v-snackbar
			v-model="showSanckBar"
			top
			:timeout="timeout"
			:color="sid.color"
	>
		<v-icon color="white">mdi-check-circle</v-icon>
		<span v-html="sid.text"></span>
		<v-btn
				color="pink"
				icon
				@click="showSanckBar = false"
		>
			<v-icon color="white">mdi-close</v-icon>
		</v-btn>
	</v-snackbar>
</template>

<script>

export default {
    name: 'snackBar',
    props: ['visible','sid'],
    data() {
        return {
            timeout: 3000,
        }
    },
    computed: {
        showSanckBar: {
            get () {
                return this.visible
            },
            set (value) {
                if (!value) {
                    this.$emit('close')
                }
            }
        },
    },
}
</script>
