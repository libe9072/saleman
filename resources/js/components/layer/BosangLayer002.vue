/**
 * BosangLayer002.vue
 * @author libe90
 * @date 2021-01-03
 * @comment 기간 보상 처리
*/
<template>
	<div>
		<ModalLayer
			:visible="showFullModal"
			@closed="showFullModal = false"
			:topProps="topProps"
			@nextClick="nextClick"
		>
			<template v-slot:viewContent>
				<v-container>
					<v-form>
						<v-card class="pa-2">
							<v-row no-gutters class="text-center">
								<v-col
									cols="12"
									class="text-center font-weight-bold my-2"
								>
									주식회사 애플모바일<br />
									bsc562apple
								</v-col>
								<v-col cols="12" class="my-2">
									+3M +17D<br />
									장기 선결재 보상건
								</v-col>
								<v-col cols="12" class="text-center my-2">
									보상전 : 2022/12/31 (D-287)<br />
									보상후 : 2023/06/30 (D-542)
								</v-col>
								<v-col cols="12" class="error--text">
									안되요 안되요
								</v-col>
							</v-row>
						</v-card>
					</v-form>
				</v-container>
			</template>
		</ModalLayer>
	</div>
</template>

<script>
import ModalLayer from "../layout/ModalLayer";
import dataProps from "../../assets/dataProps";
import { commonFunction } from "../mixins/commonFunction";
export default {
	name: "BosangLayer002",
	components: {
		ModalLayer,
	},
	props: {
		showBosangLayer002: {
			default: false,
		},
		imgData: {
			// 조건
			default: [],
		},
	},
	computed: {
		showFullModal: {
			get() {
				if (this.showBosangLayer002 === true) {
				}
				return this.showBosangLayer002;
			},
			set(value) {
				this.$emit("update:showBosangLayer002", value);
			},
		},
	},
	data: () => ({
		topProps: dataProps.fullModal.BosangLayer002,
		memo: null,
	}),
	methods: {},
	created() {},
	watch: {},
	mixins: [commonFunction],
};
</script>
