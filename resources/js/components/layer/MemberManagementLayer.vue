/**
 * MemberManagementLayer.vue
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
							<v-row no-gutters>
								<v-col cols="12">
									<v-row no-gutters>
										<v-col class="pr-3">
											<v-text-field
												placeholder="이름"
												label="이름"
												v-model="sm_name"
												hide-details
											>
											</v-text-field>
											<v-text-field
												placeholder="연락처"
												label="연락처"
												v-model="sm_phone"
												hide-details
											>
											</v-text-field>
											<v-text-field
												placeholder="소속/회사"
												label="소속/회사"
												v-model="sm_password"
												hide-details
											>
											</v-text-field>
										</v-col>
										<v-col cols="5" md="3">
											<v-row no-gutters>
												<v-col cols="12" class="mb-2">
													<v-checkbox
														v-model="checkbox"
														label="관리자"
														hide-details
													></v-checkbox>
												</v-col>
												<v-col>
													<v-btn
														color="secondary"
														height="95"
														block
													>
														신규등록</v-btn
													>
												</v-col>
											</v-row>
										</v-col>
										<v-col cols="12" class="mt-2 mb-2">
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
								</v-col>
								<v-col cols="12" class="my-2">
									<v-card
										class="my-1 pa-2"
										v-for="x in 5"
										:key="x"
										:disabled="x % 2 === 1"
									>
										<v-hover>
											<v-row
												no-gutters
												slot-scope="{ hover }"
												:class="`${
													hover ? 'class1' : 'class2'
												}`"
											>
												<v-col
													align-self="center"
													cols="auto"
													class="mx-2 body-2"
												>
													7
												</v-col>
												<v-col
													><v-row
														no-gutters
														class="pr-2"
													>
														<v-col class="pr-3">
															<v-text-field
																placeholder="이름"
																label="이름"
																v-model="
																	sm_name
																"
																hide-details
															>
															</v-text-field>
															<v-text-field
																placeholder="연락처"
																label="연락처"
																v-model="
																	sm_phone
																"
																hide-details
															>
															</v-text-field>
															<v-text-field
																placeholder="소속/회사"
																label="소속/회사"
																v-model="
																	sm_password
																"
																hide-details
															>
															</v-text-field>
														</v-col>
														<v-col cols="5" md="3">
															<v-row no-gutters>
																<v-col
																	cols="12"
																>
																	<v-checkbox
																		v-model="
																			checkbox
																		"
																		label="관리자"
																		hide-details
																	></v-checkbox>
																</v-col>
																<v-col
																	cols="12"
																>
																	<v-text-field
																		v-model="
																			sm_name
																		"
																		solo
																		hide-details
																		suffix="M"
																	>
																	</v-text-field>
																</v-col>
																<v-col
																	class="mt-1"
																>
																	<v-btn
																		color="info"
																		block
																		height="50"
																	>
																		수정</v-btn
																	>
																</v-col>
															</v-row>
														</v-col>
														<v-col
															cols="12"
															class="mt-2 mb-2"
														>
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
												</v-col>
											</v-row>
										</v-hover>
									</v-card>
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
	name: "MemberManagementLayer",
	components: {
		ModalLayer,
	},
	props: {
		showMemberManagementLayer: {
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
				if (this.showMemberManagementLayer === true) {
				}
				return this.showMemberManagementLayer;
			},
			set(value) {
				this.$emit("update:showMemberManagementLayer", value);
			},
		},
	},
	data: () => ({
		topProps: dataProps.fullModal.MemberManagementLayer,
		memo: null,
	}),
	methods: {},
	created() {},
	watch: {},
	mixins: [commonFunction],
};
</script>

<style scoped>
.class1 {
	background-color: rgb(223, 223, 223);
}

.class2 {
}
</style>