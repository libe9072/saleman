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
									{{ formData.store_name }}<br />
									{{ formData.mobisell_id }}
								</v-col>
								<v-col cols="12" class="my-2">
									<span v-if="formData.set_cp_month !== 0"
										><span v-if="formData.set_cp_month > 0"
											>+</span
										>{{ formData.set_cp_month }}M</span
									>
									<span v-if="formData.set_cp_day !== 0">
										<span v-if="formData.set_cp_day > 0"
											>+</span
										>{{ formData.set_cp_day }}D</span
									><br />
									{{ formData.cp_memo }}
								</v-col>
								<v-col cols="12" class="text-center my-2">
									보상전 :
									<span
										v-if="
											parseInt(
												dateformat(
													'D',
													formData.old_expired_date
												)
											) > 0
										"
									>
										{{
											dateformat(
												"D",
												formData.old_expired_date,
												"YYYY/MM/DD"
											)
										}}
										(D-{{
											dateformat(
												"DD",
												formData.old_expired_date
											)
										}}) </span
									><span v-else>만료</span><br />
									보상후 :
									{{
										dateformat(
											"D",
											formData.new_expired_date,
											"YYYY/MM/DD"
										)
									}}
									(D-{{
										dateformat(
											"DD",
											formData.new_expired_date
										)
									}})
								</v-col>
								<v-col
									cols="12"
									v-if="error_message"
									class="error--text"
								>
									{{ error_message }}
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
import axios from "axios";
export default {
	name: "BosangLayer002",
	components: {
		ModalLayer,
	},
	props: {
		showBosangLayer002: {
			default: false,
		},
		formData: {
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
		error_message: null,
	}),
	methods: {
		nextClick() {
			this.submitAction();
		},
		submitAction() {
			let url =
				this.editSeqNo === null
					? ""
					: "/" + this.editSeqNo + "?_method=PUT";

			axios
				.post("/api/user/" + this.formData.stp_id + "?_method=PUT", {
					_token: this.csrfToken,
					params: this.formData,
				})
				.then(({ data }) => {
					if (data.message) {
						this.error_message = data.message;
					} else {
						this.$emit("reloadList");
						if (this.$store.state.sessionData.SADMIN !== "Y") {
							console.info("ssss");

							// vuex session  정보를 강제 update 처리 함
							this.$store.commit({
								type: "sessionDataUpdate",
								datas: data.data,
							});
						}
						this.$emit(
							"snackData",
							this.makeSnakeData("적용되었습니다.", "success")
						);
						this.$emit("update:showBosangLayer002", false);
					}
				});
		},
	},
	created() {},
	watch: {},
	mixins: [commonFunction],
};
</script>
