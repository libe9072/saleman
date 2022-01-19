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
				<v-card>
					<v-row no-gutter class="pa-2">
						<v-col cols="12">
							<MainHeader v-if="loggedIn" />
						</v-col>
						<v-col cols="12">
							<router-view v-if="$store.state.isRouterAlive" />
						</v-col>
					</v-row>
				</v-card>
			</v-container>
		</v-app>
	</div>
</template>

<script>
import MainHeader from "./components/layout/MainHeader";
import { Auth } from "./api";
import { mapState } from "vuex";
export default {
	name: "App",
	components: {
		MainHeader,
	},
	data: () => ({
		loggedIn: Auth.loggedIn(),
	}),
	methods: {},
	watch: {
		// SESSION: {
		// 	handler: function () {
		// 		this.$store.commit({
		// 			type: "routeReload1",
		// 		});
		// 	},
		// 	deep: true,
		// },
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
