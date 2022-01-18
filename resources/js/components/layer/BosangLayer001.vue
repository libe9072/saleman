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
									{{ formData.storeName }}<br />
									{{ formData.userName }}
								</v-col>
								<v-col cols="12">
									<v-row no-gutters justify="center">
										<v-col cols="auto" class="mx-1">
											<v-btn
												outlined
												color="gry"
												@click="dateReset('M')"
												>RESET</v-btn
											>
										</v-col>
										<v-col cols="3" class="mx-1">
											<v-text-field
												hide-details
												dense
												type="number"
												v-model="plusMonth"
											></v-text-field>
										</v-col>
										<v-col cols="auto" class="mx-1">
											<v-btn-toggle
												v-model="toggle_exclusive"
											>
												<v-btn
													@click="plusDate('M', '1')"
													>+ 1M</v-btn
												>
												<v-btn
													@click="plusDate('M', '3')"
													>+ 3M</v-btn
												>
												<v-btn
													@click="plusDate('M', '6')"
													>+ 6M</v-btn
												>
											</v-btn-toggle>
										</v-col>
									</v-row>
								</v-col>
								<v-col
									cols="12"
									class="pt-1"
									v-if="
										$store.state.sessionData.SADMIN === 'Y'
									"
								>
									<v-row no-gutters justify="center">
										<v-col cols="auto" class="mx-1">
											<v-btn
												outlined
												color="gry"
												@click="dateReset('D')"
												>RESET</v-btn
											>
										</v-col>
										<v-col cols="3" class="mx-1">
											<v-text-field
												type="number"
												hide-details
												dense
												v-model="plusDay"
											></v-text-field>
										</v-col>
										<v-col cols="auto" class="mx-1">
											<v-btn-toggle
												v-model="toggle_exclusive"
											>
												<v-btn
													@click="plusDate('D', '1')"
													>+ 1D</v-btn
												>
												<v-btn
													@click="plusDate('D', '3')"
													>+ 3D</v-btn
												>
												<v-btn
													@click="plusDate('D', '6')"
													>+ 6D</v-btn
												>
											</v-btn-toggle>
										</v-col>
									</v-row>
								</v-col>
								<v-col cols="12" class="text-center my-2">
									보상전 :
									<span v-if="expired_date">
										{{
											dateformat(
												"D",
												expired_date,
												"YYYY/MM/DD"
											)
										}}
										(D-{{
											dateformat(
												"DD",
												expired_date,
												"YYYY/MM/DD"
											)
										}}) </span
									><span v-else>만료</span><br />
									보상후 :
									<span v-if="new_expired_date">
										{{
											dateformat(
												"D",
												new_expired_date,
												"YYYY/MM/DD"
											)
										}}
										(D-{{
											dateformat(
												"DD",
												new_expired_date,
												"YYYY/MM/DD"
											)
										}})
									</span>
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
import axios from "axios";
import dayjs from "dayjs";
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
		bosangId: {
			default: null,
		},
	},
	computed: {
		showFullModal: {
			get() {
				if (this.showBosangLayer001 === true) {
					if (this.bosangId !== null) {
						this.getData();
					}
				} else {
					this.reset(); //초기화
					this.$emit("update:bosangId", null); //seq_no초기화
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
		formData: {
			storeName: null,
			userName: null,
		},
		item: [],
		expired_date: null,
		plusMonth: 0,
		plusDay: 0,
		new_expired_date: null,
		showBosangLayer002: false, //첨부이미지 보기 레이어
	}),
	methods: {
		nextClick() {
			this.showBosangLayer002 = true;
		},
		//내용호출
		getData() {
			axios
				.get("/api/user/" + this.bosangId + "/edit")
				.then(({ data }) => {
					console.info(data);
					this.item = data;
					this.formData.userName = data.username;
					this.formData.storeName = data.store_account.store.sto_name;
					let expr = null;

					if (data.store_account.store.store_plans.length > 0) {
						data.store_account.store.store_plans.forEach((crud) => {
							if (
								crud.canceled_at === null &&
								this.dateformat(
									"DD",
									crud.expired_date,
									"YYYY/MM/DD"
								) > 0
							) {
								expr = crud.expired_date;
								return false;
							}
						});
						this.expired_date = expr;
					}
				});
		},
		plusDate(type, val) {
			if (type === "M") {
				this.plusMonth = parseInt(this.plusMonth) + parseInt(val);
			}
			if (type === "D") {
				this.plusDay = parseInt(this.plusDay) + parseInt(val);
			}
		},
		dateReset(type) {
			if (type === "M") {
				this.plusMonth = 0;
			}
			if (type === "D") {
				this.plusDay = 0;
			}
		},
	},
	created() {},
	watch: {
		plusMonth() {
			let today = dayjs();

			let exp =
				this.expired_date === null ? today : dayjs(this.expired_date);
			let new_date = exp.add(this.plusMonth, "month").format();
			this.new_expired_date = dayjs(new_date)
				.add(this.plusDay, "day")
				.format();
		},
		plusDay() {
			let today = dayjs();

			let exp =
				this.expired_date === null ? today : dayjs(this.expired_date);
			let new_date = exp.add(this.plusMonth, "month").format();
			this.new_expired_date = dayjs(new_date)
				.add(this.plusDay, "day")
				.format();
		},
	},
	mixins: [commonFunction],
};
</script>
