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
									{{ memberData.storeName }}<br />
									{{ memberData.userName }}
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
												:readonly="
													$store.state.sessionData
														.SADMIN !== 'Y'
												"
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
								<v-col
									cols="12"
									v-if="error_message"
									class="error--text caption"
								>
									* {{ error_message }}
								</v-col>
								<v-col class="font-weight-bold my-2">
									보상이력
								</v-col>
								<v-col cols="auto">
									<v-btn small @click="moreBtn" block>{{
										moreText
									}}</v-btn>
								</v-col>
								<v-col cols="12">
									<v-card
										class="my-1 pa-2 gry2"
										style="
											max-height: 100px;
											overflow: scroll;
										"
									>
										<div
											v-for="(log, index) in item.log"
											:key="index"
										>
											<span v-if="log.set_cp_month !== 0"
												><span
													v-if="log.set_cp_month > 0"
													>+</span
												>{{ log.set_cp_month }}M</span
											>
											<span v-if="log.set_cp_day !== 0">
												<span v-if="log.set_cp_day > 0"
													>+</span
												>{{ log.set_cp_day }}D</span
											>
											{{
												dateformat(
													"D",
													log.created_at,
													"YYYY/MM/DD"
												)
											}}
											{{ log.saleman.sm_name
											}}<v-btn
												v-if="
													log.sm_seq_no ===
														$store.state.sessionData
															.SSEQNO &&
													$store.state.sessionData
														.SADMIN !== 'Y' &&
													log.set_cp_month > 0
												"
												x-small
												color="error"
												class="float-right"
												@click="
													plusMonth =
														log.set_cp_month * -1
												"
												>되돌리기 </v-btn
											><br />{{ log.cp_memo }}

											<v-divider
												v-if="index < logcount - 1"
												class="my-1"
											></v-divider>
										</div>
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
										v-model="formData.cp_memo"
									></v-textarea>
								</v-col>
							</v-row>
						</v-card>
					</v-form>
				</v-container>
				<BosangLayer002
					:showBosangLayer002.sync="showBosangLayer002"
					:formData.sync="formData"
					@reloadList="reloadList"
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
		memberData: {
			storeName: null,
			userName: null,
		},
		formData: {
			stp_id: null, //plan_id
			new_expired_date: null, //변경만료일
			old_expired_date: null, //기존만료일
			new_purchase_date: null, //plan purchase_date
			old_purchase_date: null, //plan purchase_date
			add_amount_free_time: 0, //변경일수계산

			mobisell_id: null,
			store_name: null,
			set_cp_month: 0,
			set_cp_day: 0,
			ori_date: null,
			set_date: null,
			cp_memo: null,
		},
		item: [],
		logcount: 0,
		expired_date: null,
		error_message: null,
		plusMonth: 0,
		plusDay: 0,
		new_expired_date: null,
		page: 1,
		moreText: "더보기",
		showBosangLayer002: false, //첨부이미지 보기 레이어
	}),
	methods: {
		moreBtn() {
			if (this.page === 1) {
				this.page = 2;
				this.moreText = "닫기";
			} else {
				this.page = 1;
				this.moreText = "더보기";
			}
			this.getData();
		},
		nextClick() {
			this.submitAction();
		},
		//내용호출
		getData() {
			axios
				.get("/api/user/" + this.bosangId + "/edit", {
					params: { page: this.page },
				})
				.then(({ data }) => {
					this.item = data;
					this.logcount = data.log.length;
					this.memberData.userName = data.user.username;
					this.formData.mobisell_id = data.user.username;
					this.memberData.storeName =
						data.user.store_account.store.sto_name;
					this.formData.store_name =
						data.user.store_account.store.sto_name;
					let expr = null;

					if (data.user.store_account.store.store_plans.length > 0) {
						data.user.store_account.store.store_plans.forEach(
							(crud) => {
								if (
									crud.canceled_at === null &&
									this.dateformat(
										"DD",
										crud.expired_date,
										"YYYY/MM/DD"
									) > 0
								) {
									this.formData.stp_id = crud.id;
									this.formData.old_expired_date =
										crud.expired_date;
									this.formData.ori_date = crud.expired_date;
									this.formData.new_purchase_date =
										crud.purchase_date;
									this.formData.old_purchase_date =
										crud.purchase_date;

									expr = crud.expired_date;
									return false;
								}
								if (crud.canceled_at === null) {
									this.formData.stp_id = crud.id;
									this.formData.old_expired_date =
										crud.expired_date;
									this.formData.ori_date = crud.expired_date;
									this.formData.new_purchase_date =
										crud.purchase_date;
									this.formData.old_purchase_date =
										crud.purchase_date;
								}
							}
						);
						this.expired_date = expr;
					}
				});
		},
		plusDate(type, val) {
			if (type === "M") {
				if (
					this.$store.state.sessionData.SADMIN !== "Y" &&
					this.$store.state.sessionData.SUCP <
						parseInt(this.plusMonth) + parseInt(val)
				) {
					this.error_message =
						"가능 보상개월수 보다 많은값을 입력할 수 없습니다.";
				} else {
					this.plusMonth = parseInt(this.plusMonth) + parseInt(val);
					this.error_message = null;
				}
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
		submitAction() {
			this.formData.new_expired_date = this.new_expired_date;
			this.formData.set_date = this.new_expired_date;
			this.formData.add_amount_free_time = this.dateformat("DF", [
				this.formData.old_expired_date,
				this.formData.new_expired_date,
			]);
			this.formData.set_cp_month = this.plusMonth;
			this.formData.set_cp_day = this.plusDay;
			this.showBosangLayer002 = true;
		},
		reloadList() {
			this.$emit("update:itemListReRoad", true);
			this.$emit("update:showBosangLayer001", false);
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
				.format("YYYY-MM-DD");
		},
		plusDay() {
			let today = dayjs();

			let exp =
				this.expired_date === null ? today : dayjs(this.expired_date);
			let new_date = exp.add(this.plusMonth, "month").format();
			this.new_expired_date = dayjs(new_date)
				.add(this.plusDay, "day")
				.format("YYYY-MM-DD");
		},
	},
	mixins: [commonFunction],
};
</script>
