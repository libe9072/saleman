/**
 * Sample.vue
 * @author libe90
 * @date   2019-12-10
 * @comment 컴포넌트 모음
 */
<template>
	<v-form>
		<v-row no-gutter class="pa-2">
			<v-col>
				<v-row no-gutters>
					<v-col class="mr-3">
						<v-combobox
							v-model="search"
							:search-input.sync="searchs"
							hide-selected
							label="검색어"
							multiple
							deletable-chips
							hint="매장명, 모비셀 아이디, 모비고 아이디, 주소, 연락처"
							persistent-hint
							small-chips
						>
						</v-combobox>
					</v-col>
				</v-row>
			</v-col>
			<v-col cols="12">
				<v-row no-gutters class="caption">
					<v-col
						cols="12"
						class="text-right"
						v-if="$store.state.sessionData.SADMIN === 'Y'"
					>
						<v-row no-gutters>
							<v-col> 검색결과 : 총 {{ allItemCount }}개 </v-col>
							<v-col cols="auto" class="pl-2">
								<v-btn
									color="#00A651"
									outlined
									x-small
									class="mr-1 font-weight-regular"
								>
									<ExcelDown
										:fetch="excelRead"
										:fields="excelData.json_fields"
										worksheet="My Worksheet"
										:name="`회원목록` + now + `.xls`"
										v-model="excelDataDown"
										>엑셀 다운로드</ExcelDown
									>
								</v-btn>
							</v-col>
							<!-- <v-col cols="auto" class="pl-2">
								<v-btn
									color="primary"
									x-small
									class="mr-1 font-weight-regular"
									@click="updateMobigo"
									>모비고매칭
								</v-btn>
							</v-col> -->
						</v-row>
					</v-col>
					<v-col cols="12">
						<v-row no-gutters>
							<v-col cols="auto" class="ml-2">No</v-col>
							<v-col class="text-center">info</v-col>
						</v-row></v-col
					>
					<v-col cols="12"> <v-divider></v-divider></v-col>
					<v-col cols="12">
						<v-card
							class="my-1"
							v-for="(item, i) in items"
							:key="i"
						>
							<v-hover>
								<v-row
									no-gutters
									slot-scope="{ hover }"
									:class="`${hover ? 'class1' : 'class2'}`"
								>
									<v-col
										align-self="center"
										cols="auto"
										class="mx-2 body-2"
									>
										{{ allItemCount - i }}
									</v-col>
									<v-col>
										<span class="font-weight-bold">
											<span
												v-html="
													textpWithHilght(
														item.sto_name
													)
												"
											></span>
											/
											<span
												v-html="
													textpWithHilght(
														item.username
													)
												"
											></span>
										</span>
										<br />
										<span v-if="item.expired_date">
											{{
												dateformat(
													"D",
													item.expired_date,
													"YYYY/MM/DD"
												)
											}}
											(D-{{
												dateformat(
													"DD",
													item.expired_date,
													"YYYY/MM/DD"
												)
											}}) </span
										><span v-else>만료</span>,
										{{
											dateformat(
												"D",
												item.created_at,
												"YYYY/MM/DD"
											)
										}}
										(+{{
											dateformat(
												"DM",
												item.created_at,
												"YYYY/MM/DD"
											) * -1
										}}M)<br />
										<span v-if="item.mobigo_user_id">
											<span
												v-html="
													textpWithHilght(
														item.mobigo_user_id
													)
												"
											></span
											>, {{ item.group_type }},
											{{ item.group_code }},
											{{ item.payment_status }},
											{{ item.pay_type }},
											{{ item.mobigo_live_start_date }},
											{{ item.mobigo_live_end_date }}
											<span
												v-if="
													dateformat(
														'DD',
														item.mobigo_live_end_date
													) > 0
												"
											>
												(D-{{
													dateformat(
														"DD",
														item.mobigo_live_end_date,
														"YYYY/MM/DD"
													)
												}}) </span
											><br
										/></span>
										<span
											v-html="
												textpWithHilght(
													item.sto_addr_line1 +
														' ' +
														item.sto_addr_line2
												)
											"
										></span>
										<v-btn
											class="ml-1 align-baseline"
											outlined
											color="gry"
											x-small
											@click="
												copyToClipboard(
													item.sto_addr_line1 +
														' ' +
														item.sto_addr_line2
												)
											"
											>주소복사</v-btn
										>
										<v-btn
											class="ml-1 align-baseline"
											outlined
											color="gry"
											x-small
											@click="
												MapOpen(
													item.sto_addr_line1 +
														' ' +
														item.sto_addr_line2
												)
											"
											>지도보기</v-btn
										><br />
										<a
											v-bind:href="
												`tel:` + item.sto_phone_number
											"
											v-html="
												textpWithHilght(
													item.sto_phone_number
												)
											"
										></a
										>,
										<a
											v-bind:href="
												`tel:` + item.sto_mobile_number
											"
											v-html="
												textpWithHilght(
													item.sto_mobile_number
												)
											"
										></a
										><br />
									</v-col>
									<v-col cols="auto" class="pa-1">
										<v-btn
											height="100%"
											color="secondary"
											x-small
											@click="BosangLayer001Btn(item.id)"
										>
											기간보상
										</v-btn>
									</v-col>
								</v-row>
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
									<v-col cols="auto" class="mx-2 caption">
										{{ allItemCount }} - LAST
									</v-col>
									<v-col style="align-self: center">
										<v-divider></v-divider>
									</v-col>
								</v-row>
							</div>
							<div slot="no-results">결과가 없습니다.</div>
						</infinite-loading>
					</v-col>
				</v-row>
			</v-col>
		</v-row>
		<BosangLayer001
			:showBosangLayer001.sync="showBosangLayer001"
			:bosangId.sync="bosangId"
			:itemListReRoad.sync="itemListReRoad"
		/>
		<BosangLayer002 :showBosangLayer002.sync="showBosangLayer002" />
		<SnackBar
			:visible="showSnackBar"
			:sid="snackData"
			@close="showSnackBar = false"
		/>
	</v-form>
</template>
<script>
import axios from "axios";
import BosangLayer001 from "../layer/BosangLayer001";
import BosangLayer002 from "../layer/BosangLayer002";
import { commonFunction } from "../mixins/commonFunction";
import SnackBar from "../common/SnackBar";
import ExcelDown from "../common/ExcelDown";
export default {
	components: {
		BosangLayer001,
		BosangLayer002,
		SnackBar,
		ExcelDown,
	},
	data: () => ({
		showSnackBar: false,
		snackData: "",
		showBosangLayer001: false, //첨부이미지 보기 레이어
		showBosangLayer002: false, //첨부이미지 보기 레이어
		items: [],
		now: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
			.toISOString()
			.substr(0, 10),
		current_page: 0, //현재페이지
		next_page: 1, //다음페이지
		last_page: 1, //마지막페이지
		allItemCount: 0,
		firstOpen: true,
		infiniteId: +new Date(), //페이징용 로드 변수
		search: [],
		bosangId: null,
		itemListReRoad: false,
		excelDataDown: false,
		excelData: {
			json_fields: {
				id: { val: "id" },
				username: { val: "username" },
				pay_type: { val: "pay_type" },
				expired_date: { val: "expired_date" },
				mobigo_live_start_date: {
					val: "mobigo_live_start_date",
				},
				mobigo_live_end_date: {
					val: "mobigo_live_end_date",
				},
			},
			json_data: [],
			json_meta: [
				[
					{
						key: "charset",
						value: "utf-8",
					},
				],
			],
		},
	}),
	methods: {
		//엑셀호출
		excelRead: async function () {
			this.excelData.json_data = [];
			let setExcelData = false; // 데이터 셋팅이 완료 될 경우 true
			await axios.get("/api/user?return_type=E", {}).then(({ data }) => {
				setExcelData = true;
				data.forEach((crud) => {
					if (crud.id) {
						this.excelData.json_data.push(crud);
					}
				});
			});
			if (setExcelData === true) {
				return this.excelData.json_data;
			}
		},
		updateMobigo() {
			// 모비고update
			axios
				.post("/api/saleman/updateMobigo?_method=PUT", {
					_token: this.csrfToken,
					params: { type: "mod" },
				})
				.then(({ data }) => {
					console.info(data);
				});
		},
		copyToClipboard(text) {
			const element = document.createElement("textarea");
			element.value = text;
			element.setAttribute("readonly", "");
			element.style.position = "absolute";
			element.style.left = "-9999px";
			document.body.appendChild(element);
			element.select();
			var returnValue = document.execCommand("copy");
			document.body.removeChild(element);
			if (!returnValue) {
				throw new Error("copied nothing");
			}
		},
		BosangLayer001Btn(val) {
			this.bosangId = val;
			this.showBosangLayer001 = true;
		},
		MapOpen(val) {
			let vals = encodeURIComponent(val);
			window.open(
				"https://map.naver.com/v5/search/" + vals,
				"window팝업"
			);
		},
		setSnackData: function (data) {
			//스낵바 부모액션
			this.snackData = data;
			this.showSnackBar = true;
		},
		textpWithHilght: function (text) {
			if (text !== null) {
				for (var key in this.search) {
					var crud = this.search[key];
					if (text.includes(crud)) {
						return text.replace(
							crud,
							'<span class="error--text">' + crud + "</span>"
						);
					}
				}
			}
			return text;
		},
		//목록 로드
		listLoad($state) {
			// firstOpen 값을 true 로 넘기면 리스트 리로드시에 초기화
			if (this.firstOpen === true) {
				this.resetValueSearch();
			}
			let param = "";
			param += "&page=" + this.next_page;
			axios
				.get("/api/user?" + param, {
					params: { search: this.search },
				})
				.then(({ data }) => {
					this.current_page = data.current_page;
					this.last_page = data.last_page;
					this.next_page = this.next_page + 1;
					this.allItemCount = data.total;
					for (var key in data.data) {
						var crud = data.data[key];
						if (crud.id) {
							this.items.push(crud);
						}
					}
					$state.loaded();
					if (this.current_page === this.last_page) {
						$state.complete();
					} else if (
						this.$store.state.sessionData.SADMIN !== "Y" &&
						this.current_page > 1
					) {
						$state.complete();
					}
				});
			this.firstOpen = false;
		},
		// 모든 조건 초기화 함수
		resetValueSearch: function (data) {
			this.current_page = 0;
			this.last_page = 1;
			this.next_page = 1;
			this.items = [];
			this.allItemCount = 0;
		},
	},
	watch: {
		search() {
			this.firstOpen = true;
			this.infiniteId += 1;
			this.resetValueSearch();
		},
		itemListReRoad(val) {
			if (val === true) {
				this.firstOpen = true;
				this.infiniteId += 1;
				this.resetValueSearch();
				this.itemListReRoad = false;
			}
		},
	},
	created() {},
	mounted() {},
	computed: {},
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