/**
 * Sample.vue
 * @author libe90
 * @date   2019-12-10
 * @comment 컴포넌트 모음
 */
<template>
	<v-card>
		<v-form>
			<v-row no-gutter class="pa-2">
				<v-col cols="12">
					<v-row no-gutters>
						<v-col class="text-center font-weight-bold display-2">
							모비셀 기간 보상</v-col
						>
						<v-col cols="auto text-right">
							<v-row no-gutters>
								<v-col cols="12"> 김과장 (34M) </v-col>
								<v-col>
									<v-btn
										small
										color="gry"
										dark
										class="mr-1"
										@click="showPasswordChangeLayer = true"
										>비밀번호 변경</v-btn
									>
									<v-btn
										small
										color="info"
										@click="
											showMemberManagementLayer = true
										"
										>담당자 관리</v-btn
									>
								</v-col>
							</v-row>
						</v-col>
					</v-row>
				</v-col>
				<v-col>
					<v-row no-gutters>
						<v-col class="mr-3">
							<v-text-field
								placeholder="매장명, 모비셀 아이디, 모비고 아이디, 주소, 연락처"
								label="검색어"
								single-line
								v-model="sm_name"
								hide-details
							>
							</v-text-field>
						</v-col>
						<v-col cols="auto">
							<v-btn color="secondary" height="100%">검색</v-btn>
							<v-btn color="accent" height="100%">
								결과내 재검색</v-btn
							>
						</v-col>
					</v-row>
				</v-col>
				<v-col cols="12" class="caption error--text">
					결과가 없습니다.
				</v-col>
				<v-col cols="12">
					<v-row no-gutters class="caption">
						<v-col
							>검색어 :
							<v-chip
								class="ml-1 mb-1"
								small
								close
								label
								close-icon="mdi-close"
								>모바일</v-chip
							>
							<v-chip
								class="ml-1 mb-1"
								small
								close
								label
								close-icon="mdi-close"
								>apple</v-chip
							>
							<v-chip
								class="ml-1 mb-1"
								small
								close
								label
								close-icon="mdi-close"
								>4555</v-chip
							>
							<v-chip
								class="ml-1 mb-1"
								small
								close
								label
								close-icon="mdi-close"
								>서울빌딩</v-chip
							>
							<v-chip
								class="ml-1"
								small
								close
								label
								close-icon="mdi-close"
								>747762</v-chip
							>
						</v-col>
						<v-col cols="auto"> 검색결과 : 총 78개 </v-col>
						<v-col cols="12">
							<v-row no-gutters>
								<v-col cols="auto" class="ml-2">No</v-col>
								<v-col class="text-center">info</v-col>
							</v-row></v-col
						>
						<v-col cols="12"> <v-divider></v-divider></v-col>
						<v-col cols="12">
							<v-card class="my-1" v-for="x in 5" :key="x">
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
											78
										</v-col>
										<v-col>
											<span class="font-weight-bold">
												주식회사 애플<span
													class="error--text"
													>모바일</span
												>
												/ bsc562<span
													class="error--text"
													>apple</span
												> </span
											><br />
											2022/01/22 (D-56), 2021/09/08
											(+3M)<br />
											KT000<span class="error--text"
												>747762</span
											>, B2B, GON, LIVE, LIMIT 2022/11/30,
											2021/12/31(D-84)<br />
											경기 안산시 단원구 광장23로 32,
											<span class="error--text"
												>서울빌딩</span
											>
											103
											<v-btn
												class="ml-1 align-baseline"
												outlined
												color="gry"
												x-small
												>주소복사</v-btn
											>
											<v-btn
												class="ml-1 align-baseline"
												outlined
												color="gry"
												x-small
												@click="
													MapOpen(
														'경기 안산시 단원구 광장23로 32,서울빌딩'
													)
												"
												>지도보기</v-btn
											><br />
											010-2345-6789, 031-223-<span
												class="error--text"
												>4555</span
											><br />
										</v-col>
										<v-col cols="auto" class="pa-1">
											<v-btn
												height="100%"
												color="secondary"
												@click="
													showBosangLayer001 = true
												"
											>
												기간보상
											</v-btn>
										</v-col>
									</v-row>
								</v-hover>
							</v-card>
						</v-col>
					</v-row>
				</v-col>
			</v-row>
			<PasswordChangeLayer
				:showPasswordChangeLayer.sync="showPasswordChangeLayer"
				:imgData="imgData"
			/>
			<BosangLayer001
				:showBosangLayer001.sync="showBosangLayer001"
				:imgData="imgData"
			/>
			<BosangLayer002
				:showBosangLayer002.sync="showBosangLayer002"
				:imgData="imgData"
			/>
			<MemberManagementLayer
				:showMemberManagementLayer.sync="showMemberManagementLayer"
				:imgData="imgData"
			/>
		</v-form>
	</v-card>
</template>
<script>
import axios from "axios";
import PasswordChangeLayer from "../layer/PasswordChangeLayer";
import BosangLayer001 from "../layer/BosangLayer001";
import BosangLayer002 from "../layer/BosangLayer002";
import MemberManagementLayer from "../layer/MemberManagementLayer";
export default {
	components: {
		PasswordChangeLayer,
		BosangLayer001,
		BosangLayer002,
		MemberManagementLayer,
	},
	data: () => ({
		showPasswordChangeLayer: false, //첨부이미지 보기 레이어
		showBosangLayer001: false, //첨부이미지 보기 레이어
		showBosangLayer002: false, //첨부이미지 보기 레이어
		showMemberManagementLayer: false, //첨부이미지 보기 레이어
		searchParams: {
			number: 2, //결합인원(2~5)
			ratePlanType: 130000, //요금제  가격대
			lineNumber: 1, //수정하는 결합회선  아이디(1~5)
			teenagerNumber: 0, //청소년  할인수(0~5)
			type: "1G", //인터넷(랜선)할인  유형
			customRatePlanType: [],
		},
		numberItems: [2, 3, 4, 5],
		priceItems: [80000, 90000, 100000, 110000, 130000],
		teenagerItems: [0, 1, 2, 3, 4, 5],
		typeItems: ["500M", "1G"],
		resultDatas: [], //결과값
	}),
	methods: {
		MapOpen(val) {
			let vals = encodeURIComponent(val);
			window.open(
				"https://map.naver.com/v5/search/" + vals,
				"window팝업"
			);
		},
		totalData(type, line) {
			let plus = "";
			let i = 0;
			axios
				.get("/api/chrg?viewType=" + type, {
					params: {
						number: this.searchParams.number, //결합인원(2~5)
						ratePlanType:
							type === "line"
								? this.searchParams.customRatePlanType[line]
								: this.searchParams.ratePlanType, //요금제  가격대
						lineNumber: line, //수정하는 결합회선  아이디(1~5)
						teenagerNumber: this.searchParams.teenagerNumber, //청소년  할인수(0~5)
						type: this.searchParams.type, //인터넷(랜선)할인  유형
					},
				})
				.then(({ data }) => {
					console.info(data);
					if (type === "total") {
						for (i = 1; i < this.searchParams.ratePlanType; i++) {
							this.searchParams.customRatePlanType[i] =
								this.searchParams.ratePlanType;
						}
						this.resultDatas = data.data;
					} else if (type === "line") {
						for (i = 0; i < this.resultDatas.length; i++) {
							this.resultDatas[i].lines[line] = data.data[i];
						}
					} else if (type === "internet") {
						for (i = 0; i < this.resultDatas.length; i++) {
							this.resultDatas[i].internet = data.data[i];
						}
					} else if (type === "teenager") {
						console.info("i");
						for (i = 0; i < this.resultDatas.length; i++) {
							this.resultDatas[i].teenager = data.data[i];
						}
					}
				});
		},
	},
	watch: {},
	created() {},
	mounted() {},
	computed: {},
};
</script>
<style scoped>
.class1 {
	background-color: rgb(223, 223, 223);
}

.class2 {
}
</style>