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
				<router-view v-if="$store.state.isRouterAlive" />
			</v-container>
		</v-app>
	</div>
</template>

<script>
import { Auth } from "./api";
import { mapState } from "vuex";
export default {
	name: "App",
	data: () => ({
		loggedIn: Auth.loggedIn(),
	}),
	methods: {},
	watch: {
		SESSION: {
			handler: function () {
				this.$store.commit({
					type: "routeReload1",
				});
			},
			deep: true,
		},
	},
	computed: {
		...mapState({
			SESSION: (state) => state.sessionData,
			isRouterAlive: (state) => state.isRouterAlive,
		}),
	},
	created() {
		Auth.onChange = (loggedIn) => {
			this.loggedIn = loggedIn;
		};
	},
};
</script>
