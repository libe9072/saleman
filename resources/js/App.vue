/**
 * App.vue
 * @author libe90
 * @date   2019-12-09
 * @comment 총 부모 Vue
 */
<template>
	<div class="home">
		<v-app
			class="scroll-y"
			id="inspire"
			style="background: #ecedee !important"
		>
			<v-container id="home" tag="section">
				<router-view />
			</v-container>
		</v-app>
	</div>
</template>

<script>
export default {
	name: "App",
	data: () => ({}),
	methods: {},
	watch: {},
};
</script>
