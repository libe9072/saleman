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
				<v-col>
					<v-select
						:items="numberItems"
						v-model="searchParams.number"
						label="총결합인원"
					></v-select>
				</v-col>
				<v-col>
					<v-select
						:items="priceItems"
						v-model="searchParams.ratePlanType"
						label="가격대"
					></v-select>
				</v-col>
				<v-col>
					<v-select
						:items="teenagerItems"
						v-model="searchParams.teenagerNumber"
						label="청소년 수"
					></v-select>
				</v-col>
				<v-col cols="auto">
					<v-btn @click="totalData('total')"> 결과확인 </v-btn>
				</v-col>
			</v-row>
			<v-row class="rounded elevation-1">
				<v-col cols="3">
					<v-row no-gutter>
						<v-col cols="12"> 통신사 </v-col>
						<v-col
							cols="12"
							v-for="x in searchParams.number"
							:key="x"
						>
							<v-select
								:items="priceItems"
								v-model="searchParams.customRatePlanType[x]"
								@change="totalData('line', x)"
								label="가격대"
							></v-select>
						</v-col>
						<v-col cols="12">
							<v-select
								:items="typeItems"
								v-model="searchParams.type"
								@change="totalData('internet')"
								label="인터넷(랜선)할인  유형"
							></v-select>
						</v-col>
						<v-col cols="12">
							<v-select
								:items="teenagerItems"
								v-model="searchParams.teenagerNumber"
								@change="totalData('teenager')"
								label="청소년 수"
							></v-select>
						</v-col>
					</v-row>
				</v-col>
				<v-col
					cols="3"
					v-for="(item, i) in resultDatas"
					:key="i"
					class="py-1"
				>
					<v-row no-gutter>
						<v-col cols="12">
							{{ item.telecom }}
						</v-col>
						<v-col
							cols="12"
							v-for="(line, l) in item.lines"
							:key="l"
						>
							{{ line.planName }}<br />
							{{ line.planPrice }}<br />
							{{ line.discount }}<br />
						</v-col>
						<v-col cols="12">
							{{ item.internet.internetName }}<br />
							{{ item.internet.internetType }}<br />
							{{ item.internet.discount }}<br />
						</v-col>
						<v-col cols="12">
							{{ item.teenager.teenagerNumber }}<br />
							{{ item.teenager.discount }}<br />
						</v-col>
					</v-row>
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