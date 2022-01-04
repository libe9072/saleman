/**
 * BosangLayer001.vue
 * @author libe90
 * @date 2021-01-03
 * @comment 기간 보상
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
							<v-row no-gutters>
								<v-col
									cols="12"
									class="text-center font-weight-bold my-2"
								>
									주식회사 애플모바일<br />
									bsc562apple
								</v-col>
								<v-col cols="12">
									<v-row no-gutters justify="center">
										<v-col cols="auto" class="mx-1">
											<v-btn outlined color="gry"
												>RESET</v-btn
											>
										</v-col>
										<v-col cols="3" class="mx-1">
											<v-text-field
												value="3"
												disabled
												hide-details
												dense
											></v-text-field>
										</v-col>
										<v-col cols="auto" class="mx-1">
											<v-btn-toggle
												v-model="toggle_exclusive"
												mandatory
											>
												<v-btn>+ 1M</v-btn>
												<v-btn>+ 3M</v-btn>
												<v-btn>+ 6M</v-btn>
											</v-btn-toggle>
										</v-col>
									</v-row>
								</v-col>
								<v-col cols="12" class="pt-1">
									<v-row no-gutters justify="center">
										<v-col cols="auto" class="mx-1">
											<v-btn outlined color="gry"
												>RESET</v-btn
											>
										</v-col>
										<v-col cols="3" class="mx-1">
											<v-text-field
												value="3"
												disabled
												hide-details
												dense
											></v-text-field>
										</v-col>
										<v-col cols="auto" class="mx-1">
											<v-btn-toggle
												v-model="toggle_exclusive"
												mandatory
											>
												<v-btn>+ 1D</v-btn>
												<v-btn>+ 3D</v-btn>
												<v-btn>+ 6D</v-btn>
											</v-btn-toggle>
										</v-col>
									</v-row>
								</v-col>
								<v-col cols="12" class="text-center my-2">
									보상전 : 2022/12/31 (D-287)<br />
									보상후 : 2023/06/30 (D-542)
								</v-col>
								<v-col class="font-weight-bold my-2">
									보상이력
								</v-col>
								<v-col cols="auto">
									<v-btn small block>더보기</v-btn>
								</v-col>
								<v-col cols="12">
									<v-card class="my-1 pa-2 gry2">
										+6M 2021/12/09 김과장<br />6개월 장기
										선결제 보상 건<br />
										<v-divider class="my-1"></v-divider>
										-2M -14D 2021/11/30 임대리<br />환불
										차감
									</v-card>
								</v-col>
								<v-col cols="12">
									<v-textarea
										label="memo"
										solo
										placeholder="메모 내용을 입력하세요"
										auto-grow
										hide-details
										rows="1"
										v-model="memo"
									></v-textarea>
								</v-col>
							</v-row>
						</v-card>
					</v-form>
				</v-container>
				<BosangLayer002
					:showBosangLayer002.sync="showBosangLayer002"
					:imgData="imgData"
				/>
			</template>
		</ModalLayer>
	</div>
</template>

<script>
import ModalLayer from "../layout/ModalLayer";
import BosangLayer002 from "../layer/BosangLayer002";
import dataProps from "../../assets/dataProps";
import { commonFunction } from "../mixins/commonFunction";
export default {
	name: "BosangLayer001",
	components: {
		ModalLayer,
		BosangLayer002,
	},
	props: {
		showBosangLayer001: {
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
				if (this.showBosangLayer001 === true) {
				}
				return this.showBosangLayer001;
			},
			set(value) {
				this.$emit("update:showBosangLayer001", value);
			},
		},
	},
	data: () => ({
		topProps: dataProps.fullModal.BosangLayer001,
		memo: null,
		showBosangLayer002: false, //첨부이미지 보기 레이어
	}),
	methods: {
		nextClick() {
			this.showBosangLayer002 = true;
		},
	},
	created() {},
	watch: {},
	mixins: [commonFunction],
};
</script>
