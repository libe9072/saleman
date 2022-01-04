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
				<v-col cols="12" class="text-center font-weight-bold display-2">
					모비셀 기간 보상
				</v-col>
				<v-col>
					<v-row no-gutters>
						<v-col class="mr-3">
							<v-text-field
								placeholder="이름"
								label="이름"
								v-model="sm_name"
								hide-details
							>
							</v-text-field>
							<v-text-field
								placeholder="전화번호"
								label="전화번호"
								v-model="sm_phone"
								hide-details
							>
							</v-text-field>
							<v-text-field
								placeholder="비밀번호"
								label="비밀번호"
								v-model="sm_password"
								type="password"
								hide-details
							>
							</v-text-field>
						</v-col>
						<v-col cols="3">
							<v-btn
								color="secondary"
								height="100%"
								block
								to="/searchlist"
							>
								로그인</v-btn
							>
						</v-col>
					</v-row>
				</v-col>
				<v-col cols="12" class="caption error--text">
					사용 정지된 계정입니다. 관리자에게 문의하세요.
				</v-col>
			</v-row>
		</v-form>
	</v-card>
</template>
<script>
import axios from "axios";
export default {
	data: () => ({
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