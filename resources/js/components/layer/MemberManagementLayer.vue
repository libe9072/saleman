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
					<v-card class="pa-2">
						<v-row no-gutters>
							<v-col cols="12">
								<v-form
									ref="form"
									v-model="valid"
									lazy-validation
								>
									<v-row no-gutters>
										<v-col
											cols="12"
											class="caption error--text py-1"
											v-if="errorMessage.new"
										>
											* {{ errorMessage.new }}
										</v-col>
										<v-col class="pr-3">
											<v-text-field
												placeholder="이름"
												label="*이름"
												hide-details
												v-model="formData.sm_name"
												@keyup.capture="
													checkId(
														formData.sm_name,
														formData.sm_phone,
														0
													)
												"
											>
											</v-text-field>
											<v-text-field
												placeholder="연락처"
												label="*연락처"
												hide-details
												v-model="formData.sm_phone"
												:rules="[rules.required]"
												@keyup.capture="
													checkId(
														formData.sm_name,
														formData.sm_phone,
														0
													)
												"
												maxLength="13"
												type="tel"
												@keyup="phoneKeyup('formData')"
											>
											</v-text-field>
											<v-text-field
												placeholder="소속/회사"
												label="소속/회사"
												v-model="formData.sm_company"
												hide-details
											>
											</v-text-field>
										</v-col>
										<v-col cols="5" md="3">
											<v-row no-gutters>
												<v-col cols="12" class="mb-2">
													<v-checkbox
														v-model="
															formData.is_admin
														"
														false-value="N"
														true-value="Y"
														label="관리자"
														hide-details
													></v-checkbox>
												</v-col>
												<v-col>
													<v-btn
														color="secondary"
														height="95"
														block
														@click="newSaleman"
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
												v-model="formData.sm_memo"
											></v-textarea>
										</v-col>
									</v-row>
								</v-form>
							</v-col>
							<v-col cols="12" class="my-2">
								<v-card
									class="my-1 pa-2"
									v-for="(item, i) in modifyData"
									:key="i"
								>
									<v-hover v-slot="{ hover }">
										<v-form
											ref="form2"
											v-model="valid2"
											onSubmit="return false;"
										>
											<v-row
												no-gutters
												:class="{ class1: hover }"
											>
												<v-col
													align-self="center"
													cols="auto"
													class="mx-2 body-2"
												>
													{{ allItemCount - i }}
												</v-col>
												<v-col
													><v-row
														no-gutters
														class="pr-2"
													>
														<v-col
															cols="12"
															class="
																caption
																error--text
																py-1
															"
															v-if="
																errorMessage
																	.old[
																	modifyData[
																		i
																	].seq_no
																]
															"
														>
															*
															{{
																errorMessage
																	.old[
																	modifyData[
																		i
																	].seq_no
																]
															}}
														</v-col>
														<v-col class="pr-3">
															<v-text-field
																placeholder="이름"
																label="이름"
																hide-details
																v-model="
																	modifyData[
																		i
																	].sm_name
																"
																:rules="[
																	rules.required,
																]"
																:disabled="
																	item.sm_status !==
																	'Y'
																"
																@keyup.capture="
																	checkId(
																		modifyData[
																			i
																		]
																			.sm_name,
																		modifyData[
																			i
																		]
																			.sm_phone,
																		modifyData[
																			i
																		].seq_no
																	)
																"
															>
															</v-text-field>
															<v-text-field
																placeholder="연락처"
																label="연락처"
																hide-details
																v-model="
																	modifyData[
																		i
																	].sm_phone
																"
																:rules="[
																	rules.required,
																]"
																:disabled="
																	item.sm_status !==
																	'Y'
																"
																maxLength="13"
																type="tel"
																@keyup="
																	phoneKeyup(
																		'modifyData',
																		i
																	)
																"
																@keyup.capture="
																	checkId(
																		modifyData[
																			i
																		]
																			.sm_name,
																		modifyData[
																			i
																		]
																			.sm_phone,
																		modifyData[
																			i
																		].seq_no
																	)
																"
															>
															</v-text-field>
															<v-text-field
																placeholder="소속/회사"
																label="소속/회사"
																v-model="
																	modifyData[
																		i
																	].sm_company
																"
																:disabled="
																	item.sm_status !==
																	'Y'
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
																			modifyData[
																				i
																			]
																				.is_admin
																		"
																		:disabled="
																			item.sm_status !==
																			'Y'
																		"
																		@change="
																			checkAdmin(
																				i
																			)
																		"
																		label="관리자"
																		false-value="N"
																		true-value="Y"
																		hide-details
																	></v-checkbox>
																</v-col>
																<v-col
																	cols="12"
																>
																	<v-text-field
																		v-model="
																			modifyData[
																				i
																			]
																				.usable_cp_month_cap
																		"
																		solo
																		hide-details
																		suffix="M"
																		:disabled="
																			modifyData[
																				i
																			]
																				.is_admin ===
																				'Y' ||
																			item.sm_status !==
																				'Y'
																		"
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
																		@click="
																			modifySaleman(
																				i
																			)
																		"
																		:disabled="
																			item.sm_status !==
																			'Y'
																		"
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
																v-model="
																	modifyData[
																		i
																	].sm_memo
																"
																:disabled="
																	item.sm_status !==
																	'Y'
																"
															></v-textarea>
														</v-col>
														<v-col>
															<v-btn
																x-small
																color="jego"
																dark
																:disabled="
																	item.sm_status !==
																	'Y'
																"
																@click="
																	resetPassword(
																		i
																	)
																"
																>비밀번호
																초기화</v-btn
															>
														</v-col>
														<v-col cols="auto">
															<v-btn
																x-small
																color="black"
																dark
																class="mr-2"
																@click="
																	changeSmStatus(
																		i,
																		item.sm_status
																	)
																"
																>{{
																	modifyData[
																		i
																	]
																		.sm_status ===
																	"Y"
																		? "사용중지"
																		: "사용복구"
																}}</v-btn
															>
														</v-col>
														<v-col cols="auto">
															<v-btn
																x-small
																color="error"
																@click="
																	deleteSmUser(
																		i
																	)
																"
																>삭제</v-btn
															>
														</v-col>
													</v-row>
												</v-col>
											</v-row>
										</v-form>
									</v-hover>
								</v-card>

								<infinite-loading
									:identifier="infiniteId"
									@distance="1"
									spinner="waveDots"
									@infinite="listLoad"
								>
									<div slot="no-more">
										<v-row no-gutters>
											<v-col style="align-self: center">
												<v-divider></v-divider>
											</v-col>
											<v-col
												cols="auto"
												class="mx-2 caption"
											>
												{{ allItemCount }} - LAST
											</v-col>
											<v-col style="align-self: center">
												<v-divider></v-divider>
											</v-col>
										</v-row>
									</div>
									<div slot="no-results">No results</div>
								</infinite-loading>
							</v-col>
						</v-row>
					</v-card>
				</v-container>
			</template>
		</ModalLayer>
	</div>
</template>

<script>
import ModalLayer from "../layout/ModalLayer";
import dataProps from "../../assets/dataProps";
import axios from "axios";
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
		rules: {
			required: (value) => !!value || "필수값입니다.",
			phone: (value) => {
				return (
					// /^\d{2,3}-\d{3,4}-\d{4}$/;

					/^\d{2,3}-\d{3,4}-\d{4}$/.test(value) ||
					"연락처 형식에 맞게 입력해주세요."
				);
			},
		},
		checkValidId: false,
		formData: {
			sm_name: null,
			sm_phone: null,
			sm_company: null,
			sm_memo: null,
			is_admin: "N",
		},
		modifyData: [],
		current_page: 0, //현재페이지
		next_page: 1, //다음페이지
		last_page: 1, //마지막페이지
		allItemCount: 0,
		valid2: true,
		errorMessage: { new: null, old: [] },
		firstOpen: true,
		infiniteId: +new Date(), //페이징용 로드 변수
	}),
	methods: {
		checkId(name, phone, seq_no) {
			let msg = null;
			// 이름 연락처 중복 검사
			if (name && phone) {
				axios
					.get("/api/checkDuplicationData", {
						params: {
							type: "saleman",
							name: name,
							phone: phone,
							seq_no: seq_no,
						},
					})
					.then(({ data }) => {
						if (data.code !== "undefined" && data.code === 1) {
							msg = null;
						} else if (data.message) {
							msg = data.message;
						}
						if (seq_no === 0) {
							this.errorMessage.new = msg;
						} else {
							this.errorMessage.old[seq_no] = msg;
						}
					});
			}
		},
		newSaleman: async function () {
			//저장- > 다음버튼클릭
			await this.validate(); //유효성검사
			if (this.valid === true && this.errorMessage.new === null) {
				await axios
					.post("/api/saleman", {
						_token: this.csrfToken,
						param: this.formData,
					})
					.then(({ data }) => {
						this.$refs.form.reset();
						this.$emit(
							"snackData",
							this.makeSnakeData("등록완료되었습니다.", "success")
						);
						this.firstOpen = true;
						this.infiniteId += 1;
						this.resetValueSearch();
					});
			}
		},
		resetPassword(num) {
			if (
				window.confirm(
					this.modifyData[num].sm_name +
						" 의 비밀번호를 초기화 하시겠습니까?"
				)
			) {
				axios
					.post("/api/saleman/resetPassword?_method=PUT", {
						_token: this.csrfToken,
						seq_no: this.modifyData[num].seq_no,
						params: { type: "mod" },
					})
					.then(({ data }) => {
						this.$emit(
							"snackData",
							this.makeSnakeData(
								"비밀번호 초기화 완료되었습니다.",
								"success"
							)
						);
					});
			}
		},
		deleteSmUser(num) {
			if (
				window.confirm(
					this.modifyData[num].sm_name + " 을 삭제 하시겠습니까?"
				)
			) {
				axios
					.post(
						"/api/saleman/" +
							this.modifyData[num].seq_no +
							"?_method=DELETE",
						{
							_token: this.csrfToken,
							seq_no: this.modifyData[num].seq_no,
							params: { type: "del" },
						}
					)
					.then(({ data }) => {
						this.$emit(
							"snackData",
							this.makeSnakeData("삭제되었습니다.", "success")
						);
						this.firstOpen = true;
						this.infiniteId += 1;
						this.resetValueSearch();
					});
			}
		},
		changeSmStatus: async function (num, flag) {
			let text = flag === "N" ? "사용복구" : "사용중지";
			if (
				window.confirm(
					this.modifyData[num].sm_name +
						" 을 " +
						text +
						" 하시겠습니까?"
				)
			) {
				await axios({
					url: "/api/saleman/" + this.modifyData[num].seq_no,
					method: "post",
					data: {
						_method: "PUT",
						_token: this.csrfToken,
						params: { sm_status: flag === "Y" ? "N" : "Y" },
					},
				}).then(({ data }) => {
					this.$emit(
						"snackData",
						this.makeSnakeData(
							"사용상태 변경 완료되었습니다",
							"success"
						)
					);
					this.firstOpen = true;
					this.infiniteId += 1;
					this.resetValueSearch();
				});
			}
		},
		modifySaleman: async function (num) {
			if (
				window.confirm(
					this.modifyData[num].sm_name +
						" 의 정보를 수정 하시겠습니까?"
				)
			) {
				if (
					this.errorMessage.old[this.modifyData[num].seq_no] !== null
				) {
					this.checkId(
						this.modifyData[num].sm_name,
						this.modifyData[num].sm_phone,
						this.modifyData[num].seq_no
					);
					alert("수정버튼을 다시 클릭해 주세요.");
				} else {
					if (
						this.valid2 === true &&
						this.errorMessage.old[this.modifyData[num].seq_no] ===
							null
					) {
						await axios({
							url: "/api/saleman/" + this.modifyData[num].seq_no,
							method: "post",
							data: {
								_method: "PUT",
								_token: this.csrfToken,
								params: this.modifyData[num],
							},
						}).then(({ data }) => {
							this.$emit(
								"snackData",
								this.makeSnakeData(
									"수정완료되었습니다.",
									"success"
								)
							);
							this.firstOpen = true;
							this.infiniteId += 1;
							this.resetValueSearch();
						});
					}
				}
			}
		},
		// 모든 조건 초기화 함수
		resetValueSearch: function (data) {
			this.current_page = 0;
			this.last_page = 1;
			this.next_page = 1;
			this.modifyData = [];
			this.allItemCount = 0;
		},
		//목록 로드
		listLoad($state) {
			// firstOpen 값을 true 로 넘기면 리스트 리로드시에 초기화
			if (this.firstOpen === true) {
				this.resetValueSearch();
			}
			let param = "";
			param += "&page=" + this.next_page;
			axios.get("/api/saleman?" + param).then(({ data }) => {
				this.current_page = data.current_page;
				this.last_page = data.last_page;
				this.next_page = this.next_page + 1;
				this.allItemCount = data.total;
				data.data.forEach((crud) => {
					if (crud.seq_no) {
						this.modifyData.push(crud);
					}
				});
				$state.loaded();
				if (this.current_page === this.last_page) {
					$state.complete();
				}
			});
			this.firstOpen = false;
		},
		phoneKeyup(val, num) {
			if (val === "formData") {
				if (this.formData.sm_phone.length === 3) {
					this.formData.sm_phone += "-";
				}
				if (this.formData.sm_phone.length === 8) {
					this.formData.sm_phone += "-";
				}
			} else if (val === "modifyData") {
				if (this.modifyData[num].sm_phone.length === 3) {
					this.modifyData[num].sm_phone += "-";
				}
				if (this.modifyData[num].sm_phone.length === 8) {
					this.modifyData[num].sm_phone += "-";
				}
			}
		},
		checkAdmin(i) {
			if (this.modifyData[i].is_admin === "Y") {
				this.modifyData[i].usable_cp_month_cap = 0;
			} else {
				this.modifyData[i].usable_cp_month_cap = 1000;
			}
		},
	},
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